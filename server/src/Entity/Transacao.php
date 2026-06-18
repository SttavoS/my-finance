<?php

namespace App\Entity;

use App\Repository\TransacaoRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, JoinColumn, ManyToOne, Table};

#[Entity(repositoryClass: TransacaoRepository::class)]
#[Table(name: 'transacoes')]
class Transacao
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    public int $id;

    #[ManyToOne(targetEntity: PlanoConta::class, inversedBy: 'transacoes')]
    #[JoinColumn(name: 'plano_conta_id', referencedColumnName: 'id', nullable: false)]
    public PlanoConta $planoConta;

    #[Column(type: Types::STRING, length: 255)]
    public string $historico;

    #[Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    public float $valor;

    #[Column(type: Types::DATE_MUTABLE)]
    public DateTime $data;

    public function __construct(string $historico, PlanoConta $planoConta, float $valor, DateTime $data)
    {
        $this->historico = $historico;
        $this->planoConta = $planoConta;
        $this->valor = $valor;
        $this->data = $data;
    }
}
