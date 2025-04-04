# Dokan Compliance Laravel SDK (ZATCA Phase 2)

A Laravel SDK for interacting with the Dokan ZATCA-2 API.

## Installation

You can install the package via composer:

```bash
composer require dokan-e-commerce/compliance-laravel-sdk
```

## Setup

1. Publish the config file:
```bash
php artisan vendor:publish --provider="Dokan\Compliance\ComplianceServiceProvider" --tag="compliance-config"
```

2. Add these variables to your `.env` file:
```
DOKAN_COMPLIANCE_API_KEY=your-api-key
```

3. Get your API token:
   - Visit [Dokan Compliance Portal](https://compliance.dokan.sa/)
   - Sign in to your account / register 
   - Create business entity if you dont have, and onboard your business
   - Navigate to the API Tokens section
   - Create a new API token
   - Copy the generated token and use it as your `DOKAN_COMPLIANCE_API_KEY`

## Usage

### Get Business Details
```php
$client = app(\Dokan\Compliance\ComplianceClient::class);
$businessDetails = $client->getBusinessDetails();
```

### Create Invoice
```php
use Dokan\Compliance\DTOs\CreateInvoiceRequest;
use Dokan\Compliance\DTOs\Client;
use Dokan\Compliance\DTOs\LineItem;

$invoiceRequest = new CreateInvoiceRequest(
    business_config_id: '9dekebab-4bab-4e0a-af2c-f3shawarma',
    invoice_identifier: 'INV-1234',
    type: 'simplified',
    type_code: 388,
    currency: 'SAR',
    payment_status: 'Paid',
    nature: 'Sale',
    invoice_date: '2025-04-24 12:00:00',
    client: new Client(
        email: 'ahmed@dev.dokan.sa',
        type: 'individual',
        name: 'Ahmed A',
        phone: "+96655555555" // optional
    ),
    lineItems: [
        new LineItem(
            label: 'Chicken Shawarma',
            price: 6,
            quantity: 2,
            is_vat_inclusive: true
        )
    ]
    // Optional parameters:
    // instant_report: bool|null
    // custom_attributes: array|null
);

// Direct creation
$response = $client->createInvoice($invoiceRequest->toArray());

// Queue creation (with automatic retries)
$client->createInvoice($invoiceRequest->toArray(), queue: true);
```

### Get Invoice Details
```php
$invoiceDetails = $client->getInvoiceDetails(123);
```

## Queue Configuration (Optional)

If you plan to use queued invoice creation:

1. Configure queue in `.env`:
```
QUEUE_CONNECTION=redis # or database, sqs, etc.
```

2. Run queue worker:
```bash
php artisan queue:work
```

The queue system includes:
- 3 retry attempts
- 5-second delay between retries
- Automatic handling of API errors
- Retries only on connection issues or server errors

## Support

- PHP: ^8.0|^8.1|^8.2|^8.3
- Laravel: ^9.0|^10.0

## License

MIT License 