<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\CreatePlanoContaDTO;
use App\Repository\PlanoContaRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PlanoContaController extends AbstractController
{
    function __construct(private readonly PlanoContaRepository $planoContaRepo)
    {
    }

    #[Route('/api/planos-conta', name: 'get-all-planos-conta', methods: ['GET'])]
    public function listPlanosConta(): JsonResponse
    {
        $planosConta = $this->planoContaRepo->findAll();

        return new JsonResponse($planosConta, Response::HTTP_OK);
    }

    #[Route('/api/planos-conta', name: 'create-planos-conta', methods: ['POST'])]
    public function createPlanoConta(#[MapRequestPayload] CreatePlanoContaDTO $createPlanoContaDTO): JsonResponse
    {
        try {
            $planoConta = $this->planoContaRepo->add($createPlanoContaDTO);

            return new JsonResponse($planoConta, Response::HTTP_CREATED);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws Exception
     */
    #[Route('/api/planos-conta/{id}', name: 'get-planos-conta', methods: ['GET'])]
    public function getPlanoConta($id)
    {
        throw new Exception('Method Not Implemented');
    }

    /**
     * @throws Exception
     */
    #[Route('/api/planos-conta/{id}', name: 'update-planos-conta', methods: ['PUT'])]
    public function updatePlanoConta($id)
    {
        throw new Exception('Method Not Implemented');
    }

    /**
     * @throws Exception
     */
    #[Route('/api/planos-conta/{id}', name: 'delete-planos-conta', methods: ['DELETE'])]
    public function deletePlanoConta($id)
    {
        throw new Exception('Method Not Implemented');
    }
}
