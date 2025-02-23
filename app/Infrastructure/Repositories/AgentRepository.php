<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Agent;
use App\Domain\Repositories\AgentRepositoryInterface;
use App\Models\AgentModel;
use App\Models\AgentDeleteReason;
use App\Infrastructure\Mappers\AgentMapper;

class AgentRepository implements AgentRepositoryInterface
{
    public function all(): array
    {
        $agents = AgentModel::select('nom', 'postnom', 'prenom', 'fonction', 'poste_de_travail')->get();
        
        return array_map(fn($agents) => AgentMapper::toEntity($agents), $agents->all());

    }

    public function findById(int $id): ?Agent
    {
        $agent = AgentModel::find($id);
        if ($agent === null) {
            return null;  
        }
        return AgentMapper::toEntity($agent);
    }

    public function create(array $data): Agent
    {
        $agent = AgentModel::create($data);
        return AgentMapper::toEntity($agent);
    }

    public function delete(int $id): void
    {
        AgentModel::destroy($id);
    }

    public function logDeletionReason(int $id, string $reason): void
    {

        if (!AgentModel::where('id', $id)->exists()) {
            throw new \Exception("cet agent n'existe pas.");
        }

        AgentDeleteReason::create([
            'agent_model_id' => $id,
            'reason' => $reason
        ]);
    }
}
