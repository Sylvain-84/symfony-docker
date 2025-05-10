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
    private IngredientMinerals $minerals;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private IngredientNutritionals $nutritionals;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private IngredientVitamines $vitamines;

    /**
     * @var Collection<int, IngredientTag>
     */
    #[ORM\ManyToMany(targetEntity: IngredientTag::class)]
    private Collection $tags;

    public function __construct(
        string $name,
        IngredientCategory $category,
        ?IngredientMinerals $minerals = new IngredientMinerals(),
        ?IngredientNutritionals $nutritionals = new IngredientNutritionals(),
        ?IngredientVitamines $vitamines = new IngredientVitamines(),
    ) {
        $this->name = $name;
        $this->category = $category;
        $this->minerals = $minerals;
        $this->nutritionals = $nutritionals;
        $this->vitamines = $vitamines;
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

    public function getMinerals(): ?IngredientMinerals
    {
        return $this->minerals;
    }

    public function getNutritionals(): ?IngredientNutritionals
    {
        return $this->nutritionals;
    }

    public function getVitamines(): ?IngredientVitamines
    {
        return $this->vitamines;
    }

    public function setMinerals(IngredientMinerals $minerals): static
    {
        $this->minerals = $minerals;

        return $this;
    }

    public function setNutritionals(IngredientNutritionals $nutritionals): static
    {
        $this->nutritionals = $nutritionals;

        return $this;
    }

    public function setVitamines(IngredientVitamines $vitamines): static
    {
        $this->vitamines = $vitamines;

        return $this;
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
