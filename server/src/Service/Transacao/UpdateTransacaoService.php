<?php

namespace App\Service\Transacao;

use App\DTO\UpdateTransacaoDTO;
use App\Entity\Transacao;
use App\Exception\ApplicationException;
use App\Repository\PlanoContaRepository;
use App\Repository\TransacaoRepository;
use DateTime;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateTransacaoService
{
    function __construct(
        private readonly TransacaoRepository $transacaoRepository,
        private readonly PlanoContaRepository $planoContaRepository,
        private readonly LoggerInterface $logger
    )
    {
    }

    /**
     * @throws ApplicationException|Exception
     */
    public function execute(int $id, UpdateTransacaoDTO $dto): Transacao
    {
        try {
            $transacaoExistente = $this->transacaoRepository->find($id);

            if (!$transacaoExistente) {
                throw new ApplicationException('Transação não encontrada', Response::HTTP_NOT_FOUND);
            }

            $planoConta = $this->planoContaRepository->find($dto->planoContaId);

            if (!$planoConta) {
                throw new ApplicationException('Plano de Conta não encontrado', Response::HTTP_NOT_FOUND);
            }

            $transacaoExistente->planoConta = $planoConta;
            $transacaoExistente->historico = $dto->historico;
            $transacaoExistente->valor = $dto->valor;
            $transacaoExistente->data = new DateTime($dto->data);

            return $this->transacaoRepository->update($transacaoExistente);
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }
}
