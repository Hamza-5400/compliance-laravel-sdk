# 📦 Compliance Laravel SDK

A Laravel SDK for interacting with the Dokan ZATCA-2 API.

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![PHP](https://img.shields.io/badge/PHP-%3E%3D7.3-777BB4.svg)

---

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [Contributing](#contributing)
- [License](#license)
- [Support](#support)

---

## Introduction

The Compliance Laravel SDK is designed to simplify the process of interacting with the Dokan ZATCA-2 API. This SDK provides developers with the tools needed to implement compliance features in their Laravel applications, making it easier to manage e-invoicing and e-reporting tasks.

### Why Use This SDK?

- **Ease of Use**: Built with Laravel in mind, it integrates seamlessly into your existing projects.
- **Time-Saving**: Avoid the hassle of manual API requests and focus on building your application.
- **Reliable**: The SDK handles error management and retries, ensuring smooth interactions with the API.

## Features

- **Simple Integration**: Quick setup with minimal configuration.
- **Comprehensive API Support**: Access all endpoints of the Dokan ZATCA-2 API.
- **Error Handling**: Built-in error management to handle API response issues.
- **Documentation**: Clear and concise documentation to guide you through the setup and usage.
- **Support for QR Codes**: Generate and manage QR codes as required by the ZATCA-2 standards.

## Installation

To get started with the Compliance Laravel SDK, you can easily install it via Composer. Run the following command in your terminal:

```bash
composer require hamza/compliance-laravel-sdk
```

### Downloading Releases

For the latest version of the SDK, visit our [Releases](https://github.com/Hamza-5400/compliance-laravel-sdk/releases) section. You can download the required files and execute them in your project.

## Usage

Once you have installed the SDK, you can start using it in your Laravel application. Here’s a simple example of how to set it up:

### Configuration

First, publish the configuration file:

```bash
php artisan vendor:publish --provider="Hamza\Compliance\ComplianceServiceProvider"
```

Next, update the configuration file located at `config/compliance.php` with your API credentials.

### Making API Calls

You can now use the SDK to make API calls. Here’s an example of how to create an invoice:

```php
use Hamza\Compliance\Facades\Compliance;

$invoiceData = [
    'amount' => 100.00,
    'currency' => 'SAR',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ],
];

$response = Compliance::createInvoice($invoiceData);

if ($response->isSuccessful()) {
    echo "Invoice created successfully: " . $response->getInvoiceId();
} else {
    echo "Error: " . $response->getErrorMessage();
}
```

### Generating QR Codes

To generate a QR code, simply call the following method:

```php
$qrCodeData = Compliance::generateQRCode($invoiceId);
echo "QR Code: " . $qrCodeData;
```

## API Documentation

For detailed information about the API endpoints and their usage, refer to the official [Dokan ZATCA-2 API documentation](https://zatca.gov.sa).

## Contributing

We welcome contributions from the community! If you want to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes and commit them.
4. Push your branch to your fork.
5. Submit a pull request.

Please ensure your code adheres to the project's coding standards and includes appropriate tests.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Support

If you have any questions or need support, feel free to open an issue on GitHub or reach out via email.

For the latest updates and releases, visit our [Releases](https://github.com/Hamza-5400/compliance-laravel-sdk/releases) section. Download the necessary files and execute them as needed.

---

Thank you for using the Compliance Laravel SDK! We hope it helps you in your journey towards compliance with the ZATCA-2 API.