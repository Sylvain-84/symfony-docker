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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?IngredientCategory $category = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?IngredientMineral $mineral = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?IngredientNutritional $nutritional = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?IngredientVitamine $vitamine = null;

    public function __construct(
        ?string $name = null,
        ?IngredientCategory $category = null,
        ?IngredientMineral $mineral = null,
        ?IngredientNutritional $nutritional = null,
        ?IngredientVitamine $vitamine = null
    ) {
        $this->name = $name;
        $this->category = $category;
        $this->mineral = $mineral;
        $this->nutritional = $nutritional;
        $this->vitamine = $vitamine;
    }

    public function getId(): ?int
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

    public function setMineral(IngredientMineral $mineral): static
    {
        $this->mineral = $mineral;

        return $this;
    }

    public function getNutritional(): ?IngredientNutritional
    {
        return $this->nutritional;
    }

    public function setNutritional(IngredientNutritional $nutritional): static
    {
        $this->nutritional = $nutritional;

        return $this;
    }

    public function getVitamine(): ?IngredientVitamine
    {
        return $this->vitamine;
    }

    public function setVitamine(IngredientVitamine $vitamine): static
    {
        $this->vitamine = $vitamine;

        return $this;
    }
}
