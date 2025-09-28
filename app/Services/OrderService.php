<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;

class OrderService
{
    public function __construct(
        protected AffiliateService $affiliateService
    ) {}

    /**
     * Process an order and log any commissions.
     * This should create a new affiliate if the customer_email is not already associated with one.
     * This method should also ignore duplicates based on order_id.
     *
     * @param  array{order_id: string, subtotal_price: float, merchant_domain: string, discount_code: string, customer_email: string, customer_name: string} $data
     * @return void
     */
    public function processOrder(array $data)
    {
        // Check if order already exists
        if (Order::where('external_order_id', $data['order_id'])->exists()) {
            return;
        }

        // Find merchant by domain
        $merchant = Merchant::where('domain', $data['merchant_domain'])->first();
        if (!$merchant) {
            return;
        }

        // Find affiliate by discount code
        $affiliate = Affiliate::where('discount_code', $data['discount_code'])
            ->where('merchant_id', $merchant->id)
            ->first();

        // Always register the customer as a new affiliate (for future orders)
        $this->affiliateService->register(
            $merchant,
            $data['customer_email'],
            $data['customer_name'],
            0.1 // Default commission rate
        );

        // Calculate commission for the existing affiliate (who gets the commission for this order)
        $commissionOwed = $affiliate ? $data['subtotal_price'] * $affiliate->commission_rate : 0;

        // Create order
        Order::create([
            'merchant_id' => $merchant->id,
            'affiliate_id' => $affiliate?->id,
            'subtotal' => $data['subtotal_price'],
            'commission_owed' => $commissionOwed,
            'payout_status' => Order::STATUS_UNPAID,
            'external_order_id' => $data['order_id'],
            'customer_email' => $data['customer_email'],
            'customer_name' => $data['customer_name'],
            'discount_code' => $data['discount_code']
        ]);
    }
}
