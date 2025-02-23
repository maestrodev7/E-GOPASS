<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\Agent;
use App\Models\AgentModel;

class AgentMapper
{
    public static function toEntity(AgentModel $model): Agent
    {
        return new Agent(
            id: $model->id,
            nom: $model->nom,
            postnom: $model->postnom,
            prenom: $model->prenom,
            telephone: $model->telephone,
            email: $model->email,
            fonction: $model->fonction,
            poste_de_travail: $model->poste_de_travail,
            nbr_egopass_desactiver: $model->nbr_egopass_desactiver,
            password: $model->password,
            created_at: $model->created_at,
            updated_at: $model->updated_at
        );
    }

    public static function toModel(Agent $entity): array
    {
        return [
            'id' => $entity->id,
            'nom' => $entity->nom,
            'postnom' => $entity->postnom,
            'prenom' => $entity->prenom,
            'telephone' => $entity->telephone,
            'email' => $entity->email,
            'fonction' => $entity->fonction,
            'poste_de_travail' => $entity->poste_de_travail,
            'nbr_egopass_desactiver' => $entity->nbr_egopass_desactiver,
            'password' => $entity->password,
            'created_at' => $entity->created_at,
            'updated_at' => $entity->updated_at,
        ];
    }
}
