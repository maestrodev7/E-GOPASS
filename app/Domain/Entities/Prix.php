<?php
namespace App\Domain\Entities;

class Prix
{
    public function __construct(
        public ?int $id,
        public string $type, 
        public float $amount,
        public ?string $created_at = null,
        public ?string $updated_at = null
    ) {}
}