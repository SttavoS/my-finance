<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\CreatePlanoContaDTO;
use App\Repository\PlanoContaRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use UnexpectedValueException;

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
    public function createPlanoConta(Request $request, SerializerInterface $serializer): JsonResponse
    {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreatePlanoContaDTO::class, 'json');
            $planoConta = $this->planoContaRepo->add($dto);

            return new JsonResponse($planoConta, Response::HTTP_CREATED);
        } catch (UnexpectedValueException $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (ExceptionInterface $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/api/planos-conta/{id}', name: 'get-planos-conta', methods: ['GET'])]
    public function getPlanoConta(int $id): Response
    {
        $planoConta = $this->planoContaRepo->find($id);

        if (!$planoConta) {
            return new JsonResponse("Plano de Conta não encontrado", Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($planoConta, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/planos-conta/{id}', name: 'update-planos-conta', methods: ['PUT'])]
    public function updatePlanoConta(int $id, Request $request, SerializerInterface $serializer): JsonResponse
    {
        try {
            $planoConta = $this->planoContaRepo->find($id);

            if (!$planoConta) {
                return new JsonResponse('Plano de Conta não encontrado', Response::HTTP_NOT_FOUND);
            }

            $dto = $serializer->deserialize($request->getContent(), CreatePlanoContaDTO::class, 'json');
            $novoPlanoConta = $this->planoContaRepo->update($planoConta, $dto);

            return new JsonResponse($novoPlanoConta, Response::HTTP_OK);
        } catch (UnexpectedValueException $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (ExceptionInterface $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/api/planos-conta/{id}', name: 'delete-planos-conta', methods: ['DELETE'])]
    public function deletePlanoConta(int $id): JsonResponse
    {
        try {
            $planoConta = $this->planoContaRepo->find($id);

            if (!$planoConta) {
                return new JsonResponse('Plano de Conta não encontrado', Response::HTTP_NOT_FOUND);
            }

            $this->planoContaRepo->delete($planoConta);

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
