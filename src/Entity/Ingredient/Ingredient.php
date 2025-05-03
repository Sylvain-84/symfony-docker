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
    private readonly int $id;

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

    /**
     * @var Collection<int, IngredientTag>
     */
    #[ORM\ManyToMany(targetEntity: IngredientTag::class)]
    private Collection $tags;

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
}
