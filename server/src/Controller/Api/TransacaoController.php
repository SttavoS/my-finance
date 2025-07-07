<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\CreateTransacaoDTO;
use App\DTO\UpdateTransacaoDTO;
use App\Exception\ApplicationException;
use App\Repository\TransacaoRepository;
use App\Service\Transacao\CreateNewTransacaoService;
use App\Service\Transacao\UpdateTransacaoService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use UnexpectedValueException;

class TransacaoController extends AbstractController
{
    function __construct(
        private readonly TransacaoRepository $transacaoRepo,
        private readonly LoggerInterface $logger,
        private readonly CreateNewTransacaoService $createNewTransacaoService,
        private readonly UpdateTransacaoService $updateTransacaoService
    )
    {
    }

    #[Route('/api/transacoes', methods: ['GET'])]
    public function index(): Response
    {
        try {
            $transacoes = $this->transacaoRepo->getAllWithPlanoConta();

            if (empty($transacoes)) {
                return new JsonResponse($transacoes, Response::HTTP_NO_CONTENT);
            }

            return new JsonResponse($transacoes, Response::HTTP_OK);
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/api/transacoes/{id}', methods: ['GET'])]
    public function show(int $id): Response
    {
        try {
            $transacao = $this->transacaoRepo->findOneWithPlanoConta($id);

            if (!$transacao) {
                return new JsonResponse("Transação não encontrada", Response::HTTP_NOT_FOUND);
            }

            return new JsonResponse($transacao, Response::HTTP_OK);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/transacoes', methods: ['POST'])]
    public function store(Request $request, SerializerInterface $serializer): JsonResponse
    {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateTransacaoDTO::class, 'json');
            $newTransacao = $this->createNewTransacaoService->execute($dto);

            return new JsonResponse($newTransacao, Response::HTTP_CREATED);
        } catch (UnexpectedValueException|ExceptionInterface $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/transacoes/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, SerializerInterface $serializer): JsonResponse
    {
        try {
            $dto = $serializer->deserialize($request->getContent(), UpdateTransacaoDTO::class, 'json');
            $transacao = $this->updateTransacaoService->execute($id, $dto);

            return new JsonResponse($transacao, Response::HTTP_OK);
        } catch (ApplicationException $ex) {
            return new JsonResponse($ex->getMessage(), $ex->getCode());
        } catch (UnexpectedValueException|ExceptionInterface $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/api/transacoes/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $transacao = $this->transacaoRepo->find($id);

            if (!$transacao) {
                return new JsonResponse('Transação não encontrada', Response::HTTP_NOT_FOUND);
            }

            $this->transacaoRepo->delete($transacao);

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $ex) {
            return new JsonResponse($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
