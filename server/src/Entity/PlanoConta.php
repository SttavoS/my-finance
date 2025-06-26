<?php

namespace App\Entity;

use App\Enum\PlanoContaTipo;
use App\Repository\PlanoContaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, Table};

#[Entity(repositoryClass: PlanoContaRepository::class)]
#[Table(name: 'planos_conta')]
class PlanoConta
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    public int $id;
    #[Column(type: Types::STRING, length: 255)]
    public string $descricao;
    #[Column(type: 'plano_conta_tipo_enum', length: 1)]
    public PlanoContaTipo $tipo;

    function __construct(string $descricao, PlanoContaTipo $tipo)
    {
        $this->descricao = $descricao;
        $this->tipo = $tipo;
    }
}
