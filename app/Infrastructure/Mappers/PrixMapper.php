<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\Prix;
use App\Models\PrixModel;

class PrixMapper
{
    public static function toEntity(PrixModel $model): Prix
    {
        return new Prix(
            id: $model->id,
            type: $model->type,
            amount: $model->amount,
            created_at: $model->created_at,
            updated_at: $model->updated_at
        );
    }

    public static function toModel(Prix $entity): array
    {
        return [
            'id' => $entity->id,
            'type' => $entity->type,
            'amount' => $entity->amount,
            'created_at' => $entity->created_at,
            'updated_at' => $entity->updated_at,
        ];
    }
}
