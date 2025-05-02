<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250502100240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE utensil (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER preparation_time DROP DEFAULT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER cooking_time DROP DEFAULT
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utensil
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER preparation_time SET DEFAULT 0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE recipe ALTER cooking_time SET DEFAULT 0
        SQL);
    }
}
