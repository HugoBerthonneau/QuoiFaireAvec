<?php

class Ingredient implements JsonSerializable {
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

    public function jsonSerialize(): mixed {
        return [
            'nom' => $this->nom,
            'quatite' => $this->quantite
        ];
    }
}

?>