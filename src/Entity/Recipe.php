<?php

namespace App\Entity;

use App\Enum\DifficultyEnum;
use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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

    public function __construct(
        string $name,
        RecipeCategory $category,
        DifficultyEnum $difficulty,
        ?string $description = null,
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->difficulty = $difficulty;
        $this->tags = new ArrayCollection();
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

    public function getDifficulty(): DifficultyEnum
    {
        return $this->difficulty;
    }

    public function setDifficulty(DifficultyEnum $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }
}
