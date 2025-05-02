<?php

namespace App\Entity;

use App\Enum\DifficultyEnum;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    private RecipeCategory $category;

    /**
     * @var Collection<int, RecipeTag>
     */
    #[ORM\ManyToMany(targetEntity: RecipeTag::class)]
    private Collection $tags;

    #[ORM\Column(type: 'string', enumType: DifficultyEnum::class)]
    private DifficultyEnum $difficulty;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive]
    private int $servings;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private int $preparationTime;

    #[ORM\Column(type: 'integer')]
    #[Assert\PositiveOrZero]
    private int $cookingTime;

    /**
     * @var Collection<int, Utensil>
     */
    #[ORM\ManyToMany(targetEntity: Utensil::class)]
    private Collection $utensils;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Range(min: 0, max: 10)]
    private ?int $note = null;

    public function __construct(
        string $name,
        RecipeCategory $category,
        DifficultyEnum $difficulty,
        int $servings = 1,
        int $preparationTime = 0,
        int $cookingTime = 0,
        ?string $description = null,
        ?int $note = null,
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->servings = $servings;
        $this->preparationTime = $preparationTime;
        $this->cookingTime = $cookingTime;
        $this->difficulty = $difficulty;
        $this->note = $note;
        $this->tags = new ArrayCollection();
        $this->utensils = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): RecipeCategory
    {
        return $this->category;
    }

    public function setCategory(RecipeCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, RecipeTag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(RecipeTag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(RecipeTag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, Utensil>
     */
    public function getUtensils(): Collection
    {
        return $this->utensils;
    }

    public function addUtensil(Utensil $utensil): static
    {
        if (!$this->utensils->contains($utensil)) {
            $this->utensils->add($utensil);
        }

        return $this;
    }

    public function removeUtensil(Utensil $utensil): static
    {
        $this->utensils->removeElement($utensil);

        return $this;
    }

    public function getDifficulty(): DifficultyEnum
    {
        return $this->difficulty;
    }

    public function setDifficulty(DifficultyEnum $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getServings(): int
    {
        return $this->servings;
    }

    public function setServings(int $servings): static
    {
        $this->servings = $servings;

        return $this;
    }

    public function getPreparationTime(): int
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(int $preparationTime): static
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): int
    {
        return $this->cookingTime;
    }

    public function setCookingTime(int $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getTotalTime(): int
    {
        return $this->preparationTime + $this->cookingTime;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }
}
