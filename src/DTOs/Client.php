<?php

namespace Dokan\Compliance\DTOs;

class Client
{
    public function __construct(
        public string $email,
        public string $type,
        public ?string $name = null,
        public ?string $phone = null
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'type' => $this->type,
            'name' => $this->name,
            'phone' => $this->phone
        ]);
    }
} 