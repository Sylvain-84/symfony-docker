<?php

namespace App\Entity;

use App\Repository\IngredientMineralRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientMineralRepository::class)]
class IngredientMineral
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $calcium = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $cuivre = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $fer = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $iode = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $magnesium = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $manganese = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $phosphore = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $potassium = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $selenium = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $sodium = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $zinc = null;

    public function __construct(
        ?string $calcium = null,
        ?string $cuivre = null,
        ?string $fer = null,
        ?string $iode = null,
        ?string $magnesium = null,
        ?string $manganese = null,
        ?string $phosphore = null,
        ?string $potassium = null,
        ?string $selenium = null,
        ?string $sodium = null,
        ?string $zinc = null,
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

    public function getCalcium(): ?string
    {
        return $this->calcium;
    }

    public function setCalcium(?string $calcium): self
    {
        $this->calcium = $calcium;

        return $this;
    }

    public function getCuivre(): ?string
    {
        return $this->cuivre;
    }

    public function setCuivre(?string $cuivre): self
    {
        $this->cuivre = $cuivre;

        return $this;
    }

    public function getFer(): ?string
    {
        return $this->fer;
    }

    public function setFer(?string $fer): self
    {
        $this->fer = $fer;

        return $this;
    }

    public function getIode(): ?string
    {
        return $this->iode;
    }

    public function setIode(?string $iode): self
    {
        $this->iode = $iode;

        return $this;
    }

    public function getMagnesium(): ?string
    {
        return $this->magnesium;
    }

    public function setMagnesium(?string $magnesium): self
    {
        $this->magnesium = $magnesium;

        return $this;
    }

    public function getManganese(): ?string
    {
        return $this->manganese;
    }

    public function setManganese(?string $manganese): self
    {
        $this->manganese = $manganese;

        return $this;
    }

    public function getPhosphore(): ?string
    {
        return $this->phosphore;
    }

    public function setPhosphore(?string $phosphore): self
    {
        $this->phosphore = $phosphore;

        return $this;
    }

    public function getPotassium(): ?string
    {
        return $this->potassium;
    }

    public function setPotassium(?string $potassium): self
    {
        $this->potassium = $potassium;

        return $this;
    }

    public function getSelenium(): ?string
    {
        return $this->selenium;
    }

    public function setSelenium(?string $selenium): self
    {
        $this->selenium = $selenium;

        return $this;
    }

    public function getSodium(): ?string
    {
        return $this->sodium;
    }

    public function setSodium(?string $sodium): self
    {
        $this->sodium = $sodium;

        return $this;
    }

    public function getZinc(): ?string
    {
        return $this->zinc;
    }

    public function setZinc(?string $zinc): self
    {
        $this->zinc = $zinc;

        return $this;
    }
}
