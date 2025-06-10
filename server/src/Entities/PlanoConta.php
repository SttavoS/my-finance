<?php

namespace App\Entities;

use App\Enums\PlanoContaTipo;

class PlanoConta
{
    public int $id;
    public string $descricao;
    public PlanoContaTipo $tipo;

    function __construct(int $id, string $descricao, PlanoContaTipo $tipo)
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->tipo = $tipo;
    }
}
