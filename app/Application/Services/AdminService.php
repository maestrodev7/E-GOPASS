<?php
namespace App\Application\Services;

use App\Domain\Entities\Admin;
use App\Domain\Repositories\AdminRepositoryInterface;
use App\Domain\Services\AdminServiceInterface;
use Illuminate\Http\Response;

class AdminService implements AdminServiceInterface
{
    protected $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAllAdmins(): array
    {
        return $this->adminRepository->all();
    }

    public function getAdminById(int $id): ?Admin
    {
        return $this->adminRepository->findById($id);
    }

    public function createAdmin(array $data): Admin
    {
        return $this->adminRepository->create($data);
    }

    public function deleteAdmin(int $id, string $reason): void
    {
        if (!$this->adminRepository->findById($id)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("L'administrateur n'existe pas.");
        }

        $this->adminRepository->logDeletionReason($id, $reason);
        $this->adminRepository->delete($id);
    }
}
