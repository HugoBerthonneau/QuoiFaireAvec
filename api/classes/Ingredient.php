<?php

class Ingredient {
    private string $nom;
    private Quantite $quantite;

    public function __construct(string $nom,Quantite $quantite) {
        $this->nom = $nom;
        $this->quantite = $quantite;
    }

    public function getNom() : string {
        return $this->nom;
    }

    public function getQuantite() : Quantite {
        return $this->quantite;
    }    
}

?>