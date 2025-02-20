<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\SuperAdministrateur;
use App\Models\SuperAdminModel; 

interface SuperAdminRepositoryInterface
{
    public function create(array $data): SuperAdministrateur;
    public function update(int $id, array $data): SuperAdministrateur;
    public function findByEmail(string $email): ?SuperAdminModel;
    public function findByEmailOrPhone(string $identifier): ?SuperAdministrateur;
    public function save(SuperAdministrateur $superAdmin): void;
}
