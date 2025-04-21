<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421113812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER sucres DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER sucres DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER amidon DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER amidon DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER fibres_alimentaires DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER fibres_alimentaires DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER cholesterol DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER cholesterol DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_satures DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_satures DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_monoinsatures DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_monoinsatures DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_polyinsatures DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_polyinsatures DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER eau DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER eau DROP NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER sucres SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER sucres SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER amidon SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER amidon SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER fibres_alimentaires SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER fibres_alimentaires SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER cholesterol SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER cholesterol SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_satures SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_satures SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_monoinsatures SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_monoinsatures SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_polyinsatures SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER acides_gras_polyinsatures SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER eau SET DEFAULT '0'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_nutritional ALTER eau SET NOT NULL
        SQL);
    }
}
