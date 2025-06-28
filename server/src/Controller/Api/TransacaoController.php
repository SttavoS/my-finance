<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\CreateTransacaoDTO;
use App\Repository\TransacaoRepository;
use Exception;
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
    function __construct(private readonly TransacaoRepository $transacaoRepo)
    {
    }

    #[Route('/api/transacoes', methods: ['GET'])]
    public function index(): Response
    {
        $transacoes = $this->transacaoRepo->findAll();

        if (empty($transacoes)) {
            return new JsonResponse($transacoes, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse($transacoes, Response::HTTP_OK);
    }

    #[Route('/api/transacoes/{id}', methods: ['GET'])]
    public function show(int $id): Response
    {
        $transacao = $this->transacaoRepo->find($id);

        if (!$transacao) {
            return new JsonResponse("Transação não encontrada", Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($transacao, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/transacoes', methods: ['POST'])]
    public function store(Request $request, SerializerInterface $serializer): JsonResponse
    {
        try {
            $dto = $serializer->deserialize($request->getContent(), CreateTransacaoDTO::class, 'json');
            $planoConta = $this->transacaoRepo->add($dto);

            return new JsonResponse($planoConta, Response::HTTP_CREATED);
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
            $transacaoExistente = $this->transacaoRepo->find($id);

            if (!$transacaoExistente) {
                return new JsonResponse('Transação não encontrada', Response::HTTP_NOT_FOUND);
            }

            $dto = $serializer->deserialize($request->getContent(), CreateTransacaoDTO::class, 'json');
            $transacao = $this->transacaoRepo->update($transacaoExistente, $dto);

            return new JsonResponse($transacao, Response::HTTP_OK);
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
