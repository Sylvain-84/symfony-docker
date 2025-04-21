<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250420234008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Seed ingredients (and related mineral/nutritional/vitamine rows)';
    }

    public function up(Schema $schema): void
    {
        // List of [name, category_id]
        $ingredients = [
            ['Abricots', 1],
            ['Avocats', 2],
            ['Aubergines', 2],
            ['Ananas', 1],
            ['Bananes', 1],
            ['Betteraves', 2],
            ['Brocoli', 2],
            ['Blettes', 2],
            ['Carottes', 2],
            ['Courgettes', 2],
            ['Chou‑fleur', 2],
            ['Cerises', 1],
            ['Choux', 2],
            ['Datte', 1],
            ['Dattes séchées', 1],
            ['Durian', 1],
            ['Échalotes', 2],
            ['Fraises', 1],
            ['Figues', 1],
            ['Fèves', 2],
            ['Fenouil', 2],
            ['Gingembre', 2],
            ['Goyave', 1],
            ['Grenade', 1],
            ['Haricots verts', 2],
            ['Herbes de Provence', 2],
            ['Kiwis', 1],
            ['Kale', 2],
            ['Laitue', 2],
            ['Lentilles', 5],
            ['Litchis', 1],
            ['Mangues', 1],
            ['Melons', 1],
            ['Maïs', 5],
            ['Noix', 5],
            ['Navets', 2],
            ['Nectarines', 1],
            ['Oranges', 1],
            ['Oignons', 2],
            ['Olives', 2],
            ['Poivrons', 2],
            ['Pommes', 1],
            ['Pommes de terre', 2],
            ['Poires', 1],
            ['Pêches', 1],
            ['Quinoa', 5],
            ['Radis', 2],
            ['Raisins', 1],
            ['Rutabaga', 2],
            ['Salade', 2],
            ['Épinards', 2],
            ['Salsifis', 2],
            ['Sucrine', 2],
            ['Tomates', 2],
            ['Topinambour', 2],
            ['Tangerines', 1],
            ['Uvas', 1],
            ['Violette', 2],
            ['Pastèque', 1],
            ['Yuzu', 1],
            ['Zucchini', 2],
            ['Patates douces', 2],
            ['Chou frisé', 2],
            ['Prunes', 1],
            ['Mûres', 1],
            ['Cassis', 1],
            ['Framboises', 1],
            ['Myrtilles', 1],
            ['Abricots secs', 1],
            ['Pois chiches', 5],
            ['Champignons', 2],
            ['Pistaches', 5],
            ['Amandes', 5],
            ['Coriandre', 2],
            ['Persil', 2],
            ['Ciboulette', 2],
            ['Basilic', 2],
            ['Romarin', 2],
            ['Thym', 2],
        ];

        foreach ($ingredients as [$name, $categoryId]) {
            // Create one blank row in each related table and grab its new ID
            $this->addSql("INSERT INTO ingredient_mineral DEFAULT VALUES;");
            $this->addSql("INSERT INTO ingredient_nutritional DEFAULT VALUES;");
            $this->addSql("INSERT INTO ingredient_vitamine DEFAULT VALUES;");

            // Now insert the ingredient, wiring up the three new FK IDs
            $this->addSql(<<<'SQL'
INSERT INTO ingredient (mineral_id, nutritional_id, vitamine_id, category_id, name)
VALUES (
  currval('ingredient_mineral_id_seq'),
  currval('ingredient_nutritional_id_seq'),
  currval('ingredient_vitamine_id_seq'),
  ?, ?
)
SQL
                , [$categoryId, $name]
            );
        }
    }

    public function down(Schema $schema): void
    {
        // Remove all seeded ingredients
        $this->addSql("DELETE FROM ingredient WHERE name IN ('" . implode("','", array_map(static fn($i) => addslashes($i[0]), [
            ['Abricots'], ['Avocats'], ['Aubergines'], ['Ananas'], ['Bananes'], ['Betteraves'],
            ['Brocoli'], ['Blettes'], ['Carottes'], ['Courgettes'], ['Chou‑fleur'], ['Cerises'],
            ['Choux'], ['Datte'], ['Dattes séchées'], ['Durian'], ['Échalotes'], ['Fraises'],
            ['Figues'], ['Fèves'], ['Fenouil'], ['Gingembre'], ['Goyave'], ['Grenade'],
            ['Haricots verts'], ['Herbes de Provence'], ['Kiwis'], ['Kale'], ['Laitue'],
            ['Lentilles'], ['Litchis'], ['Mangues'], ['Melons'], ['Maïs'], ['Noix'],
            ['Navets'], ['Nectarines'], ['Oranges'], ['Oignons'], ['Olives'], ['Poivrons'],
            ['Pommes'], ['Pommes de terre'], ['Poires'], ['Pêches'], ['Quinoa'], ['Radis'],
            ['Raisins'], ['Rutabaga'], ['Salade'], ['Épinards'], ['Salsifis'], ['Sucrine'],
            ['Tomates'], ['Topinambour'], ['Tangerines'], ['Uvas'], ['Violette'], ['Pastèque'],
            ['Yuzu'], ['Zucchini'], ['Patates douces'], ['Chou frisé'], ['Prunes'], ['Mûres'],
            ['Cassis'], ['Framboises'], ['Myrtilles'], ['Abricots secs'], ['Pois chiches'],
            ['Champignons'], ['Pistaches'], ['Amandes'], ['Coriandre'], ['Persil'],
            ['Ciboulette'], ['Basilic'], ['Romarin'], ['Thym']
        ])) . "')");

        // Optionally clean up orphaned relation rows
        $this->addSql("DELETE FROM ingredient_mineral WHERE id NOT IN (SELECT mineral_id FROM ingredient);");
        $this->addSql("DELETE FROM ingredient_nutritional WHERE id NOT IN (SELECT nutritional_id FROM ingredient);");
        $this->addSql("DELETE FROM ingredient_vitamine WHERE id NOT IN (SELECT vitamine_id FROM ingredient);");
    }
}