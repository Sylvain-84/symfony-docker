<?php

namespace App\Entity;

use App\Repository\IngredientVitamineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientVitamineRepository::class)]
class IngredientVitamine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'vitamine_A', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineA = null;

    #[ORM\Column(name: 'beta_carotene', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $betaCarotene = null;

    #[ORM\Column(name: 'vitamine_D', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineD = null;

    #[ORM\Column(name: 'vitamine_E', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineE = null;

    #[ORM\Column(name: 'vitamine_K1', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineK1 = null;

    #[ORM\Column(name: 'vitamine_K2', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineK2 = null;

    #[ORM\Column(name: 'vitamine_C', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineC = null;

    #[ORM\Column(name: 'vitamine_B1', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineB1 = null;

    #[ORM\Column(name: 'vitamine_B2', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineB2 = null;

    #[ORM\Column(name: 'vitamine_B3', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineB3 = null;

    #[ORM\Column(name: 'vitamine_B5', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineB5 = null;

    #[ORM\Column(name: 'vitamine_B6', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineB6 = null;

    #[ORM\Column(name: 'vitamine_B9', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineB9 = null;

    #[ORM\Column(name: 'vitamine_B12', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $vitamineB12 = null;

    public function __construct(
        ?string $vitamineA = null,
        ?string $betaCarotene = null,
        ?string $vitamineD = null,
        ?string $vitamineE = null,
        ?string $vitamineK1 = null,
        ?string $vitamineK2 = null,
        ?string $vitamineC = null,
        ?string $vitamineB1 = null,
        ?string $vitamineB2 = null,
        ?string $vitamineB3 = null,
        ?string $vitamineB5 = null,
        ?string $vitamineB6 = null,
        ?string $vitamineB9 = null,
        ?string $vitamineB12 = null,
    ) {
        $this->vitamineA = $vitamineA;
        $this->betaCarotene = $betaCarotene;
        $this->vitamineD = $vitamineD;
        $this->vitamineE = $vitamineE;
        $this->vitamineK1 = $vitamineK1;
        $this->vitamineK2 = $vitamineK2;
        $this->vitamineC = $vitamineC;
        $this->vitamineB1 = $vitamineB1;
        $this->vitamineB2 = $vitamineB2;
        $this->vitamineB3 = $vitamineB3;
        $this->vitamineB5 = $vitamineB5;
        $this->vitamineB6 = $vitamineB6;
        $this->vitamineB9 = $vitamineB9;
        $this->vitamineB12 = $vitamineB12;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVitamineA(): ?string
    {
        return $this->vitamineA;
    }

    public function setVitamineA(?string $vitamineA): self
    {
        $this->vitamineA = $vitamineA;

        return $this;
    }

    public function getBetaCarotene(): ?string
    {
        return $this->betaCarotene;
    }

    public function setBetaCarotene(?string $betaCarotene): self
    {
        $this->betaCarotene = $betaCarotene;

        return $this;
    }

    public function getVitamineD(): ?string
    {
        return $this->vitamineD;
    }

    public function setVitamineD(?string $vitamineD): self
    {
        $this->vitamineD = $vitamineD;

        return $this;
    }

    public function getVitamineE(): ?string
    {
        return $this->vitamineE;
    }

    public function setVitamineE(?string $vitamineE): self
    {
        $this->vitamineE = $vitamineE;

        return $this;
    }

    public function getVitamineK1(): ?string
    {
        return $this->vitamineK1;
    }

    public function setVitamineK1(?string $vitamineK1): self
    {
        $this->vitamineK1 = $vitamineK1;

        return $this;
    }

    public function getVitamineK2(): ?string
    {
        return $this->vitamineK2;
    }

    public function setVitamineK2(?string $vitamineK2): self
    {
        $this->vitamineK2 = $vitamineK2;

        return $this;
    }

    public function getVitamineC(): ?string
    {
        return $this->vitamineC;
    }

    public function setVitamineC(?string $vitamineC): self
    {
        $this->vitamineC = $vitamineC;

        return $this;
    }

    public function getVitamineB1(): ?string
    {
        return $this->vitamineB1;
    }

    public function setVitamineB1(?string $vitamineB1): self
    {
        $this->vitamineB1 = $vitamineB1;

        return $this;
    }

    public function getVitamineB2(): ?string
    {
        return $this->vitamineB2;
    }

    public function setVitamineB2(?string $vitamineB2): self
    {
        $this->vitamineB2 = $vitamineB2;

        return $this;
    }

    public function getVitamineB3(): ?string
    {
        return $this->vitamineB3;
    }

    public function setVitamineB3(?string $vitamineB3): self
    {
        $this->vitamineB3 = $vitamineB3;

        return $this;
    }

    public function getVitamineB5(): ?string
    {
        return $this->vitamineB5;
    }

    public function setVitamineB5(?string $vitamineB5): self
    {
        $this->vitamineB5 = $vitamineB5;

        return $this;
    }

    public function getVitamineB6(): ?string
    {
        return $this->vitamineB6;
    }

    public function setVitamineB6(?string $vitamineB6): self
    {
        $this->vitamineB6 = $vitamineB6;

        return $this;
    }

    public function getVitamineB9(): ?string
    {
        return $this->vitamineB9;
    }

    public function setVitamineB9(?string $vitamineB9): self
    {
        $this->vitamineB9 = $vitamineB9;

        return $this;
    }

    public function getVitamineB12(): ?string
    {
        return $this->vitamineB12;
    }

    public function setVitamineB12(?string $vitamineB12): self
    {
        $this->vitamineB12 = $vitamineB12;

        return $this;
    }
}
