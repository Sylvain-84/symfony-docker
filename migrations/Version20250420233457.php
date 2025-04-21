<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250420233457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient (id SERIAL NOT NULL, category_id INT DEFAULT NULL, mineral_id INT NOT NULL, nutritional_id INT NOT NULL, vitamine_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6BAF787012469DE2 ON ingredient (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6BAF787021F4A72C ON ingredient (mineral_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6BAF7870FC9F63F1 ON ingredient (nutritional_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6BAF7870978C9592 ON ingredient (vitamine_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_mineral (id SERIAL NOT NULL, calcium NUMERIC(10, 2) DEFAULT NULL, cuivre NUMERIC(10, 2) DEFAULT NULL, fer NUMERIC(10, 2) DEFAULT NULL, iode NUMERIC(10, 2) DEFAULT NULL, magnesium NUMERIC(10, 2) DEFAULT NULL, manganese NUMERIC(10, 2) DEFAULT NULL, phosphore NUMERIC(10, 2) DEFAULT NULL, potassium NUMERIC(10, 2) DEFAULT NULL, selenium NUMERIC(10, 2) DEFAULT NULL, sodium NUMERIC(10, 2) DEFAULT NULL, zinc NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_nutritional (id SERIAL NOT NULL, kilocalories DOUBLE PRECISION DEFAULT '0' NOT NULL, proteine DOUBLE PRECISION DEFAULT '0' NOT NULL, glucides DOUBLE PRECISION DEFAULT '0' NOT NULL, lipides DOUBLE PRECISION DEFAULT '0' NOT NULL, sucres DOUBLE PRECISION DEFAULT '0' NOT NULL, amidon DOUBLE PRECISION DEFAULT '0' NOT NULL, fibres_alimentaires DOUBLE PRECISION DEFAULT '0' NOT NULL, cholesterol DOUBLE PRECISION DEFAULT '0' NOT NULL, acides_gras_satures DOUBLE PRECISION DEFAULT '0' NOT NULL, acides_gras_monoinsatures DOUBLE PRECISION DEFAULT '0' NOT NULL, acides_gras_polyinsatures DOUBLE PRECISION DEFAULT '0' NOT NULL, eau DOUBLE PRECISION DEFAULT '0' NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_vitamine (id SERIAL NOT NULL, vitamine_A NUMERIC(10, 2) DEFAULT NULL, beta_carotene NUMERIC(10, 2) DEFAULT NULL, vitamine_D NUMERIC(10, 2) DEFAULT NULL, vitamine_E NUMERIC(10, 2) DEFAULT NULL, vitamine_K1 NUMERIC(10, 2) DEFAULT NULL, vitamine_K2 NUMERIC(10, 2) DEFAULT NULL, vitamine_C NUMERIC(10, 2) DEFAULT NULL, vitamine_B1 NUMERIC(10, 2) DEFAULT NULL, vitamine_B2 NUMERIC(10, 2) DEFAULT NULL, vitamine_B3 NUMERIC(10, 2) DEFAULT NULL, vitamine_B5 NUMERIC(10, 2) DEFAULT NULL, vitamine_B6 NUMERIC(10, 2) DEFAULT NULL, vitamine_B9 NUMERIC(10, 2) DEFAULT NULL, vitamine_B12 NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787012469DE2 FOREIGN KEY (category_id) REFERENCES ingredient_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787021F4A72C FOREIGN KEY (mineral_id) REFERENCES ingredient_mineral (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870FC9F63F1 FOREIGN KEY (nutritional_id) REFERENCES ingredient_nutritional (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870978C9592 FOREIGN KEY (vitamine_id) REFERENCES ingredient_vitamine (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT FK_6BAF787012469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT FK_6BAF787021F4A72C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT FK_6BAF7870FC9F63F1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT FK_6BAF7870978C9592
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_mineral
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_nutritional
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_vitamine
        SQL);
    }
}
