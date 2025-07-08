<?php

namespace App\Controller\Api;

use App\Repository\PlanoContaRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    function __construct(private readonly PlanoContaRepository $planoContaRepository)
    {
    }

    #[Route('/api/dashboard', name: 'dashboard', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $dataInicio = $request->query->get('dataInicio');
            $dataFim = $request->query->get('dataFim');

            $data = $this->planoContaRepository->getPlanosDeContaWithTransacoes($dataInicio, $dataFim);

            return new JsonResponse($data, Response::HTTP_OK);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
