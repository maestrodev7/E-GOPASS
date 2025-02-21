<?php
namespace App\Domain\Services;

use App\Domain\Entities\SuperAdministrateur;

interface AuthServiceInterface
{
    public function register(array $data): SuperAdministrateur;
    public function login(array $credentials): array;
    public function requestResetPassword(string $identifier): void;
    public function verifyOtp(string $identifier, int $otp): bool;
    public function resetPassword(string $identifier, int $otp, string $newPassword): void;
}
