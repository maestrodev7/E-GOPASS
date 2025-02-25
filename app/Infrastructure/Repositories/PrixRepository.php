<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Prix;
use App\Domain\Repositories\PrixRepositoryInterface;
use App\Models\PrixModel;
use App\Infrastructure\Mappers\PrixMapper;

class PrixRepository implements PrixRepositoryInterface
{

    public function updateOrCreate(string $type, float $amount): Prix
    {

        $model = PrixModel::updateOrCreate(
            ['type' => $type], 
            ['amount' => $amount]        
        );
        return PrixMapper::toEntity($model);
    }

    public function findByFlightType(string $type): ?Prix
    {
        $model = PrixModel::where('type',$type)->first();
        return $model ? PrixMapper::toEntity($model) : null;
    }
}
