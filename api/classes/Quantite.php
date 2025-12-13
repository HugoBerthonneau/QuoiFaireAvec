<?php

class Quantite implements JsonSerializable {
    private float $valeur;
    private string $unite;

    public function __construct(float $valeur,string $unite)
    {
        $this->valeur = $valeur;
        $this->unite = $unite;
    }

    public function getValeur() : float {
        return $this->valeur;
    }
    public function getUnite() : string {
        return $this->unite;
    }

    public function addToValeur(float $qte) : void {
        $this->valeur += $qte;
    }
    
    public function SubstractFromValeur(float $qte) : void {
        $this->valeur -= $qte;
    }

    public function jsonSerialize(): mixed {
        return [
            'valeur' => $this->valeur,
            'unite' => $this->unite
        ];
    }
}

?>