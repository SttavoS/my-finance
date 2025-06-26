<?php

namespace App\Repository;

use App\DTO\CreatePlanoContaDTO;
use App\Entity\PlanoConta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<PlanoConta>
 *
 * @method PlanoConta|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanoConta|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanoConta[]    findAll()
 * @method PlanoConta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanoContaRepository extends ServiceEntityRepository
{
    function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct($registry, PlanoConta::class);
    }

    /**
     * @throws Exception
     */
    public function add(CreatePlanoContaDTO $dto): PlanoConta
    {
        try {
            $entityManager = $this->getEntityManager();

            $planoConta = new PlanoConta($dto->descricao, $dto->tipo);
            $entityManager->persist($planoConta);
            $entityManager->flush();

            return $planoConta;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param PlanoConta $planoConta
     * @param CreatePlanoContaDTO $dto
     * @return PlanoConta
     * @throws Exception
     */
    public function update(PlanoConta $planoConta, CreatePlanoContaDTO $dto): PlanoConta
    {
        try {
            $planoConta->descricao = $dto->descricao;
            $planoConta->tipo = $dto->tipo;

            $this->entityManager->persist($planoConta);
            $this->entityManager->flush();

            return $planoConta;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param PlanoConta $planoConta
     * @throws Exception
     */
    public function delete(PlanoConta $planoConta): void
    {
        try {
            $this->entityManager->remove($planoConta);
            $this->entityManager->flush();
        } catch (Exception $ex) {
            $this->logger->error($ex->getMessage());
            throw $ex;
        }
    }
}
