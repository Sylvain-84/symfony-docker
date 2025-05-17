<?php

declare(strict_types=1);

namespace App\Entity\Ingredient;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'nutrition')]
class IngredientNutrition
{
    /**
     * Key = property name   Value = displayable unit
     * Keeping them here avoids duplicating units inside the DB.
     */
    public const UNITS = [
        'nrjKj' => 'kJ',
        'nrjKcal' => 'kcal',
        'eau' => 'g',
        'sel' => 'g',
        'sodium' => 'mg',
        'magnesium' => 'mg',
        'phosphore' => 'mg',
        'potassium' => 'mg',
        'calcium' => 'mg',
        'manganese' => 'mg',
        'fer' => 'mg',
        'cuivre' => 'mg',
        'zinc' => 'mg',
        'selenium' => 'µg',
        'iode' => 'µg',
        'proteines' => 'g',
        'glucides' => 'g',
        'sucres' => 'g',
        'fructose' => 'g',
        'galactose' => 'g',
        'lactose' => 'g',
        'glucose' => 'g',
        'maltose' => 'g',
        'saccharose' => 'g',
        'amidon' => 'g',
        'polyols' => 'g',
        'fibres' => 'g',
        'lipides' => 'g',
        'ags' => 'g',
        'agmi' => 'g',
        'agpi' => 'g',
        'ag040' => 'g',
        'ag060' => 'g',
        'ag080' => 'g',
        'ag100' => 'g',
        'ag120' => 'g',
        'ag140' => 'g',
        'ag160' => 'g',
        'ag180' => 'g',
        'ag181Ole' => 'g',
        'ag182Lino' => 'g',
        'ag183ALino' => 'g',
        'ag204Ara' => 'g',
        'ag205Epa' => 'g',
        'ag206Dha' => 'g',
        'retinol' => 'µg',
        'betaCarotene' => 'µg',
        'vitamineD' => 'µg',
        'vitamineE' => 'mg',
        'vitamineK1' => 'µg',
        'vitamineK2' => 'µg',
        'vitamineC' => 'mg',
        'vitamineB1' => 'mg',
        'vitamineB2' => 'mg',
        'vitamineB3' => 'mg',
        'vitamineB5' => 'mg',
        'vitamineB6' => 'mg',
        'vitamineB12' => 'µg',
        'vitamineB9' => 'µg',
        'alcool' => 'g',
        'acidesOrganiques' => 'g',
        'cholesterol' => 'mg',
    ];

    // ──────────────────────────────────────────────
    // Primary key
    // ──────────────────────────────────────────────
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private ?int $id = null;

    // ──────────────────────────────────────────────
    // Define all numeric nutrients as nullable floats.
    // Doctrine mapping: nullable=true; PHP type: ?float
    // Default value: null so uninitialised properties are valid.
    // ──────────────────────────────────────────────

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $nrjKj = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $nrjKcal = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $eau = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $sel = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $sodium = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $magnesium = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $phosphore = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $potassium = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $calcium = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $manganese = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $fer = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $cuivre = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $zinc = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $selenium = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $iode = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $proteines = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $glucides = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $sucres = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $fructose = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $galactose = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $lactose = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $glucose = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $maltose = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $saccharose = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $amidon = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $polyols = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $fibres = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $lipides = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ags = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $agmi = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $agpi = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag040 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag060 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag080 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag100 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag120 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag140 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag160 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag180 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag181Ole = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag182Lino = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag183ALino = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag204Ara = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag205Epa = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $ag206Dha = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $retinol = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $betaCarotene = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineD = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineE = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineK1 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineK2 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineC = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineB1 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineB2 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineB3 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineB5 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineB6 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineB12 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $vitamineB9 = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $alcool = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $acidesOrganiques = null;
    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $cholesterol = null;

