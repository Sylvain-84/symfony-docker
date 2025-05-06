<?php

declare(strict_types=1);

namespace App\Entity\Recipe;

use App\Repository\Recipe\RecipeInstructionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['recipe', 'position'],
    message: 'Une instruction existe déjà à cette position pour cette recette.',
    errorPath: 'position'
)]
#[ORM\UniqueConstraint(name: 'uniq_recipe_position', columns: ['recipe_id', 'position'])]
#[ORM\Entity(repositoryClass: RecipeInstructionRepository::class)]
class RecipeInstruction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\ManyToOne(inversedBy: 'instructions')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Recipe $recipe;

    #[Assert\Positive]
    #[ORM\Column(type: 'integer')]
    private int $position;

    public function __construct(
        string $name,
        string $description,
        Recipe $recipe,
        int $position,
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->recipe = $recipe;
        $this->position = $position;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
