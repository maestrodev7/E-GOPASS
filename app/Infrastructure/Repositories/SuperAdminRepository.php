<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\SuperAdminRepositoryInterface;
use App\Domain\Entities\SuperAdministrateur;
use App\Models\SuperAdminModel;
use App\Infrastructure\Mappers\SuperAdministrateurMapper;

class SuperAdminRepository implements SuperAdminRepositoryInterface
{
    public function create(array $data): SuperAdministrateur
    {
        $model = SuperAdminModel::create($data);
        return SuperAdministrateurMapper::toEntity($model);
    }

    public function update(int $id, array $data): SuperAdministrateur
    {
        $model = SuperAdminModel::findOrFail($id);
        $model->update($data);
        return SuperAdministrateurMapper::toEntity($model);
    }
    
    public function findByEmail(string $email): ?SuperAdminModel
    {
        return SuperAdminModel::where('email', $email)->first();
    }
    
    public function findByEmailOrPhone(string $identifier): ?SuperAdministrateur
    {
        $model = SuperAdminModel::where('email', $identifier)
            ->orWhere('telephone', $identifier)
            ->first();

        return $model ? SuperAdministrateurMapper::toEntity($model) : null;
    }

    public function save(SuperAdministrateur $superAdmin): void
    {
        $data = SuperAdministrateurMapper::toModel($superAdmin);

    // Convert the array back to a SuperAdminModel instance
    $model = new SuperAdminModel($data);
    $model->update($data);

    }
}
