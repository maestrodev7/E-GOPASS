<?php
namespace App\Domain\Services;

use App\Domain\Entities\SuperAdministrateur;

interface AuthServiceInterface
{
    public function register(array $data): SuperAdministrateur;
    public function login(array $credentials): array;
    public function requestResetPassword(string $identifier): void;
    public function verifyOtp(string $identifier, string $otp): bool;
    public function resetPassword(string $identifier, string $otp, string $newPassword): void;
}
