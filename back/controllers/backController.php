<?php

include_once("../modeles/ModeleReserve.php");

class BackController {

    public function __construct(string $action) {
        switch($action) {
            case "": 
                self->verifLoginMotDePasse();
                break;

            case "/utilisateur/getAllReserves":
                self->getAllReservesByLogin();
                break;

            default:

        }
    }

    public function verifLoginMotDePasse() : void {
        $login = trim($_GET['login']);
        $mdp = trim($_GET['mdp']);
        if(password_verify($mdp,ModeleUtilisateur::getMotDePasseHache($login))) {
            //AJOUTER UN TOKEN
        }
        
    }

    public function getAllReservesByLogin() : void {
        //PRINTS JSON
    }
}

?>