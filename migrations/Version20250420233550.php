<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250420233550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Seed ingredient_category table with initial categories';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
        INSERT INTO ingredient_category (id, name) VALUES
            (1, 'Fruit'),
            (2, 'Légume'),
            (3, 'Viande'),
            (4, 'Poisson'),
            (5, 'Céréales')
        ON CONFLICT (id) DO NOTHING;
    SQL);
        $this->addSql(<<<'SQL'
        SELECT setval('ingredient_category_id_seq',
                      (SELECT MAX(id) FROM ingredient_category), true);
    SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DELETE FROM ingredient_category
            WHERE id IN (1, 2, 3, 4, 5);
        SQL);
    }
}
