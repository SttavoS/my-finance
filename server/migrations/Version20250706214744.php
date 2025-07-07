<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250706214744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes DROP tipo
        SQL);
        $this->addSql(<<<'SQL'
            ALTER INDEX idx_plano_conta_id RENAME TO IDX_97CF7B5C9463DA11
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes ADD tipo VARCHAR(1) NOT NULL NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN transacoes.tipo IS '(DC2Type:plano_conta_tipo_enum)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER INDEX idx_97cf7b5c9463da11 RENAME TO idx_plano_conta_id
        SQL);
    }
}
