<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250503084601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe_instruction (id SERIAL NOT NULL, recipe_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, position INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_AF48AF3259D8A214 ON recipe_instruction (recipe_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_instruction ADD CONSTRAINT FK_AF48AF3259D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER servings DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX uniq_recipe_position ON recipe_instruction (recipe_id, position);
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_instruction DROP CONSTRAINT FK_AF48AF3259D8A214
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe_instruction
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER servings SET DEFAULT 1
        SQL);
    }
}
