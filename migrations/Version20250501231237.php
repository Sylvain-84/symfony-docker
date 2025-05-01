<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501231237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_ingredient_tag (ingredient_id INT NOT NULL, ingredient_tag_id INT NOT NULL, PRIMARY KEY(ingredient_id, ingredient_tag_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E277767A933FE08C ON ingredient_ingredient_tag (ingredient_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E277767A56A8A350 ON ingredient_ingredient_tag (ingredient_tag_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient_tag (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_ingredient_tag ADD CONSTRAINT FK_E277767A933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_ingredient_tag ADD CONSTRAINT FK_E277767A56A8A350 FOREIGN KEY (ingredient_tag_id) REFERENCES ingredient_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER difficulty DROP DEFAULT
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_ingredient_tag DROP CONSTRAINT FK_E277767A933FE08C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient_ingredient_tag DROP CONSTRAINT FK_E277767A56A8A350
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_ingredient_tag
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient_tag
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER difficulty SET DEFAULT 'easy'
        SQL);
    }
}
