<?php

class Validation
{
    static function validationLogin(string $login) : bool {
        if(preg_match('/^[a-zA-Z0-9_]{5,20}$/', $login)) {
            return true;
        }
        return false;
    }

    static function validationMdp(string $mdp) : bool {
        if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+={}\[\]:;"\'<>,.?\/~`]).{12,}$/', $mdp)){
            return true;
        }
        return false;
    }
}

?>