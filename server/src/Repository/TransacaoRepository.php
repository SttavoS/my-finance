<?php

namespace App\Repository;

use App\DTO\CreateTransacaoDTO;
use App\Entity\Transacao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Transacao>
 *
 * @method Transacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transacao[]    findAll()
 * @method Transacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransacaoRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     */
    function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct($registry, Transacao::class);
    }

    public function getAllWithPlanoConta()
    {
        $query = $this
            ->createQueryBuilder('t')
            ->leftJoin('t.planoConta', 'pc')
            ->addSelect('pc')
            ->getQuery();
        $this->logger->info($query->getSQL());

        return $query->execute();
    }

    public function findOneWithPlanoConta(int $id)
    {
        $query = $this
            ->createQueryBuilder('t')
            ->leftJoin('t.planoConta', 'pc')
            ->addSelect('pc')
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $this->logger->info($query->getSQL());

        return $query->getOneOrNullResult();
    }

    /**
     * @param CreateTransacaoDTO $dto
     * @return Transacao
     * @throws Exception
     */
    public function add(CreateTransacaoDTO $dto): Transacao
    {
        try {
            $planoConta = new Transacao($dto->historico, $dto->tipo, $dto->valor, $dto->data);
            $this->entityManager->persist($planoConta);
            $this->entityManager->flush();

            return $planoConta;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param Transacao $transacao
     * @param CreateTransacaoDTO $dto
     * @return Transacao
     * @throws Exception
     */
    public function update(Transacao $transacao, CreateTransacaoDTO $dto): Transacao
    {
        try {
            $transacao->historico = $dto->historico;
            $transacao->tipo = $dto->tipo;
            $transacao->valor = $dto->valor;
            $transacao->data = $dto->data;

            $this->entityManager->persist($transacao);
            $this->entityManager->flush();

            return $transacao;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param Transacao $transacao
     * @throws Exception
     */
    public function delete(Transacao $transacao): void
    {
        try {
            $this->entityManager->remove($transacao);
            $this->entityManager->flush();
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            throw $ex;
        }
    }
}
