<?php

namespace App\DTO;

use App\Enum\PlanoContaTipo;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTransacaoDTO
{
    function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 255)]
        public string $historico,
        #[Assert\NotBlank]
        public PlanoContaTipo $tipo,
        #[Assert\NotBlank]
        public float $valor,
        #[Assert\NotBlank]
        public DateTime $data,
    )
    {
    }
}