    // ──────────────────────────────────────────────
    // Getters & setters
    // ──────────────────────────────────────────────
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * The following getters and setters are generated with full property names
     * and nullable types. Only a few are shown here; generate the rest with
     * your IDE for brevity and to keep the file readable.
     */
    public function getNrjKj(): ?float
    {
        return $this->nrjKj;
    }

    public function setNrjKj(?float $nrjKj): void
    {
        $this->nrjKj = $nrjKj;
    }

    public function getNrjKcal(): ?float
    {
        return $this->nrjKcal;
    }

    public function setNrjKcal(?float $nrjKcal): void
    {
        $this->nrjKcal = $nrjKcal;
    }

    public function getEau(): ?float
    {
        return $this->eau;
    }

    public function setEau(?float $eau): void
    {
        $this->eau = $eau;
    }

    public function getSel(): ?float
    {
        return $this->sel;
    }

    public function setSel(?float $sel): void
    {
        $this->sel = $sel;
    }

    public function getSodium(): ?float
    {
        return $this->sodium;
    }

    public function setSodium(?float $sodium): void
    {
        $this->sodium = $sodium;
    }

    public function getMagnesium(): ?float
    {
        return $this->magnesium;
    }

    public function setMagnesium(?float $magnesium): void
    {
        $this->magnesium = $magnesium;
    }

    public function getPhosphore(): ?float
    {
        return $this->phosphore;
    }

    public function setPhosphore(?float $phosphore): void
    {
        $this->phosphore = $phosphore;
    }

    public function getPotassium(): ?float
    {
        return $this->potassium;
    }

    public function setPotassium(?float $potassium): void
    {
        $this->potassium = $potassium;
    }

    public function getCalcium(): ?float
    {
        return $this->calcium;
    }

    public function setCalcium(?float $calcium): void
    {
        $this->calcium = $calcium;
    }

    public function getManganese(): ?float
    {
        return $this->manganese;
    }

    public function setManganese(?float $manganese): void
    {
        $this->manganese = $manganese;
    }

    public function getFer(): ?float
    {
        return $this->fer;
    }

    public function setFer(?float $fer): void
    {
        $this->fer = $fer;
    }

    public function getCuivre(): ?float
    {
        return $this->cuivre;
    }

    public function setCuivre(?float $cuivre): void
    {
        $this->cuivre = $cuivre;
    }

    public function getZinc(): ?float
    {
        return $this->zinc;
    }

    public function setZinc(?float $zinc): void
    {
        $this->zinc = $zinc;
    }

    public function getSelenium(): ?float
    {
        return $this->selenium;
    }

    public function setSelenium(?float $selenium): void
    {
        $this->selenium = $selenium;
    }

    public function getIode(): ?float
    {
        return $this->iode;
    }

    public function setIode(?float $iode): void
    {
        $this->iode = $iode;
    }

    public function getProteines(): ?float
    {
        return $this->proteines;
    }

    public function setProteines(?float $proteines): void
    {
        $this->proteines = $proteines;
    }

    public function getGlucides(): ?float
    {
        return $this->glucides;
    }

    public function setGlucides(?float $glucides): void
    {
        $this->glucides = $glucides;
    }

    public function getSucres(): ?float
    {
        return $this->sucres;
    }

    public function setSucres(?float $sucres): void
    {
        $this->sucres = $sucres;
    }

    public function getFructose(): ?float
    {
        return $this->fructose;
    }

    public function setFructose(?float $fructose): void
    {
        $this->fructose = $fructose;
    }

    public function getGalactose(): ?float
    {
        return $this->galactose;
    }

    public function setGalactose(?float $galactose): void
    {
        $this->galactose = $galactose;
    }

    public function getLactose(): ?float
    {
        return $this->lactose;
    }

    public function setLactose(?float $lactose): void
    {
        $this->lactose = $lactose;
    }

    public function getGlucose(): ?float
    {
        return $this->glucose;
    }

