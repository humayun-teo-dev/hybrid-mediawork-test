# Hybrid Interview - Laravel Affiliate Marketing System

## Overview
This project implements a complete affiliate marketing system built with Laravel. The system handles merchant registration, affiliate management, order processing, and commission payouts through a webhook-based architecture.

## ✅ Implementation Status
**All tests passing (15/15)** - The implementation is complete and fully functional.

## 🚀 What's Been Implemented

### Core Services

#### MerchantService
- **Merchant Registration**: Creates merchant accounts with proper user type assignment
- **Merchant Updates**: Handles profile updates for both user and merchant data
- **Merchant Lookup**: Finds merchants by email with proper type filtering
- **Payout Processing**: Dispatches payout jobs for all unpaid affiliate orders

#### AffiliateService
- **Affiliate Registration**: Creates new affiliates with validation and email notifications
- **Duplicate Prevention**: Prevents email conflicts between merchants and affiliates
- **Discount Code Generation**: Integrates with API service to create unique discount codes
- **Welcome Emails**: Sends notification emails to new affiliates

#### OrderService
- **Order Processing**: Handles incoming orders from webhooks
- **Duplicate Prevention**: Prevents duplicate orders based on external order ID
- **Affiliate Discovery**: Finds affiliates by discount code for commission tracking
- **Customer Registration**: Automatically registers customers as new affiliates
- **Commission Calculation**: Calculates commissions based on affiliate rates

### Background Jobs

#### PayoutOrderJob
- **Transaction Safety**: Uses database transactions for data consistency
- **API Integration**: Sends payouts through the API service
- **Error Handling**: Maintains order status on failure, updates on success
- **Rollback Support**: Ensures data integrity when payouts fail

### Controllers

#### WebhookController
- **Order Processing**: Accepts webhook data and processes orders
- **JSON Response**: Returns proper API responses for webhook endpoints

#### MerchantController
- **Order Statistics**: Provides merchant dashboard data
- **Date Filtering**: Supports date range queries for order analytics
- **Commission Tracking**: Calculates total commissions owed to affiliates

### Database Improvements

#### Migration Fixes
- **Monetary Precision**: Replaced `float` with `decimal` for all monetary values
- **Required Fields**: Added `external_order_id`, `customer_email`, `customer_name`
- **Data Integrity**: Proper foreign key constraints and nullable fields

## 🛠 Technical Implementation Details

### Database Schema
- **Users**: Supports both merchant and affiliate user types
- **Merchants**: Store domain, display name, and commission settings
- **Affiliates**: Link users to merchants with commission rates and discount codes
- **Orders**: Track orders with proper affiliate association and commission tracking

### Business Logic
- **Commission Flow**: Orders are associated with referring affiliates for commission
- **Customer Conversion**: Customers are automatically registered as new affiliates
- **Payout Management**: Background jobs handle commission payouts safely
- **Webhook Processing**: Real-time order processing from external systems

### Code Quality
- **Laravel Best Practices**: Follows Laravel conventions and patterns
- **Dependency Injection**: Proper service container usage
- **Error Handling**: Comprehensive exception handling
- **Database Transactions**: Ensures data consistency
- **Type Safety**: Proper type hints and return types

## 🧪 Testing
All tests pass without modifying the original test files or factories, respecting the project constraints:
- **Unit Tests**: 1 passing
- **Feature Tests**: 14 passing
- **Total**: 15/15 tests passing

## 🚀 Getting Started

### Prerequisites
- PHP 8.1+
- Composer
- SQLite (or any supported database)

### Installation
```bash
composer install
php artisan key:generate
php artisan migrate
php artisan test
```

### Running Tests
```bash
php artisan test
```

## 📁 Project Structure
```
app/
├── Services/
│   ├── MerchantService.php      # Merchant management
│   ├── AffiliateService.php     # Affiliate management
│   └── OrderService.php         # Order processing
├── Jobs/
│   └── PayoutOrderJob.php       # Commission payouts
├── Http/Controllers/
│   ├── WebhookController.php    # Webhook endpoint
│   └── MerchantController.php   # Merchant API
└── Models/
    ├── User.php                 # User management
    ├── Merchant.php             # Merchant model
    ├── Affiliate.php            # Affiliate model
    └── Order.php                # Order model
```

## 🔗 Repository
This implementation has been pushed to: `https://github.com/humayun-teo-dev/hybrid-mediawork-test.git`

## 📝 Notes
- All monetary values use `decimal` type for precision
- The system supports both existing and new affiliate workflows
- Webhook processing is designed for real-time order handling
- Commission calculations are accurate and transaction-safe
- The implementation respects all project constraints and requirements

