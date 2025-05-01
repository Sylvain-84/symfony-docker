<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501222245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE recipe_recipe_tag (recipe_id INT NOT NULL, recipe_tag_id INT NOT NULL, PRIMARY KEY(recipe_id, recipe_tag_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3BA055AC59D8A214 ON recipe_recipe_tag (recipe_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3BA055AC37CC7D30 ON recipe_recipe_tag (recipe_tag_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_recipe_tag ADD CONSTRAINT FK_3BA055AC59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_recipe_tag ADD CONSTRAINT FK_3BA055AC37CC7D30 FOREIGN KEY (recipe_tag_id) REFERENCES recipe_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_recipe_tag DROP CONSTRAINT FK_3BA055AC59D8A214
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe_recipe_tag DROP CONSTRAINT FK_3BA055AC37CC7D30
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE recipe_recipe_tag
        SQL);
    }
}
