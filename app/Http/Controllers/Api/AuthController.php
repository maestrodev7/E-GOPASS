<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthResquest;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Exception;
use Symfony\Component\HttpFoundation\Response; 
use App\Http\Requests\RequestResetPasswordRequest;
use App\Http\Requests\VerifyOtpRequest;

class AuthController extends Controller
{
    use ApiResponse; 

    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());
            return $this->success($user, 'Utilisateur enregistré avec succès.', Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->error('Échec de validation des données', Response::HTTP_UNPROCESSABLE_ENTITY, $e->errors());
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function login(AuthResquest $request)
    {

        try {
            $data = $this->authService->login($request->validated());
            if (isset($data['error'])) {
                return $this->error($data['error'], $data['status']);
            }
            return $this->success($data, 'Connexion réussie.', Response::HTTP_OK);
        } catch (AuthenticationException $e) {
            return $this->error('Échec de l’authentification, identifiants incorrects', Response::HTTP_UNAUTHORIZED);
        } catch (NotFoundHttpException $e) {
            return $this->error('Utilisateur non trouvé', Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return $this->error('Échec de validation des données', Response::HTTP_UNPROCESSABLE_ENTITY, $e->errors());
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function requestResetPassword(RequestResetPasswordRequest $request)
    {
        try {
            $this->authService->requestResetPassword($request->identifier);
            return $this->success([], 'OTP envoyé avec succès.', Response::HTTP_OK);
        } catch (NotFoundHttpException $e) {
            return $this->error('Utilisateur non trouvé', Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return $this->error('Échec de validation des données', Response::HTTP_UNPROCESSABLE_ENTITY, $e->errors());
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function resetPassword(VerifyOtpRequest $request)
    {
        try {
            $this->authService->resetPassword($request->identifier, $request->otp, $request->new_password);
            return $this->success([], 'Mot de passe mis à jour avec succès.', Response::HTTP_OK);
        } catch (AuthenticationException $e) {
            return $this->error('OTP invalide ou expiré', Response::HTTP_UNAUTHORIZED);
        } catch (NotFoundHttpException $e) {
            return $this->error('Utilisateur non trouvé', Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return $this->error('Échec de validation des données', Response::HTTP_UNPROCESSABLE_ENTITY, $e->errors());
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

}

