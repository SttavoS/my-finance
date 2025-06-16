<?php

namespace App\Entities;

use App\Enums\PlanoContaTipo;
use DateTime;

class Transacao
{
    public int $id;
    public string $historico;
    public PlanoContaTipo $tipo;
    public float $valor;
    public DateTime $data;
}
