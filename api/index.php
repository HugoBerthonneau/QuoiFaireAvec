<?php

session_start();

include_once('controllers/VisiteurController.php');

if(!isset($_SESSION['token'])) {
    $controller = new VisiteurController();
} else
{
    echo json_encode('félicitations vous êtes connecté ! ');
}

?>



