<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Agent;

interface AgentRepositoryInterface
{
    public function all(): array;
    public function findById(int $id): ?Agent;
    public function create(array $data): Agent;
    public function delete(int $id): void;
}
