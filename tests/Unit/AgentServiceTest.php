<?php

namespace Tests\Unit\Application\Services;

use Tests\TestCase;
use Mockery;
use App\Application\Services\AgentService;
use App\Domain\Repositories\AgentRepositoryInterface;
use App\Domain\Entities\Agent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AgentServiceTest extends TestCase
{
    private $agentRepositoryMock;
    private $agentService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->agentRepositoryMock = Mockery::mock(AgentRepositoryInterface::class);
        $this->agentService = new AgentService($this->agentRepositoryMock);
    }

    public function test_get_all_agents_returns_array()
    {
        $agents = [Mockery::mock(Agent::class), Mockery::mock(Agent::class)];
        
        $this->agentRepositoryMock->shouldReceive('all')
            ->once()
            ->andReturn($agents);
        
        $result = $this->agentService->getAllAgents();
        
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    public function test_get_agent_by_id_returns_agent()
    {
        $agent = Mockery::mock(Agent::class);
        
        $this->agentRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($agent);
        
        $result = $this->agentService->getAgentById(1);
        
        $this->assertInstanceOf(Agent::class, $result);
    }

    public function test_create_agent_returns_agent()
    {
        $data = ['name' => 'Agent Test', 'email' => 'agent@example.com'];
        $agent = Mockery::mock(Agent::class);
        
        $this->agentRepositoryMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($agent);
        
        $result = $this->agentService->createAgent($data);
        
        $this->assertInstanceOf(Agent::class, $result);
    }

    public function test_delete_agent_successfully()
    {
        $agentId = 1;
        $reason = 'Violation des règles';
        
        $this->agentRepositoryMock->shouldReceive('findById')
            ->once()
            ->with($agentId)
            ->andReturn(Mockery::mock(Agent::class));
        
        $this->agentRepositoryMock->shouldReceive('logDeletionReason')
            ->once()
            ->with($agentId, $reason);
        
        $this->agentRepositoryMock->shouldReceive('delete')
            ->once()
            ->with($agentId);
        
        $this->agentService->deleteAgent($agentId, $reason);
    }

    public function test_delete_agent_throws_exception_when_not_found()
    {
        $agentId = 1;
        $reason = 'Violation des règles';
        
        $this->agentRepositoryMock->shouldReceive('findById')
            ->once()
            ->with($agentId)
            ->andReturn(null);
        
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage("L'agent n'existe pas.");
        
        $this->agentService->deleteAgent($agentId, $reason);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