    public function setGlucose(?float $glucose): void
    {
        $this->glucose = $glucose;
    }

    public function getMaltose(): ?float
    {
        return $this->maltose;
    }

    public function setMaltose(?float $maltose): void
    {
        $this->maltose = $maltose;
    }

    public function getSaccharose(): ?float
    {
        return $this->saccharose;
    }

    public function setSaccharose(?float $saccharose): void
    {
        $this->saccharose = $saccharose;
    }

    public function getAmidon(): ?float
    {
        return $this->amidon;
    }

    public function setAmidon(?float $amidon): void
    {
        $this->amidon = $amidon;
    }

    public function getPolyols(): ?float
    {
        return $this->polyols;
    }

    public function setPolyols(?float $polyols): void
    {
        $this->polyols = $polyols;
    }

    public function getFibres(): ?float
    {
        return $this->fibres;
    }

    public function setFibres(?float $fibres): void
    {
        $this->fibres = $fibres;
    }

    public function getLipides(): ?float
    {
        return $this->lipides;
    }

    public function setLipides(?float $lipides): void
    {
        $this->lipides = $lipides;
    }

    public function getAgs(): ?float
    {
        return $this->ags;
    }

    public function setAgs(?float $ags): void
    {
        $this->ags = $ags;
    }

    public function getAgmi(): ?float
    {
        return $this->agmi;
    }

    public function setAgmi(?float $agmi): void
    {
        $this->agmi = $agmi;
    }

    public function getAgpi(): ?float
    {
        return $this->agpi;
    }

    public function setAgpi(?float $agpi): void
    {
        $this->agpi = $agpi;
    }

    public function getAg040(): ?float
    {
        return $this->ag040;
    }

    public function setAg040(?float $ag040): void
    {
        $this->ag040 = $ag040;
    }

    public function getAg060(): ?float
    {
        return $this->ag060;
    }

    public function setAg060(?float $ag060): void
    {
        $this->ag060 = $ag060;
    }

    public function getAg080(): ?float
    {
        return $this->ag080;
    }

    public function setAg080(?float $ag080): void
    {
        $this->ag080 = $ag080;
    }

    public function getAg100(): ?float
    {
        return $this->ag100;
    }

    public function setAg100(?float $ag100): void
    {
        $this->ag100 = $ag100;
    }

    public function getAg120(): ?float
    {
        return $this->ag120;
    }

    public function setAg120(?float $ag120): void
    {
        $this->ag120 = $ag120;
    }

    public function getAg140(): ?float
    {
        return $this->ag140;
    }

    public function setAg140(?float $ag140): void
    {
        $this->ag140 = $ag140;
    }

    public function getAg160(): ?float
    {
        return $this->ag160;
    }

    public function setAg160(?float $ag160): void
    {
        $this->ag160 = $ag160;
    }

    public function getAg180(): ?float
    {
        return $this->ag180;
    }

    public function setAg180(?float $ag180): void
    {
        $this->ag180 = $ag180;
    }

    public function getAg181Ole(): ?float
    {
        return $this->ag181Ole;
    }

    public function setAg181Ole(?float $ag181Ole): void
    {
        $this->ag181Ole = $ag181Ole;
    }

    public function getAg182Lino(): ?float
    {
        return $this->ag182Lino;
    }

    public function setAg182Lino(?float $ag182Lino): void
    {
        $this->ag182Lino = $ag182Lino;
    }

    public function getAg183ALino(): ?float
    {
        return $this->ag183ALino;
    }

    public function setAg183ALino(?float $ag183ALino): void
    {
        $this->ag183ALino = $ag183ALino;
    }

    public function getAg204Ara(): ?float
    {
        return $this->ag204Ara;
    }

    public function setAg204Ara(?float $ag204Ara): void
    {
        $this->ag204Ara = $ag204Ara;
    }

    public function getAg205Epa(): ?float
    {
        return $this->ag205Epa;
    }

