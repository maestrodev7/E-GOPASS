<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Admin;

interface AdminRepositoryInterface
{
    public function all(): array;
    public function findById(int $id): ?Admin;
    public function create(array $data): Admin;
    public function delete(int $id): void;
}
