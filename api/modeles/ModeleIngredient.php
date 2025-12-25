<?php

include_once("Modele.php");
include_once("./classes/Ingredient.php");
include_once("./classes/Quantite.php");


class ModeleIngredient extends Modele {

    static public function getIngredientsByReserve(string $login,int $numero) : array {
        try {
            $lesIngredients = array();
            $pdo = parent::connexionPDO();
            $sql = "SELECT * FROM Ingredient I 
            INNER JOIN Conserver C ON I.id = C.idIngredient 
            WHERE C.numero = :numero AND C.login = :login";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":numero",$numero,PDO::PARAM_INT);
            $rqt->bindParam(":login",$login,PDO::PARAM_STR);
            $rqt->execute();
            while($ligne=$rqt->fetch(PDO::FETCH_ASSOC)) {
                $id = $ligne['id'];
                $nom = $ligne['nom'];
                $qte = $ligne['quantite'];
                $unite = $ligne['unite'];
                $lesIngredients[$id] = new Ingredient($nom,new Quantite($qte,$unite));
            }
            $rqt->closeCursor();
            $pdo = null;
            return $lesIngredients;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function getAllIngredients() : array {
        try {
            $lesIngredients = array();
            $pdo = parent::connexionPDO();
            $sql = "SELECT * FROM Ingredient";
            $rqt = $pdo->prepare($sql);
            $rqt->execute();
            while($ligne=$rqt->fetch(PDO::FETCH_ASSOC)) {
                $id = $ligne['id'];
                $nom = $ligne['nom'];
                $unite = $ligne['unite'];
                $lesIngredients[$id] = new Ingredient($nom,new Quantite(0,$unite));
            }
            $rqt->closeCursor();
            $pdo = null;
            return $lesIngredients;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function insertIngredient(string $nom,string $unite) : void {
        try {
            $pdo = parent::connexionPDO();
            $sql = "INSERT INTO Ingredient (nom, unite) VALUES(:nom, :unite)";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":nom",$nom,PDO::PARAM_STR);
            $rqt->bindParam(":unite",$unite,PDO::PARAM_STR);
            $rqt->execute();
            $rqt->closeCursor();
            $pdo = null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function updateIngredient(string $nom, string $unite,int $id) : void {
        try {
            $pdo = parent::connexionPDO();
            $sql = "UPDATE Ingredient
                    SET  nom = :nom, unite = :unite
                    WHERE id = :id";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":id",$id,PDO::PARAM_INT);
            $rqt->bindParam(":nom",$nom,PDO::PARAM_STR);
            $rqt->bindParam(":unite",$unite,PDO::PARAM_STR);
            $rqt->execute();
            $rqt->closeCursor();
            $pdo = null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    static public function deleteIngredientById(string $id) : void {
        try {
            $pdo = parent::connexionPDO();
            $sql = "DELETE FROM Ingredient WHERE id = :id";
            $rqt = $pdo->prepare($sql);
            $rqt->bindParam(":id",$id,PDO::PARAM_INT);
            $rqt->execute();
            $rqt->closeCursor();
            $pdo = null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}

?>