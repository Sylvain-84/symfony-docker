<?php

declare(strict_types=1);

namespace App\Entity\Recipe;

use App\Entity\Ingredient\IngredientNutritionals;
use App\Enum\DifficultyEnum;
use App\Repository\Recipe\RecipeRepository;
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

    /** @var Collection<int, RecipeInstruction> */
    #[ORM\OneToMany(
        targetEntity: RecipeInstruction::class,
        mappedBy: 'recipe',
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
    )]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $instructions;

    /** @var Collection<int, RecipeComment> */
    #[ORM\OneToMany(
        targetEntity: RecipeComment::class,
        mappedBy: 'recipe',
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    #[ORM\OrderBy(['createdAt' => 'DESC'])]
    private Collection $comments;

    /** @var Collection<int, RecipeIngredient> */
    #[ORM\OneToMany(
        mappedBy: 'recipe',
        targetEntity: RecipeIngredient::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true
    )]
    private Collection $recipeIngredients;

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
        $this->instructions = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
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

    public function setDescription(?string $description): static
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

    /**
     * @return Collection<int, RecipeInstruction>
     */
    public function getInstructions(): Collection
    {
        return $this->instructions;
    }

    public function addInstruction(RecipeInstruction $instruction): static
    {
        if (!$this->instructions->contains($instruction)) {
            $this->instructions->add($instruction);
        }

        return $this;
    }

    public function removeInstruction(RecipeInstruction $instruction): static
    {
        $this->instructions->removeElement($instruction);

        return $this;
    }

    public function clearInstructions(): void
    {
        $this->instructions = new ArrayCollection();
    }

    /**
     * @return Collection<int, RecipeComment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(RecipeComment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }

        return $this;
    }

    public function removeComment(RecipeComment $comment): self
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    public function addIngredient(RecipeIngredient $ingredient): self
    {
        if (!$this->recipeIngredients->contains($ingredient)) {
            $this->recipeIngredients->add($ingredient);
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function removeRecipeIngredient(RecipeIngredient $ingredient): self
    {
        $this->recipeIngredients->removeElement($ingredient);

        return $this;
    }

    public function clearRecipeIngredients(): void
    {
        $this->recipeIngredients = new ArrayCollection();
    }

    public function clearTags(): void
    {
        $this->tags = new ArrayCollection();
    }

    public function clearUtensils(): void
    {
        $this->utensils = new ArrayCollection();
    }

    public function getTotalNutritionals(): IngredientNutritionals
    {
        $totals = new IngredientNutritionals();

        foreach ($this->recipeIngredients as $recipeIngredient) {
            $nutritionals = $recipeIngredient
                ->getIngredient()
                ->getNutritionals();

            if (null === $nutritionals) {
                continue;
            }

            $multiplier = $recipeIngredient->getQuantity();

            $totals->setKilocalories(
                $totals->getKilocalories()
                + $nutritionals->getKilocalories()
                * $multiplier
            );
            $totals->setProteine(
                $totals->getProteine()
                + $nutritionals->getProteine()
                * $multiplier
            );
            $totals->setGlucides(
                $totals->getGlucides()
                + $nutritionals->getGlucides()
                * $multiplier
            );
            $totals->setLipides(
                $totals->getLipides()
                + $nutritionals->getLipides()
                * $multiplier
            );
            $totals->setSucres(
                ($totals->getSucres() ?? 0)
                + ($nutritionals->getSucres() ?? 0)
                * $multiplier
            );
            $totals->setAmidon(
                ($totals->getAmidon() ?? 0)
                + ($nutritionals->getAmidon() ?? 0)
                * $multiplier
            );
            $totals->setFibresAlimentaires(
                ($totals->getFibresAlimentaires() ?? 0)
                + ($nutritionals->getFibresAlimentaires() ?? 0)
                * $multiplier
            );
            $totals->setCholesterol(
                ($totals->getCholesterol() ?? 0)
                + ($nutritionals->getCholesterol() ?? 0)
                * $multiplier
            );
            $totals->setAcidesGrasSatures(
                ($totals->getAcidesGrasSatures() ?? 0)
                + ($nutritionals->getAcidesGrasSatures() ?? 0)
                * $multiplier
            );
            $totals->setAcidesGrasMonoinsatures(
                ($totals->getAcidesGrasMonoinsatures() ?? 0)
                + ($nutritionals->getAcidesGrasMonoinsatures() ?? 0)
                * $multiplier
            );
            $totals->setAcidesGrasPolyinsatures(
                ($totals->getAcidesGrasPolyinsatures() ?? 0)
                + ($nutritionals->getAcidesGrasPolyinsatures() ?? 0)
                * $multiplier
            );
            $totals->setEau(
                ($totals->getEau() ?? 0)
                + ($nutritionals->getEau() ?? 0)
                * $multiplier
            );
        }

        return $totals;
    }

    public function getNutritionalsPerServing(): IngredientNutritionals
    {
        $perServing = $this->getTotalNutritionals();
        $divisor = max(1, $this->servings); // avoid /0

        $perServing->setKilocalories($perServing->getKilocalories() / $divisor);
        $perServing->setProteine($perServing->getProteine() / $divisor);
        $perServing->setGlucides($perServing->getGlucides() / $divisor);
        $perServing->setLipides($perServing->getLipides() / $divisor);
        $perServing->setSucres(($perServing->getSucres() ?? 0) / $divisor);
        $perServing->setAmidon(($perServing->getAmidon() ?? 0) / $divisor);
        $perServing->setFibresAlimentaires(($perServing->getFibresAlimentaires() ?? 0) / $divisor);
        $perServing->setCholesterol(($perServing->getCholesterol() ?? 0) / $divisor);
        $perServing->setAcidesGrasSatures(($perServing->getAcidesGrasSatures() ?? 0) / $divisor);
        $perServing->setAcidesGrasMonoinsatures(($perServing->getAcidesGrasMonoinsatures() ?? 0) / $divisor);
        $perServing->setAcidesGrasPolyinsatures(($perServing->getAcidesGrasPolyinsatures() ?? 0) / $divisor);
        $perServing->setEau(($perServing->getEau() ?? 0) / $divisor);

        return $perServing;
    }
}
