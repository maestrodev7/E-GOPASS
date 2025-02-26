<?php

namespace Tests\Unit\Application\Services;

use Tests\TestCase;
use Mockery;
use App\Application\Services\AdminService;
use App\Domain\Repositories\AdminRepositoryInterface;
use App\Domain\Entities\Admin;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminServiceTest extends TestCase
{
    private $adminRepositoryMock;
    private $adminService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->adminRepositoryMock = Mockery::mock(AdminRepositoryInterface::class);
        $this->adminService = new AdminService($this->adminRepositoryMock);
    }

    public function test_get_all_admins_returns_array()
    {
        $admins = [Mockery::mock(Admin::class), Mockery::mock(Admin::class)];
        
        $this->adminRepositoryMock->shouldReceive('all')
            ->once()
            ->andReturn($admins);
        
        $result = $this->adminService->getAllAdmins();
        
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    public function test_get_admin_by_id_returns_admin()
    {
        $admin = Mockery::mock(Admin::class);
        
        $this->adminRepositoryMock->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($admin);
        
        $result = $this->adminService->getAdminById(1);
        
        $this->assertInstanceOf(Admin::class, $result);
    }

    public function test_create_admin_returns_admin()
    {
        $data = ['name' => 'Admin Test', 'email' => 'admin@example.com'];
        $admin = Mockery::mock(Admin::class);
        
        $this->adminRepositoryMock->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($admin);
        
        $result = $this->adminService->createAdmin($data);
        
        $this->assertInstanceOf(Admin::class, $result);
    }

    public function test_delete_admin_successfully()
    {
        $adminId = 1;
        $reason = 'Violation des règles';
        
        $this->adminRepositoryMock->shouldReceive('findById')
            ->once()
            ->with($adminId)
            ->andReturn(Mockery::mock(Admin::class));
        
        $this->adminRepositoryMock->shouldReceive('logDeletionReason')
            ->once()
            ->with($adminId, $reason);
        
        $this->adminRepositoryMock->shouldReceive('delete')
            ->once()
            ->with($adminId);
        
        $this->adminService->deleteAdmin($adminId, $reason);
    }

    public function test_delete_admin_throws_exception_when_not_found()
    {
        $adminId = 1;
        $reason = 'Violation des règles';
        
        $this->adminRepositoryMock->shouldReceive('findById')
            ->once()
            ->with($adminId)
            ->andReturn(null);
        
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage("L'administrateur n'existe pas.");
        
        $this->adminService->deleteAdmin($adminId, $reason);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
