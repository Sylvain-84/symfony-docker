<?php
// src/MessageHandler/SmsNotificationHandler.php
namespace App\MessageHandler;

use App\Entity\Ingredient;
use App\Message\SmsNotification;
use App\Repository\IngredientCategoryRepository;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function __invoke( $command): int
    {
        $category = $this->ingredientCategoryRepository
            ->find($command->getCategoryId());

        if (!$category) {
            throw new \InvalidArgumentException(sprintf(
                'Ingredient category #%d not found.',
                $command->getCategoryId()
            ));
        }

        $ingredient = new Ingredient(name: $command->getName(), category: $category);

        $this->ingredientRepository->save($ingredient);

        return $ingredient->getId();
    }
}
