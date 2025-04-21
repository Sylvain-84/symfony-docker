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

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $sucres = 0.0;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $amidon = 0.0;

    #[ORM\Column(name: 'fibres_alimentaires', type: 'float', options: ['default' => 0])]
    private float $fibresAlimentaires = 0.0;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $cholesterol = 0.0;

    #[ORM\Column(name: 'acides_gras_satures', type: 'float', options: ['default' => 0])]
    private float $acidesGrasSatures = 0.0;

    #[ORM\Column(name: 'acides_gras_monoinsatures', type: 'float', options: ['default' => 0])]
    private float $acidesGrasMonoinsatures = 0.0;

    #[ORM\Column(name: 'acides_gras_polyinsatures', type: 'float', options: ['default' => 0])]
    private float $acidesGrasPolyinsatures = 0.0;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $eau = 0.0;

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
