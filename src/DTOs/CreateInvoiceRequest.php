<?php

namespace Dokan\Compliance\DTOs;

class CreateInvoiceRequest
{
    public function __construct(
        public string $business_config_id,
        public string $invoice_identifier,
        public string $type,
        public int $type_code,
        public string $currency,
        public string $payment_status,
        public string $nature,
        public string $invoice_date,
        public Client $client,
        public array $lineItems,
        public ?bool $instant_report = null,
        public ?array $custom_attributes = null
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'business_config_id' => $this->business_config_id,
            'invoice_identifier' => $this->invoice_identifier,
            'type' => $this->type,
            'type_code' => $this->type_code,
            'currency' => $this->currency,
            'payment_status' => $this->payment_status,
            'nature' => $this->nature,
            'invoice_date' => $this->invoice_date,
            'instant_report' => $this->instant_report,
            'custom_attributes' => $this->custom_attributes,
            'client' => $this->client->toArray(),
            'lineItems' => array_map(fn($item) => $item->toArray(), $this->lineItems)
        ], function($value) {
            return !is_null($value);
        });
    }
} 