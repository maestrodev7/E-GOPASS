<?php

namespace App\Domain\Services;

use App\Domain\Entities\Agent;

interface AgentServiceInterface
{
    /**
     * Get all Agents.
     *
     * @return array
     */
    public function getAllAgents(): array;

    /**
     * Get an Agent by ID.
     *
     * @param int $id
     * @return Agent|null
     */
    public function getAgentById(int $id): ?Agent;

    /**
     * Create a new Agent.
     *
     * @param array $data
     * @return Agent
     */
    public function createAgent(array $data): Agent;

    /**
     * Delete an Agent by ID and log the deletion reason.
     *
     * @param int $id
     * @param string $reason
     * @return void
     */
    public function deleteAgent(int $id, string $reason): void;
}
