<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\AdminServiceInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\DeleteAdminRequest;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class AdminController extends Controller
{
    use ApiResponse;

    private AdminServiceInterface $adminService;
    
    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getAllAdmins()
    {
        try {
            $admins = $this->adminService->getAllAdmins();
            return $this->success($admins, 'Liste des administrateurs récupérée avec succès.', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function getAdminById(int $id)
    {
        try {
            $admin = $this->adminService->getAdminById($id);
            if (!$admin) {
                return $this->error('Administrateur non trouvé', Response::HTTP_NOT_FOUND);
            }
            return $this->success($admin, 'Administrateur trouvé avec succès.', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function createAdmin(CreateAdminRequest $request)
    {
        try {
            $admin = $this->adminService->createAdmin($request->validated());
            if (!$admin) {
                return $this->error('Administrateur non trouvé', Response::HTTP_NOT_FOUND);
            }
            return $this->success($admin, 'Administrateur créé avec succès.', Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function deleteAdmin(DeleteAdminRequest $request, int $id)
    {
        try {
            $reason = $request->input('reason');
            $this->adminService->deleteAdmin($id, $reason);
            return $this->success([], 'Administrateur supprimé avec succès.', Response::HTTP_OK);
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return $this->error($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
