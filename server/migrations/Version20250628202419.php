<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250628202419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes ADD plano_conta_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes
            ADD CONSTRAINT FK_plano_conta_id
            FOREIGN KEY (plano_conta_id)
                REFERENCES planos_conta (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_plano_conta_id ON transacoes (plano_conta_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes DROP CONSTRAINT FK_plano_conta_id
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_plano_conta_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transacoes DROP plano_conta_id
        SQL);
    }
}
