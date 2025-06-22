<?php

namespace App\Enum;

enum PlanoContaTipo: string
{
    case Despesa = 'D';
    case Receita = 'R';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
