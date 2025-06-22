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
    private int $id;
    #[Column(type: Types::STRING, length: 255)]
    public string $descricao;
    #[Column(type: Types::STRING, length: 1)]
    public PlanoContaTipo $tipo;

    function __construct(string $descricao, PlanoContaTipo $tipo)
    {
        $this->descricao = $descricao;
        $this->tipo = $tipo;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
