<?php

namespace App\Doctrine\Type;

use App\Enum\PlanoContaTipo;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PlanoContaTipoType extends Type
{
    public const string NAME = 'plano_conta_tipo_enum';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return "VARCHAR(1) NOT NULL";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value !== null ? PlanoContaTipo::from($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof PlanoContaTipo ? $value->value : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
