<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430221852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER calcium TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER cuivre TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER fer TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER iode TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER magnesium TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER manganese TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER phosphore TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER potassium TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER selenium TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER sodium TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER zinc TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_a TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER beta_carotene TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_d TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_e TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_k1 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_k2 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_c TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_b1 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_b2 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_b3 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_b5 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_b6 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_b9 TYPE DOUBLE PRECISION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_b12 TYPE DOUBLE PRECISION
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_A TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER beta_carotene TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_D TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_E TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_K1 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_K2 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_C TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_B1 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_B2 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_B3 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_B5 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_B6 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_B9 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_vitamine ALTER vitamine_B12 TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER calcium TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER cuivre TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER fer TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER iode TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER magnesium TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER manganese TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER phosphore TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER potassium TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER selenium TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER sodium TYPE NUMERIC(10, 2)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_mineral ALTER zinc TYPE NUMERIC(10, 2)
        SQL);
    }
}
