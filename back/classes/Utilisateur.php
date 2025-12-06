<?php

class Utilisateur {
    private string $login;
    private string $mdp;

    public function __construct(string $login, string $mdp) {
        $this->login = $login;
        $this->mdp = $mdp;
    }

    public function getLogin() : string {
        return $this->$login;
    }
    
    public function getMdp() : string {
        return $this->$mdp;
    }


    public function setLogin(string $login) : void {
        $this->$login = $login;
    }
    
    public function setMdp(string $mdp) : void {
        $this->$mdp = $mdp;
    }
    
    
}

?>