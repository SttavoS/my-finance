<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250628190837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add custom type for plano_conta_tipo_enum';
    }

    public function up(Schema $schema): void
    {
        // Split the type change and NOT NULL constraint into separate statements
        $this->addSql(<<<'SQL'
            ALTER TABLE planos_conta ALTER tipo TYPE VARCHAR(1)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE planos_conta ALTER tipo SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN planos_conta.tipo IS '(DC2Type:plano_conta_tipo_enum)'
        SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes ALTER tipo TYPE VARCHAR(1)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes ALTER tipo SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN transacoes.tipo IS '(DC2Type:plano_conta_tipo_enum)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes ALTER tipo DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes ALTER tipo TYPE VARCHAR(1)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN transacoes.tipo IS NULL
        SQL);

        $this->addSql(<<<'SQL'
            ALTER TABLE planos_conta ALTER tipo DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE planos_conta ALTER tipo TYPE VARCHAR(1)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN planos_conta.tipo IS NULL
        SQL);
    }
}
