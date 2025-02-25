<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Prix;

interface PrixRepositoryInterface
{
    public function updateOrCreate(string $type, float $amount): Prix;
    public function findByFlightType(string $type): ?Prix;
}
