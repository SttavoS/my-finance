<?php

namespace App\Service\Transacao;

use App\DTO\CreateTransacaoDTO;
use App\Entity\Transacao;
use App\Repository\PlanoContaRepository;
use App\Repository\TransacaoRepository;
use DateTime;
use Exception;
use Psr\Log\LoggerInterface;

class CreateNewTransacaoService
{
    function __construct(
        private readonly TransacaoRepository $transacaoRepo,
        private readonly PlanoContaRepository $planoContaRepository,
        private readonly LoggerInterface $logger
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(CreateTransacaoDTO $dto): Transacao
    {
        try {
            $planoConta = $this->planoContaRepository->find($dto->planoContaId);
            $data = new DateTime($dto->data);

            $transacao = new Transacao($dto->historico, $planoConta, $dto->valor, $data);

            return $this->transacaoRepo->add($transacao);
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }
}
