<?php

include_once("Modele.php");

class ModeleUtilisateur extends Modele {
    
    static public function getMotDePasseHache(string $login) : string {
        if(in_array($login,self::getAllLogins()))
        {
            try {
                $pdo = parent::connexionPDO();
                $sql = "SELECT * FROM Utilisateur WHERE login = :login";
                $rqt = $pdo->prepare($sql);
                $rqt->bindParam(":login",$login,PDO::PARAM_STR);
                $rqt->execute();
                $ligne = $rqt->fetch(PDO::FETCH_ASSOC);
                $mdp = $ligne['mdp'];
                $rqt->closeCursor();
                $pdo = null;
                return $mdp;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return "";
    }

    static public function getAllLogins() : array {
        try {
                $pdo = parent::connexionPDO();
                $sql = "SELECT login FROM Utilisateur";
                $rqt = $pdo->prepare($sql);
                $rqt->execute();
                $logins = array();
                while($ligne=$rqt->fetch(PDO::FETCH_ASSOC)) {
                    array_push($logins,$ligne['login']);
                }
                $rqt->closeCursor();
                $pdo = null;
                return $logins;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function insertUtilisateur(string $login, string $mdpHache) : bool {
        if(!in_array($login,self::getAllLogins()))
        {
            try {
                $pdo = parent::connexionPDO();
                $sql = "INSERT INTO Utilisateur VALUES(:login,:mdp)";
                $rqt = $pdo->prepare($sql);
                $rqt->bindParam(":login",$login,PDO::PARAM_STR);
                $rqt->bindParam(":mdp",$mdpHache,PDO::PARAM_STR);
                $rqt->execute();
                $rqt->closeCursor();
                $pdo = null;
                return true;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return false;

    }
}

?>