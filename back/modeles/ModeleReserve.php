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
            $pdo = null;
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
            $pdo = null;
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
            $pdo = null;
            if($nb > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function addIngredientToReserve(string $idIngredient,string $login, int $numero, float $valeur) : void {
        if(!self::isIngredientInReserve($login, $numero, $idIngredient)) {
            try{
                $pdo = parent::connexionPDO();
                $sql = "INSERT INTO Conserver VALUES(:numero, :login, :id, CONVERT(:valeur,NUMERIC(7,2)))";
                $rqt = $pdo->prepare($sql);
                $rqt->bindParam(":numero",$numero,PDO::PARAM_INT);
                $rqt->bindParam(":login",$login,PDO::PARAM_STR);
                $rqt->bindParam(":id",$id,PDO::PARAM_INT);
                $rqt->bindParam(":valeur",strval($valeur),PDO::PARAM_STR);
                $rqt->execute();
                $rqt->closeCursor();
                $pdo = null;
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
    }

    static public function updateQuantiteIngredient() : void {
        try {
            $pdo = parent::connexionPDO();
            $sql = "UPDATE Conserver 
                    SET valeur = :valeur 
                    WHERE login = :login
                    AND numero = :numero
                    AND idIngredient = :id";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":numero",$numero,PDO::PARAM_INT);
            $rqt->bindParam(":login",$login,PDO::PARAM_STR);
            $rqt->bindParam(":id",$id,PDO::PARAM_INT);
            $rqt->bindParam(":valeur",strval($valeur),PDO::PARAM_STR);
            $rqt->closeCursor();
            $pdo = null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

}


?>