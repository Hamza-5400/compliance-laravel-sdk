<?php

namespace Dokan\Compliance\DTOs;

class LineItem
{
    public function __construct(
        public string $label,
        public float $price,
        public int $quantity,
        public bool $is_vat_inclusive
    ) {}

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'is_vat_inclusive' => $this->is_vat_inclusive
        ];
    }
} 