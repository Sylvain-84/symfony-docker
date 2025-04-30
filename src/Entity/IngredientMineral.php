<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\IngredientMineralRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientMineralRepository::class)]
class IngredientMineral
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $calcium = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $cuivre = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $fer = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $iode = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $magnesium = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $manganese = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $phosphore = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $potassium = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $selenium = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $sodium = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $zinc = null;

    public function __construct(
        ?float $calcium = null,
        ?float $cuivre = null,
        ?float $fer = null,
        ?float $iode = null,
        ?float $magnesium = null,
        ?float $manganese = null,
        ?float $phosphore = null,
        ?float $potassium = null,
        ?float $selenium = null,
        ?float $sodium = null,
        ?float $zinc = null,
    ) {
        $this->calcium = $calcium;
        $this->cuivre = $cuivre;
        $this->fer = $fer;
        $this->iode = $iode;
        $this->magnesium = $magnesium;
        $this->manganese = $manganese;
        $this->phosphore = $phosphore;
        $this->potassium = $potassium;
        $this->selenium = $selenium;
        $this->sodium = $sodium;
        $this->zinc = $zinc;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalcium(): ?float
    {
        return $this->calcium;
    }

    public function setCalcium(?float $calcium): self
    {
        $this->calcium = $calcium;

        return $this;
    }

    public function getCuivre(): ?float
    {
        return $this->cuivre;
    }

    public function setCuivre(?float $cuivre): self
    {
        $this->cuivre = $cuivre;

        return $this;
    }

    public function getFer(): ?float
    {
        return $this->fer;
    }

    public function setFer(?float $fer): self
    {
        $this->fer = $fer;

        return $this;
    }

    public function getIode(): ?float
    {
        return $this->iode;
    }

    public function setIode(?float $iode): self
    {
        $this->iode = $iode;

        return $this;
    }

    public function getMagnesium(): ?float
    {
        return $this->magnesium;
    }

    public function setMagnesium(?float $magnesium): self
    {
        $this->magnesium = $magnesium;

        return $this;
    }

    public function getManganese(): ?float
    {
        return $this->manganese;
    }

    public function setManganese(?float $manganese): self
    {
        $this->manganese = $manganese;

        return $this;
    }

    public function getPhosphore(): ?float
    {
        return $this->phosphore;
    }

    public function setPhosphore(?float $phosphore): self
    {
        $this->phosphore = $phosphore;

        return $this;
    }

    public function getPotassium(): ?float
    {
        return $this->potassium;
    }

    public function setPotassium(?float $potassium): self
    {
        $this->potassium = $potassium;

        return $this;
    }

    public function getSelenium(): ?float
    {
        return $this->selenium;
    }

    public function setSelenium(?float $selenium): self
    {
        $this->selenium = $selenium;

        return $this;
    }

    public function getSodium(): ?float
    {
        return $this->sodium;
    }

    public function setSodium(?float $sodium): self
    {
        $this->sodium = $sodium;

        return $this;
    }

    public function getZinc(): ?float
    {
        return $this->zinc;
    }

    public function setZinc(?float $zinc): self
    {
        $this->zinc = $zinc;

        return $this;
    }
}
