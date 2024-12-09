<?php

namespace Validation;

use Board\Position;
use Player\Stone;
use Player\Move;

class RuleValidator
{
    public function isGeldigeZet($zet, $bord, $spelerAanDeBeurt)
    {
        if (!$this->isGeldigeSpeler($spelerAanDeBeurt)) {
            echo "speler is niet aan de beurt";
            return false;
        }
        if (!$this->bevatSteen(new Position($zet->vanPosition->x, $zet->vanPosition->y), $bord)) {
            echo "Bevat geen steen \n";
            return false;
        }
        if (!$this->zetIsBinnenBord($zet)) {
            echo "Zet is niet binnen het bord \n";
            return false;
        }
        $PositionsBeschikbareStenen = $this->vakkenVanBeschikbareStenen($bord, $spelerAanDeBeurt);
        $mogelijkeSlagen = $this->mogelijkeSlagen($PositionsBeschikbareStenen, $bord, $spelerAanDeBeurt);
        if (count($mogelijkeSlagen) > 0) {
            if (in_array($zet, $mogelijkeSlagen)) {
                return true;
            } else {
                echo 'Er is een slag mogelijk, maar deze zet voert geen slag uit.';
                return false;
            }
        } else {
            $mogelijkeZetten = $this->mogelijkeZetten($PositionsBeschikbareStenen, $bord, $spelerAanDeBeurt);
            if (in_array($zet, $mogelijkeZetten)) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function vakkenVanBeschikbareStenen($bord, $spelerAanDeBeurt)
    {
        $spelerKleur = $this->kleurVanSpeler($spelerAanDeBeurt);
        $beschikbareVakken = [];
        foreach ($bord->vakjes as $rijNummer => $rij) {
            foreach ($rij as $kolomNummer => $vak) {
                if (isset($vak->steen)) {
                    if ($vak->steen->kleur === $spelerKleur) {
                        $beschikbareVakken[] = new Position($kolomNummer, $rijNummer);
                    }
                }
            }
        }
        return $beschikbareVakken;
    }

    private function mogelijkeZetten($beschikbareVakken, $bord, $speler)
    {
        $mogelijkeZetten = [];
        if ($speler === 0) {
            $beweegRichting = -1;
        } else {
            $beweegRichting = 1;
        }
        foreach ($beschikbareVakken as $steenPosition) {
            $naar = new Position(($steenPosition->x + 1), ($steenPosition->y + $beweegRichting));
            if ($this->PositionIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                $mogelijkeZetten[] = new Move($steenPosition, $naar);
            }
            $naar = new Position(($steenPosition->x - 1), ($steenPosition->y + $beweegRichting));
            if ($this->PositionIsBinnenBord($naar) && !$this->bevatSteen($naar, $bord)) {
                $mogelijkeZetten[] = new Move($steenPosition, $naar);
            }
        }
        return $mogelijkeZetten;
    }

    private function mogelijkeSlagen($beschikbareVakken, $bord, $speler)
    {
        $mogelijkeSlagen = [];
        if ($speler === 0) {
            $beweegRichting = -1;
        } else {
            $beweegRichting = 1;
        }
        foreach ($beschikbareVakken as $steenPosition) {
            $naar = new Position(($steenPosition->x + 2), ($steenPosition->y + ($beweegRichting * 2)));
            $over = new Position(($steenPosition->x + 1), ($steenPosition->y + $beweegRichting));
            if (
                $this->PositionIsBinnenBord($naar)
                && !$this->bevatSteen($naar, $bord)
                && $this->bevatSteenVanTegenstander($over, $bord, $speler)
            ) {
                $mogelijkeSlagen[] = new Move($steenPosition, $naar);
            }
            $naar = new Position(($steenPosition->x - 2), ($steenPosition->y + ($beweegRichting * 2)));
            $over = new Position(($steenPosition->x - 1), ($steenPosition->y + $beweegRichting));
            if (
                $this->PositionIsBinnenBord($naar)
                && !$this->bevatSteen($naar, $bord)
                && $this->bevatSteenVanTegenstander($over, $bord, $speler)
            ) {
                $mogelijkeSlagen[] = new Move($steenPosition, $naar);
            }
        }
        return $mogelijkeSlagen;
    }
}