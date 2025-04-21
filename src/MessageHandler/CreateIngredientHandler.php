<?php
// src/MessageHandler/SmsNotificationHandler.php
namespace App\MessageHandler;

use App\Entity\Ingredient;
use App\Message\SmsNotification;
use App\Entity\IngredientMineral;
use App\Entity\IngredientVitamine;
use App\Entity\IngredientNutritional;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\IngredientCategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateIngredientCommand::class)]
class CreateIngredientHandler
{

    public function __construct(
        private EntityManagerInterface $em, 
        private IngredientRepository $ingredientRepository, 
        private IngredientCategoryRepository $ingredientCategoryRepository,
        )
    {
    }

    public function __invoke(CreateIngredientCommand $command): int
    {
        $category = $this->ingredientCategoryRepository
            ->find($command->category);

        if (!$category) {
            throw new \InvalidArgumentException(sprintf(
                'Ingredient category #%d not found.',
                $command->category
            ));
        }

        $ingredientMineral = new IngredientMineral(
            calcium: $command->minerals->calcium,
            cuivre: $command->minerals->cuivre,
            fer: $command->minerals->fer,
            iode: $command->minerals->iode,
            magnesium: $command->minerals->magnesium,
            manganese: $command->minerals->manganese,
            phosphore: $command->minerals->phosphore,
            potassium: $command->minerals->potassium,
            selenium: $command->minerals->selenium,
            sodium: $command->minerals->sodium,
            zinc: $command->minerals->zinc
        );
        $ingredientNutritional = new IngredientNutritional(
            kilocalories: $command->nutritionals->kilocalories,
            proteine: $command->nutritionals->proteine,
            glucides: $command->nutritionals->glucides,
            lipides: $command->nutritionals->lipides,
            sucres: $command->nutritionals->sucres,
            amidon: $command->nutritionals->amidon,
            fibresAlimentaires: $command->nutritionals->fibresAlimentaires,
            cholesterol: $command->nutritionals->cholesterol,
            acidesGrasSatures: $command->nutritionals->acidesGrasSatures,
            acidesGrasMonoinsatures: $command->nutritionals->acidesGrasMonoinsatures,
            acidesGrasPolyinsatures: $command->nutritionals->acidesGrasPolyinsatures,
            eau: $command->nutritionals->eau
        );
        $ingredientVitamine = new IngredientVitamine(
            vitamineA: $command->vitamines->vitamineA,
            betaCarotene: $command->vitamines->betaCarotene,
            vitamineD: $command->vitamines->vitamineD,
            vitamineE: $command->vitamines->vitamineE,
            vitamineK1: $command->vitamines->vitamineK1,
            vitamineK2: $command->vitamines->vitamineK2,
            vitamineC: $command->vitamines->vitamineC,
            vitamineB1: $command->vitamines->vitamineB1,
            vitamineB2: $command->vitamines->vitamineB2,
            vitamineB3: $command->vitamines->vitamineB3,
            vitamineB5: $command->vitamines->vitamineB5,
            vitamineB6: $command->vitamines->vitamineB6,
            vitamineB9: $command->vitamines->vitamineB9,
            vitamineB12: $command->vitamines->vitamineB12
        );

        $ingredient = new Ingredient(
            name: $command->name, 
            category: $category,
            mineral: $ingredientMineral,
            nutritional: $ingredientNutritional,
            vitamine: $ingredientVitamine,
        );

        $this->ingredientRepository->save($ingredient);

        return $ingredient->getId();
    }
}
