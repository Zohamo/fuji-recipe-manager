<?php

namespace App\Entities;

use Core\AbstractEntity;

class Recipe extends AbstractEntity
{
    /** @var string */
    private $FilmSimulation;
    /** @var string */
    private $MonochromaticColor_RG;
    /** @var string */
    private $GrainEffectSize;
    /** @var string */
    private $WhiteBalance;

    /**
     * Hydrates the entity properties from an XML file.
     *
     * @param  string $xml
     * @return $this
     */
    public function hydrateFromXml($xml)
    {
        $xmlEl = new \SimpleXMLElement($xml);
        $this->Label = $xmlEl->PropertyGroup[0]->attributes()->label;
        foreach ($xmlEl->PropertyGroup[0] as $key => $value) {
            $this->$key = (string) $value;
        }
        return $this;
    }

    public function isMonochromatic()
    {
        return in_array($this->FilmSimulation, ['Acros']);
    }

    /**********************************************
     * GETTERS
     **********************************************/

    public function FilmSimulation()
    {
        switch ($this->FilmSimulation) {
            case 'BG':
                return "Monochrome +G Filter";
            case 'BW':
                return "Monochrome";
            case 'BleachBypass':
                return "Eterna Bleach Bypass";
            case 'Eterna':
                return "Eterna/Cinema";
            case 'Classic':
                return "Classic Chrome";
            case 'ClassicNEGA':
                return "Classic Negative";
            case 'NEGAhi':
                return "Pro Neg Hi";
            case 'NEGAStd':
                return "Pro Neg Std";
            case 'Provia':
                return "Provia/Standard";
            default:
                return $this->FilmSimulation;
        }
    }
    public function MonochromaticColor_RG()
    {
        return $this->isMonochromatic() ? $this->MonochromaticColor_RG : "";
    }
    public function GrainEffectSize()
    {
        return $this->GrainEffect !== "OFF" ? $this->GrainEffectSize : "-";
    }
    public function WhiteBalance()
    {
        return $this->WhiteBalance === "Temperature" ? $this->WBColorTemp : $this->WhiteBalance;
    }
}