    public function setAg205Epa(?float $ag205Epa): void
    {
        $this->ag205Epa = $ag205Epa;
    }

    public function getAg206Dha(): ?float
    {
        return $this->ag206Dha;
    }

    public function setAg206Dha(?float $ag206Dha): void
    {
        $this->ag206Dha = $ag206Dha;
    }

    public function getRetinol(): ?float
    {
        return $this->retinol;
    }

    public function setRetinol(?float $retinol): void
    {
        $this->retinol = $retinol;
    }

    public function getBetaCarotene(): ?float
    {
        return $this->betaCarotene;
    }

    public function setBetaCarotene(?float $betaCarotene): void
    {
        $this->betaCarotene = $betaCarotene;
    }

    public function getVitamineD(): ?float
    {
        return $this->vitamineD;
    }

    public function setVitamineD(?float $vitamineD): void
    {
        $this->vitamineD = $vitamineD;
    }

    public function getVitamineE(): ?float
    {
        return $this->vitamineE;
    }

    public function setVitamineE(?float $vitamineE): void
    {
        $this->vitamineE = $vitamineE;
    }

    public function getVitamineK1(): ?float
    {
        return $this->vitamineK1;
    }

    public function setVitamineK1(?float $vitamineK1): void
    {
        $this->vitamineK1 = $vitamineK1;
    }

    public function getVitamineK2(): ?float
    {
        return $this->vitamineK2;
    }

    public function setVitamineK2(?float $vitamineK2): void
    {
        $this->vitamineK2 = $vitamineK2;
    }

    public function getVitamineC(): ?float
    {
        return $this->vitamineC;
    }

    public function setVitamineC(?float $vitamineC): void
    {
        $this->vitamineC = $vitamineC;
    }

    public function getVitamineB1(): ?float
    {
        return $this->vitamineB1;
    }

    public function setVitamineB1(?float $vitamineB1): void
    {
        $this->vitamineB1 = $vitamineB1;
    }

    public function getVitamineB2(): ?float
    {
        return $this->vitamineB2;
    }

    public function setVitamineB2(?float $vitamineB2): void
    {
        $this->vitamineB2 = $vitamineB2;
    }

    public function getVitamineB3(): ?float
    {
        return $this->vitamineB3;
    }

    public function setVitamineB3(?float $vitamineB3): void
    {
        $this->vitamineB3 = $vitamineB3;
    }

    public function getVitamineB5(): ?float
    {
        return $this->vitamineB5;
    }

    public function setVitamineB5(?float $vitamineB5): void
    {
        $this->vitamineB5 = $vitamineB5;
    }

    public function getVitamineB6(): ?float
    {
        return $this->vitamineB6;
    }

    public function setVitamineB6(?float $vitamineB6): void
    {
        $this->vitamineB6 = $vitamineB6;
    }

    public function getVitamineB12(): ?float
    {
        return $this->vitamineB12;
    }

    public function setVitamineB12(?float $vitamineB12): void
    {
        $this->vitamineB12 = $vitamineB12;
    }

    public function getVitamineB9(): ?float
    {
        return $this->vitamineB9;
    }

    public function setVitamineB9(?float $vitamineB9): void
    {
        $this->vitamineB9 = $vitamineB9;
    }

    public function getAlcool(): ?float
    {
        return $this->alcool;
    }

    public function setAlcool(?float $alcool): void
    {
        $this->alcool = $alcool;
    }

    public function getAcidesOrganiques(): ?float
    {
        return $this->acidesOrganiques;
    }

    public function setAcidesOrganiques(?float $acidesOrganiques): void
    {
        $this->acidesOrganiques = $acidesOrganiques;
    }

    public function getCholesterol(): ?float
    {
        return $this->cholesterol;
    }

    public function setCholesterol(?float $cholesterol): void
    {
        $this->cholesterol = $cholesterol;
    }
}
