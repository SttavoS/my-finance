<?php

namespace App\DTO;

use App\Enum\PlanoContaTipo;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePlanoContaDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public string $descricao,
        #[Assert\NotBlank]
        #[Assert\Length(max: 1)]
        #[Assert\Choice(callback: [PlanoContaTipo::class, 'value'])]
        public string $tipo
    )
    {
    }
}
