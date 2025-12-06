<?php

include_once("ModeleReserve.php");

include_once("ModeleUtilisateur.php");

$ing = ModeleRerseve::getReservesByIdUtilisateur("alice");

print_r($ing);

echo ModeleUtilisateur::getMotDePasseHache("alice");

/*
$var = ModeleUtilisateur::insertUtilisateur("test","motdepasse");
if($var) {
    echo "inséré";
} else {
    echo "non inséré";
}*/
?>