<?php

namespace App\DTO;

use App\Enum\PlanoContaTipo;

class PlanoContaResponseDTO
{
    function __construct(
        public int $id,
        public string $descricao,
        public PlanoContaTipo $tipo
    )
    {

    }
}
