<?php

class Reserve {
    private string $code;
    private array $lesIngredients;

    public function __construct(string $code) {
        $this->code = $code;
        $this->lesIngredients = array();
    }

    public function getCode() : string {
        return $this->code;
    }

    public function getLesIngredients() : array {
        return $this->lesIngredients;
    }
}


?>