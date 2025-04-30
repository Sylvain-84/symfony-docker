<?php

namespace App\Entity;

use App\Repository\IngredientNutritionalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientNutritionalRepository::class)]
class IngredientNutritional
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $kilocalories = 0.0;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $proteine = 0.0;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $glucides = 0.0;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $lipides = 0.0;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $sucres = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $amidon = null;

    #[ORM\Column(name: 'fibres_alimentaires', type: 'float', nullable: true)]
    private ?float $fibresAlimentaires = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $cholesterol = null;

    #[ORM\Column(name: 'acides_gras_satures', type: 'float', nullable: true)]
    private ?float $acidesGrasSatures = null;

    #[ORM\Column(name: 'acides_gras_monoinsatures', type: 'float', nullable: true)]
    private ?float $acidesGrasMonoinsatures = null;

    #[ORM\Column(name: 'acides_gras_polyinsatures', type: 'float', nullable: true)]
    private ?float $acidesGrasPolyinsatures = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $eau = null;

    public function __construct(
        ?float $kilocalories = 0.0,
        ?float $proteine = 0.0,
        ?float $glucides = 0.0,
        ?float $lipides = 0.0,
        ?float $sucres = null,
        ?float $amidon = null,
        ?float $fibresAlimentaires = null,
        ?float $cholesterol = null,
        ?float $acidesGrasSatures = null,
        ?float $acidesGrasMonoinsatures = null,
        ?float $acidesGrasPolyinsatures = null,
        ?float $eau = null,
    ) {
        $this->kilocalories = $kilocalories;
        $this->proteine = $proteine;
        $this->glucides = $glucides;
        $this->lipides = $lipides;
        $this->sucres = $sucres;
        $this->amidon = $amidon;
        $this->fibresAlimentaires = $fibresAlimentaires;
        $this->cholesterol = $cholesterol;
        $this->acidesGrasSatures = $acidesGrasSatures;
        $this->acidesGrasMonoinsatures = $acidesGrasMonoinsatures;
        $this->acidesGrasPolyinsatures = $acidesGrasPolyinsatures;
        $this->eau = $eau;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKilocalories(): float
    {
        return $this->kilocalories;
    }

    public function setKilocalories(float $kilocalories): self
    {
        $this->kilocalories = $kilocalories;

        return $this;
    }

    public function getProteine(): float
    {
        return $this->proteine;
    }

    public function setProteine(float $proteine): self
    {
        $this->proteine = $proteine;

        return $this;
    }

    public function getGlucides(): float
    {
        return $this->glucides;
    }

    public function setGlucides(float $glucides): self
    {
        $this->glucides = $glucides;

        return $this;
    }

    public function getLipides(): float
    {
        return $this->lipides;
    }

    public function setLipides(float $lipides): self
    {
        $this->lipides = $lipides;

        return $this;
    }

    public function getSucres(): float
    {
        return $this->sucres;
    }

    public function setSucres(float $sucres): self
    {
        $this->sucres = $sucres;

        return $this;
    }

    public function getAmidon(): float
    {
        return $this->amidon;
    }

    public function setAmidon(float $amidon): self
    {
        $this->amidon = $amidon;

        return $this;
    }

    public function getFibresAlimentaires(): float
    {
        return $this->fibresAlimentaires;
    }

    public function setFibresAlimentaires(float $fibresAlimentaires): self
    {
        $this->fibresAlimentaires = $fibresAlimentaires;

        return $this;
    }

    public function getCholesterol(): float
    {
        return $this->cholesterol;
    }

    public function setCholesterol(float $cholesterol): self
    {
        $this->cholesterol = $cholesterol;

        return $this;
    }

    public function getAcidesGrasSatures(): float
    {
        return $this->acidesGrasSatures;
    }

    public function setAcidesGrasSatures(float $acidesGrasSatures): self
    {
        $this->acidesGrasSatures = $acidesGrasSatures;

        return $this;
    }

    public function getAcidesGrasMonoinsatures(): float
    {
        return $this->acidesGrasMonoinsatures;
    }

    public function setAcidesGrasMonoinsatures(float $acidesGrasMonoinsatures): self
    {
        $this->acidesGrasMonoinsatures = $acidesGrasMonoinsatures;

        return $this;
    }

    public function getAcidesGrasPolyinsatures(): float
    {
        return $this->acidesGrasPolyinsatures;
    }

    public function setAcidesGrasPolyinsatures(float $acidesGrasPolyinsatures): self
    {
        $this->acidesGrasPolyinsatures = $acidesGrasPolyinsatures;

        return $this;
    }

    public function getEau(): float
    {
        return $this->eau;
    }

    public function setEau(float $eau): self
    {
        $this->eau = $eau;

        return $this;
    }
}
