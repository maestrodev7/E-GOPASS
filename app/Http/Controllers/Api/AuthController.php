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
use Symfony\Component\HttpFoundation\Response; // Importing Response

class AuthController extends Controller
{
    use ApiResponse; // 📌 Utilisation du Trait

    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Inscription d'un utilisateur
     */
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

    /**
     * Connexion d'un utilisateur
     */
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
}

