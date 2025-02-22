<?php

namespace App\Domain\Services;

use App\Domain\Entities\Admin;

interface AdminServiceInterface
{
    /**
     * Get all admins.
     *
     * @return array
     */
    public function getAllAdmins(): array;

    /**
     * Get an admin by ID.
     *
     * @param int $id
     * @return Admin|null
     */
    public function getAdminById(int $id): ?Admin;

    /**
     * Create a new admin.
     *
     * @param array $data
     * @return Admin
     */
    public function createAdmin(array $data): Admin;

    /**
     * Delete an admin by ID and log the deletion reason.
     *
     * @param int $id
     * @param string $reason
     * @return void
     */
    public function deleteAdmin(int $id, string $reason): void;
}
