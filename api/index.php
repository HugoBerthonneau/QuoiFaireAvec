<?php

session_start();

include_once('controllers/VisiteurController.php');
include_once('controllers/UtilisateurController.php');

if(isset($_REQUEST['token']) && isset($_REQUEST['login']) && isset($_REQUEST['mdp'])) {
    $controller = new UtilisateurController();
} else {
    $controller = new VisiteurController();
}

?>