<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\PrixServiceInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePrixRequest;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class PrixController extends Controller
{
    use ApiResponse;

    private PrixServiceInterface $prixService;

    /**
     * Constructeur du contrôleur.
     *
     * @param PrixServiceInterface $prixService Le service pour gérer les prix.
     */
    public function __construct(PrixServiceInterface $prixService)
    {
        $this->prixService = $prixService;
    }

    /**
     * Met à jour ou crée les prix des e-GoPass.
     *
     * @param UpdatePrixRequest $request La requête HTTP contenant les données.
     * @return \Illuminate\Http\JsonResponse La réponse JSON.
     */
    public function updatePrix(UpdatePrixRequest $request)
    {
        try {
            // Mettre à jour ou créer les prix
            $localPrix = $this->prixService->updateOrCreatePrix('local', $request->local_price);
            $internationalPrix = $this->prixService->updateOrCreatePrix('international', $request->international_price);

            // Retourner une réponse JSON
            return $this->success([
                'local_price' => $localPrix->amount,
                'international_price' => $internationalPrix->amount,
            ], 'Prix mis à jour avec succès.', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * Récupère un prix par son type.
     *
     * @param int $type Le type de prix (1 pour local, 2 pour international).
     * @return \Illuminate\Http\JsonResponse La réponse JSON.
     */
    public function getPrixByType(string $type)
    {
        try {
            // Récupérer le prix par type
            $prix = $this->prixService->findPrixByType($type);

            // Vérifier si le prix existe
            if (!$prix) {
                return $this->error('Prix non trouvé', Response::HTTP_NOT_FOUND);
            }

            // Retourner une réponse JSON
            return $this->success([
                'type' => $prix->type,
                'amount' => $prix->amount,
            ], 'Prix trouvé avec succès.', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}