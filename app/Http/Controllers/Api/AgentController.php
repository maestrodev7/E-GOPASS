<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\AgentServiceInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAgentRequest;
use App\Http\Requests\DeleteAgentRequest;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class AgentController extends Controller
{
    use ApiResponse;

    private AgentServiceInterface $agentnService;
    
    public function __construct(AgentServiceInterface $agentnService)
    {
        $this->agentnService = $agentnService;
    }

    public function getAllAgents()
    {
        try {
            $agents = $this->agentnService->getAllAgents();
            return $this->success($agents, 'Liste des agents récupérée avec succès.', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function getAgentById(int $id)
    {
        try {
            $agent = $this->agentnService->getAgentById($id);
            if (!$agent) {
                return $this->error('Agent non trouvé', Response::HTTP_NOT_FOUND);
            }
            return $this->success($agent, 'Agent trouvé avec succès.', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function createAgent(CreateAgentRequest $request)
    {
        try {
            $agent = $this->agentnService->createAgent($request->validated());
            if (!$agent) {
                return $this->error('Agent non trouvé', Response::HTTP_NOT_FOUND);
            }
            return $this->success($agent, 'Agent créé avec succès.', Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function deleteAgent(DeleteAgentRequest $request, int $id)
    {
        try {
            $reason = $request->input('reason');
            $this->agentnService->deleteAgent($id, $reason);
            return $this->success([], 'Agentistrateur supprimé avec succès.', Response::HTTP_OK);
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return $this->error($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->error('Une erreur interne est survenue', Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
