<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250620202411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE planos_conta (
                id SERIAL NOT NULL,
                descricao VARCHAR(255) NOT NULL,
                tipo VARCHAR(1) NOT NULL,
                PRIMARY KEY(id)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transacoes (
                id SERIAL NOT NULL,
                historico VARCHAR(255) NOT NULL,
                tipo VARCHAR(1) NOT NULL,
                valor NUMERIC(10, 2) NOT NULL,
                data DATE NOT NULL,
                PRIMARY KEY(id)
            )
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE planos_conta
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transacoes
        SQL);
    }
}
