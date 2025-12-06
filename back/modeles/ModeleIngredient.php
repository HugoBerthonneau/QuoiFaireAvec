<?php

include_once("Modele.php");
include_once("../classes/Ingredient.php");
include_once("../classes/Quantite.php");


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

    static public function insertIngredient(string $nom,string $unite) : void {
        try {
            $pdo = parent::connexionPDO();
            $sql = "INSERT INTO Ingredient VALUES(:nom, :unite)";
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
}

?>