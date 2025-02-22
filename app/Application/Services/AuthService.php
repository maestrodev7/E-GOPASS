<?php
namespace App\Application\Services;

use App\Domain\Services\AuthServiceInterface;
use App\Domain\Repositories\SuperAdminRepositoryInterface;
use App\Domain\Entities\SuperAdministrateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Twilio\Rest\Client;
use Exception;
use App\Mail\SendOtpMail;
use Illuminate\Http\Response;
use App\Traits\ApiResponse;

class AuthService implements AuthServiceInterface
{
    use ApiResponse;
    public function __construct(private SuperAdminRepositoryInterface $repository) {}

    public function register(array $data): SuperAdministrateur
    {
        $data['password'] = Hash::make($data['password']);
        return $this->repository->create($data);
    }

    public function login(array $credentials): array
    {
        $user = $this->repository->findByEmail($credentials['email']);

        if (!$user) {
            return ['error' => 'Supper admin non trouvé', 'status' => Response::HTTP_NOT_FOUND];
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return ['error' => 'Échec de l’authentification, identifiants incorrects', 'status' => Response::HTTP_BAD_REQUEST];
        }

        $role = $user->fonction;
        $token = $user->createToken('auth_token', [$role])->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function requestResetPassword(string $identifier): void
    {
        $user = $this->repository->findByEmailOrPhone($identifier);

        if (!$user) {
            throw new Exception('Supper admin  non trouvé', Response::HTTP_NOT_FOUND);
        }

        $otp = rand(100000, 999999);
        Cache::put("otp_{$identifier}", (int)$otp, now()->addMinutes(5));

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            Mail::to($identifier)->send(new SendOtpMail($otp));
        } else {
            $this->sendSms($identifier, "Votre code OTP est : $otp");
        }
    }

    public function verifyOtp(string $identifier, int $otp): bool
    {
        

        if (Cache::get("otp_{$identifier}") === (int)$otp) {
            Cache::forget("otp_{$identifier}");
            return true;
        }
        throw new Exception('Code OTP invalide ou expiré', Response::HTTP_UNAUTHORIZED);
    }

    public function resetPassword(string $identifier, int $otp, string $newPassword): void
    {
        $user = $this->repository->findByEmailOrPhone($identifier);

        if (!$user || !is_object($user)) {
            throw new Exception('Utilisateur non trouvé ou mauvais format', Response::HTTP_NOT_FOUND);
        }

        if (!$this->verifyOtp($identifier, $otp)) {
            throw new Exception('Code OTP invalide', Response::HTTP_UNAUTHORIZED);
        }

        $user->password = Hash::make($newPassword);
        $this->repository->save($user);
    }

    private function sendSms(string $phone, string $message)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        $twilio->messages->create($phone, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => $message
        ]);
    }   
}
