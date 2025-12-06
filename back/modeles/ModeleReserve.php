<?php

include_once("ModeleIngredient.php");
include_once("../classes/Reserve.php");



class ModeleRerseve extends Modele {
    
    static public function getReservesByIdUtilisateur(string $login) : array {
        try {
            $lesReserves = array();
            $pdo = parent::connexionPDO();
            $sql = "SELECT * FROM Reserve WHERE login = :login";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":login",$login,PDO::PARAM_STR);
            $rqt->execute();
            while($ligne=$rqt->fetch(PDO::FETCH_ASSOC)) 
            {
                $numero = $ligne['numero'];
                $nom = $ligne['nom'];
                $ingredients = ModeleIngredient::getIngredientsByReserve($login,$numero);
                $lesReserves[$numero] = new Reserve($numero,$nom,$ingredients);
            }
            $rqt->closeCursor();
            $cnx=null;
            return $lesReserves;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function insertReserve(string $login,string $nom) : void {
        try {
            $pdo = parent::connexionPDO();
            $sql = "INSERT INTO Reserve VALUES:nom,:login)";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":nom",$nom,PDO::PARAM_STR);
            $rqt->bindParam(":login",$login,PDO::PARAM_STR);
            $rqt->execute();
            $rqt->closeCursor();
            $cnx=null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function isIngredientInReserve(string $login, int $numero, int $id) : bool {
        try{
            $pdo = parent::connexionPDO();
            $sql = "SELECT * FROM Conserver 
                    WHERE numero = :numero 
                    AND login = :login
                    AND idIngredient = :id";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":numero",$numero,PDO::PARAM_INT);
            $rqt->bindParam(":login",$login,PDO::PARAM_STR);
            $rqt->bindParam(":id",$id,PDO::PARAM_INT);
            $rqt->execute();
            $nb = $rqt->rowCount();
            $rqt->closeCursor();
            $cnx=null;
            if($nb > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function addIngredientToReserve(string $idIngredient,string $login, int $numero) : void {
        // TODO
    }

}


?>