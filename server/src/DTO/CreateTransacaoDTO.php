<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTransacaoDTO
{
    function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 255)]
        public string $historico,
        #[Assert\NotBlank]
        public int $planoContaId,
        #[Assert\NotBlank]
        public float $valor,
        #[Assert\NotBlank]
        public string $data,
    )
    {
    }
}
