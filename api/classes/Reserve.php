<?php

class Reserve implements JsonSerializable {
    private int $numero;
    private string $nom;
    private array $lesIngredients;

    public function __construct(int $numero, string $nom, array $ingredients) {
        $this->numero = $numero;
        $this->nom = $nom;
        $this->lesIngredients = $ingredients;
    }

    public function getNumero() : int {
        return $this->numero;
    }
    
    public function getNom() : string {
        return $this->nom;
    }
    
    public function getLesIngredients() : array {
        return $this->lesIngredients;
    }

    public function jsonSerialize(): mixed {
        return [
            'numero' => $this->numero,
            'nom' => $this->nom,
            'lesIngredients' => $this->lesIngredients
        ];
    }

}


?>