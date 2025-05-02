<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502101824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe_utensil (recipe_id INT NOT NULL, utensil_id INT NOT NULL, PRIMARY KEY(recipe_id, utensil_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D3CC32FC59D8A214 ON recipe_utensil (recipe_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D3CC32FCEC4313DE ON recipe_utensil (utensil_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_utensil ADD CONSTRAINT FK_D3CC32FC59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_utensil ADD CONSTRAINT FK_D3CC32FCEC4313DE FOREIGN KEY (utensil_id) REFERENCES utensil (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_utensil DROP CONSTRAINT FK_D3CC32FC59D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_utensil DROP CONSTRAINT FK_D3CC32FCEC4313DE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe_utensil
        SQL);
    }
}
