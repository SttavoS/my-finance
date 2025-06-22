<?php

namespace App\Entity;

use App\Enum\PlanoContaTipo;
use App\Repository\TransacaoRepository;
use DateTime;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, Table};
use Doctrine\DBAL\Types\Types;

#[Entity(repositoryClass: TransacaoRepository::class)]
#[Table(name: 'transacoes')]
class Transacao
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    public int $id;

    #[Column(type: Types::STRING, length: 255)]
    public string $historico;

    #[Column(type: 'plano_conta_tipo_enum',  length: 1)]
    public PlanoContaTipo $tipo;

    #[Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    public float $valor;

    #[Column(type: Types::DATE_MUTABLE)]
    public DateTime $data;
}
