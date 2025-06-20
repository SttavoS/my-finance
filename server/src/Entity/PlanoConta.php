<?php

namespace App\Entity;

use App\Enum\PlanoContaTipo;
use App\Repository\PlanoContaRepository;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, Table};
use Doctrine\DBAL\Types\Types;

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
    #[Column(type: Types::STRING, length: 1)]
    public PlanoContaTipo $tipo;

    function __construct(int $id, string $descricao, PlanoContaTipo $tipo)
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->tipo = $tipo;
    }
}
