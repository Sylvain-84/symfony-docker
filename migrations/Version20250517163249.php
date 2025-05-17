<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250517163249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT fk_6baf787021f4a72c
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT fk_6baf7870978c9592
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT fk_6baf7870fc9f63f1
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE ingredient_minerals_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE ingredient_nutritionals_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE ingredient_vitamines_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE nutrition (id SERIAL NOT NULL, nrj_kj DOUBLE PRECISION DEFAULT NULL, nrj_kcal DOUBLE PRECISION DEFAULT NULL, eau DOUBLE PRECISION DEFAULT NULL, sel DOUBLE PRECISION DEFAULT NULL, sodium DOUBLE PRECISION DEFAULT NULL, magnesium DOUBLE PRECISION DEFAULT NULL, phosphore DOUBLE PRECISION DEFAULT NULL, potassium DOUBLE PRECISION DEFAULT NULL, calcium DOUBLE PRECISION DEFAULT NULL, manganese DOUBLE PRECISION DEFAULT NULL, fer DOUBLE PRECISION DEFAULT NULL, cuivre DOUBLE PRECISION DEFAULT NULL, zinc DOUBLE PRECISION DEFAULT NULL, selenium DOUBLE PRECISION DEFAULT NULL, iode DOUBLE PRECISION DEFAULT NULL, proteines DOUBLE PRECISION DEFAULT NULL, glucides DOUBLE PRECISION DEFAULT NULL, sucres DOUBLE PRECISION DEFAULT NULL, fructose DOUBLE PRECISION DEFAULT NULL, galactose DOUBLE PRECISION DEFAULT NULL, lactose DOUBLE PRECISION DEFAULT NULL, glucose DOUBLE PRECISION DEFAULT NULL, maltose DOUBLE PRECISION DEFAULT NULL, saccharose DOUBLE PRECISION DEFAULT NULL, amidon DOUBLE PRECISION DEFAULT NULL, polyols DOUBLE PRECISION DEFAULT NULL, fibres DOUBLE PRECISION DEFAULT NULL, lipides DOUBLE PRECISION DEFAULT NULL, ags DOUBLE PRECISION DEFAULT NULL, agmi DOUBLE PRECISION DEFAULT NULL, agpi DOUBLE PRECISION DEFAULT NULL, ag040 DOUBLE PRECISION DEFAULT NULL, ag060 DOUBLE PRECISION DEFAULT NULL, ag080 DOUBLE PRECISION DEFAULT NULL, ag100 DOUBLE PRECISION DEFAULT NULL, ag120 DOUBLE PRECISION DEFAULT NULL, ag140 DOUBLE PRECISION DEFAULT NULL, ag160 DOUBLE PRECISION DEFAULT NULL, ag180 DOUBLE PRECISION DEFAULT NULL, ag181_ole DOUBLE PRECISION DEFAULT NULL, ag182_lino DOUBLE PRECISION DEFAULT NULL, ag183_alino DOUBLE PRECISION DEFAULT NULL, ag204_ara DOUBLE PRECISION DEFAULT NULL, ag205_epa DOUBLE PRECISION DEFAULT NULL, ag206_dha DOUBLE PRECISION DEFAULT NULL, retinol DOUBLE PRECISION DEFAULT NULL, beta_carotene DOUBLE PRECISION DEFAULT NULL, vitamine_d DOUBLE PRECISION DEFAULT NULL, vitamine_e DOUBLE PRECISION DEFAULT NULL, vitamine_k1 DOUBLE PRECISION DEFAULT NULL, vitamine_k2 DOUBLE PRECISION DEFAULT NULL, vitamine_c DOUBLE PRECISION DEFAULT NULL, vitamine_b1 DOUBLE PRECISION DEFAULT NULL, vitamine_b2 DOUBLE PRECISION DEFAULT NULL, vitamine_b3 DOUBLE PRECISION DEFAULT NULL, vitamine_b5 DOUBLE PRECISION DEFAULT NULL, vitamine_b6 DOUBLE PRECISION DEFAULT NULL, vitamine_b12 DOUBLE PRECISION DEFAULT NULL, vitamine_b9 DOUBLE PRECISION DEFAULT NULL, alcool DOUBLE PRECISION DEFAULT NULL, acides_organiques DOUBLE PRECISION DEFAULT NULL, cholesterol DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_minerals
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_vitamines
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_nutritionals
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_6baf7870978c9592
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_6baf7870fc9f63f1
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX uniq_6baf787021f4a72c
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD nutrition_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP minerals_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP nutritionals_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP vitamines_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870B5D724CD FOREIGN KEY (nutrition_id) REFERENCES nutrition (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6BAF7870B5D724CD ON ingredient (nutrition_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP CONSTRAINT FK_6BAF7870B5D724CD
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE ingredient_minerals_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE ingredient_nutritionals_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE ingredient_vitamines_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_minerals (id SERIAL NOT NULL, calcium DOUBLE PRECISION DEFAULT NULL, cuivre DOUBLE PRECISION DEFAULT NULL, fer DOUBLE PRECISION DEFAULT NULL, iode DOUBLE PRECISION DEFAULT NULL, magnesium DOUBLE PRECISION DEFAULT NULL, manganese DOUBLE PRECISION DEFAULT NULL, phosphore DOUBLE PRECISION DEFAULT NULL, potassium DOUBLE PRECISION DEFAULT NULL, selenium DOUBLE PRECISION DEFAULT NULL, sodium DOUBLE PRECISION DEFAULT NULL, zinc DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_vitamines (id SERIAL NOT NULL, vitamine_a DOUBLE PRECISION DEFAULT NULL, beta_carotene DOUBLE PRECISION DEFAULT NULL, vitamine_d DOUBLE PRECISION DEFAULT NULL, vitamine_e DOUBLE PRECISION DEFAULT NULL, vitamine_k1 DOUBLE PRECISION DEFAULT NULL, vitamine_k2 DOUBLE PRECISION DEFAULT NULL, vitamine_c DOUBLE PRECISION DEFAULT NULL, vitamine_b1 DOUBLE PRECISION DEFAULT NULL, vitamine_b2 DOUBLE PRECISION DEFAULT NULL, vitamine_b3 DOUBLE PRECISION DEFAULT NULL, vitamine_b5 DOUBLE PRECISION DEFAULT NULL, vitamine_b6 DOUBLE PRECISION DEFAULT NULL, vitamine_b9 DOUBLE PRECISION DEFAULT NULL, vitamine_b12 DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_nutritionals (id SERIAL NOT NULL, kilocalories DOUBLE PRECISION DEFAULT '0' NOT NULL, proteine DOUBLE PRECISION DEFAULT '0' NOT NULL, glucides DOUBLE PRECISION DEFAULT '0' NOT NULL, lipides DOUBLE PRECISION DEFAULT '0' NOT NULL, sucres DOUBLE PRECISION DEFAULT NULL, amidon DOUBLE PRECISION DEFAULT NULL, fibres_alimentaires DOUBLE PRECISION DEFAULT NULL, cholesterol DOUBLE PRECISION DEFAULT NULL, acides_gras_satures DOUBLE PRECISION DEFAULT NULL, acides_gras_monoinsatures DOUBLE PRECISION DEFAULT NULL, acides_gras_polyinsatures DOUBLE PRECISION DEFAULT NULL, eau DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE nutrition
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_6BAF7870B5D724CD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD nutritionals_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD vitamines_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient RENAME COLUMN nutrition_id TO minerals_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT fk_6baf787021f4a72c FOREIGN KEY (minerals_id) REFERENCES ingredient_minerals (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT fk_6baf7870fc9f63f1 FOREIGN KEY (nutritionals_id) REFERENCES ingredient_nutritionals (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT fk_6baf7870978c9592 FOREIGN KEY (vitamines_id) REFERENCES ingredient_vitamines (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_6baf7870978c9592 ON ingredient (vitamines_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_6baf7870fc9f63f1 ON ingredient (nutritionals_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_6baf787021f4a72c ON ingredient (minerals_id)
        SQL);
    }
}
