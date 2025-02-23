<?php
namespace App\Application\Services;

use App\Domain\Entities\Agent;
use App\Domain\Repositories\AgentRepositoryInterface;
use App\Domain\Services\AgentServiceInterface;
use Illuminate\Http\Response;

class AgentService implements AgentServiceInterface
{
    protected $agentRepository;

    public function __construct(AgentRepositoryInterface $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }

    public function getAllAgents(): array
    {
        return $this->agentRepository->all();
    }

    public function getAgentById(int $id): ?Agent
    {
        return $this->agentRepository->findById($id);
    }

    public function createAgent(array $data): Agent
    {
        return $this->agentRepository->create($data);
    }

    public function deleteAgent(int $id, string $reason): void
    {
        if (!$this->agentRepository->findById($id)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("L'agent n'existe pas.");
        }

        $this->agentRepository->logDeletionReason($id, $reason);
        $this->agentRepository->delete($id);
    }
}
