<?php

declare(strict_types=1);

namespace App\Entity\Ingredient;

use App\Repository\Ingredient\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private IngredientNutrition $nutrition;

    /**
     * @var Collection<int, IngredientTag>
     */
    #[ORM\ManyToMany(targetEntity: IngredientTag::class)]
    private Collection $tags;

    public function __construct(
        string $name,
        IngredientCategory $category,
        ?IngredientNutrition $nutrition = new IngredientNutrition(),
    ) {
        $this->name = $name;
        $this->category = $category;
        $this->nutrition = $nutrition;
        $this->tags = new ArrayCollection();
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

    public function getNutrition(): IngredientNutrition
    {
        return $this->nutrition;
    }

    public function setNutrition(IngredientNutrition $nutrition): void
    {
        $this->nutrition = $nutrition;
    }

    /**
     * @return Collection<int, IngredientTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(IngredientTag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(IngredientTag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function clearTags(): void
    {
        $this->tags = new ArrayCollection();
    }
}
