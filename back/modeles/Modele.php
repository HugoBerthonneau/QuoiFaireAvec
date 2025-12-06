<?php

abstract class Modele {
    
    static public function connexionPDO() : PDO {

        
        $dsn="mysql:host=localhost;dbname=dbQFA;charset=UTF8";
        $user='accesUtilisateur';
        $pass='';
        try
        {
            $cnx = new PDO($dsn,$user,$pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $cnx;
        }
        catch(PDOException $except)
        {
            die('Echec de la connexion.'.$except->getMessage());
        }
    }
}

?>