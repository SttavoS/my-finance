<?php

namespace App\Repository;

use App\DTO\CreatePlanoContaDTO;
use App\Entity\PlanoConta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
