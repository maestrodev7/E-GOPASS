<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Admin;
use App\Domain\Repositories\AdminRepositoryInterface;
use App\Models\AdminModel;
use App\Models\AdminDeletionReason;
use App\Infrastructure\Mappers\AdministrateurMapper;

class AdminRepository implements AdminRepositoryInterface
{
    public function all(): array
    {
        $admins = AdminModel::select('nom', 'postnom', 'prenom', 'fonction', 'poste_de_travail')->get();
        
        return array_map(fn($admin) => AdministrateurMapper::toEntity($admin), $admins->all());

    }

    public function findById(int $id): ?Admin
    {
        $admin = AdminModel::find($id);
        if ($admin === null) {
            return null;  
        }
        return AdministrateurMapper::toEntity($admin);
    }

    public function create(array $data): Admin
    {
        $admin = AdminModel::create($data);
        return AdministrateurMapper::toEntity($admin);
    }

    public function delete(int $id): void
    {
        AdminModel::destroy($id);
    }

    public function logDeletionReason(int $id, string $reason): void
    {

        if (!AdminModel::where('id', $id)->exists()) {
            throw new \Exception("cet administrateur n'existe pas.");
        }

        AdminDeletionReason::create([
            'admin_id' => $id,
            'reason' => $reason
        ]);
    }
}
