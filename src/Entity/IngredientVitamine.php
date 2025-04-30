<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class IngredientVitamine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'vitamine_A', type: 'float', nullable: true)]
    private ?float $vitamineA = null;

    #[ORM\Column(name: 'beta_carotene', type: 'float', nullable: true)]
    private ?float $betaCarotene = null;

    #[ORM\Column(name: 'vitamine_D', type: 'float', nullable: true)]
    private ?float $vitamineD = null;

    #[ORM\Column(name: 'vitamine_E', type: 'float', nullable: true)]
    private ?float $vitamineE = null;

    #[ORM\Column(name: 'vitamine_K1', type: 'float', nullable: true)]
    private ?float $vitamineK1 = null;

    #[ORM\Column(name: 'vitamine_K2', type: 'float', nullable: true)]
    private ?float $vitamineK2 = null;

    #[ORM\Column(name: 'vitamine_C', type: 'float', nullable: true)]
    private ?float $vitamineC = null;

    #[ORM\Column(name: 'vitamine_B1', type: 'float', nullable: true)]
    private ?float $vitamineB1 = null;

    #[ORM\Column(name: 'vitamine_B2', type: 'float', nullable: true)]
    private ?float $vitamineB2 = null;

    #[ORM\Column(name: 'vitamine_B3', type: 'float', nullable: true)]
    private ?float $vitamineB3 = null;

    #[ORM\Column(name: 'vitamine_B5', type: 'float', nullable: true)]
    private ?float $vitamineB5 = null;

    #[ORM\Column(name: 'vitamine_B6', type: 'float', nullable: true)]
    private ?float $vitamineB6 = null;

    #[ORM\Column(name: 'vitamine_B9', type: 'float', nullable: true)]
    private ?float $vitamineB9 = null;

    #[ORM\Column(name: 'vitamine_B12', type: 'float', nullable: true)]
    private ?float $vitamineB12 = null;

    public function __construct(
        ?float $vitamineA = null,
        ?float $betaCarotene = null,
        ?float $vitamineD = null,
        ?float $vitamineE = null,
        ?float $vitamineK1 = null,
        ?float $vitamineK2 = null,
        ?float $vitamineC = null,
        ?float $vitamineB1 = null,
        ?float $vitamineB2 = null,
        ?float $vitamineB3 = null,
        ?float $vitamineB5 = null,
        ?float $vitamineB6 = null,
        ?float $vitamineB9 = null,
        ?float $vitamineB12 = null,
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

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setVitamineA(?float $vitamineA): void
    {
        $this->vitamineA = $vitamineA;
    }

    public function setBetaCarotene(?float $betaCarotene): void
    {
        $this->betaCarotene = $betaCarotene;
    }

    public function setVitamineD(?float $vitamineD): void
    {
        $this->vitamineD = $vitamineD;
    }

    public function setVitamineE(?float $vitamineE): void
    {
        $this->vitamineE = $vitamineE;
    }

    public function setVitamineK1(?float $vitamineK1): void
    {
        $this->vitamineK1 = $vitamineK1;
    }

    public function setVitamineK2(?float $vitamineK2): void
    {
        $this->vitamineK2 = $vitamineK2;
    }

    public function setVitamineC(?float $vitamineC): void
    {
        $this->vitamineC = $vitamineC;
    }

    public function setVitamineB1(?float $vitamineB1): void
    {
        $this->vitamineB1 = $vitamineB1;
    }

    public function setVitamineB2(?float $vitamineB2): void
    {
        $this->vitamineB2 = $vitamineB2;
    }

    public function setVitamineB3(?float $vitamineB3): void
    {
        $this->vitamineB3 = $vitamineB3;
    }

    public function setVitamineB5(?float $vitamineB5): void
    {
        $this->vitamineB5 = $vitamineB5;
    }

    public function setVitamineB6(?float $vitamineB6): void
    {
        $this->vitamineB6 = $vitamineB6;
    }

    public function setVitamineB9(?float $vitamineB9): void
    {
        $this->vitamineB9 = $vitamineB9;
    }

    public function setVitamineB12(?float $vitamineB12): void
    {
        $this->vitamineB12 = $vitamineB12;
    }
}
