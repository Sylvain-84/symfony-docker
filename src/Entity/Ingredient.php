<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?IngredientCategory $category = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private IngredientMineral $mineral;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private IngredientNutritional $nutritional;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private IngredientVitamine $vitamine;

    public function __construct(
        string $name,
        IngredientCategory $category,
        ?IngredientMineral $mineral = new IngredientMineral(),
        ?IngredientNutritional $nutritional = new IngredientNutritional(),
        ?IngredientVitamine $vitamine = new IngredientVitamine(),
    ) {
        $this->name = $name;
        $this->category = $category;
        $this->mineral = $mineral;
        $this->nutritional = $nutritional;
        $this->vitamine = $vitamine;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?IngredientCategory
    {
        return $this->category;
    }

    public function setCategory(?IngredientCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getMineral(): ?IngredientMineral
    {
        return $this->mineral;
    }

    public function getNutritional(): ?IngredientNutritional
    {
        return $this->nutritional;
    }

    public function getVitamine(): ?IngredientVitamine
    {
        return $this->vitamine;
    }
}
