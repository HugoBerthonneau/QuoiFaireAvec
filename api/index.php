<?php


include_once('controllers/VisiteurController.php');
include_once('controllers/UtilisateurController.php');

$method = $_SERVER['REQUEST_METHOD'];
if($method == 'GET') {
    if(isset($_REQUEST['token']) && isset($_REQUEST['login']) && isset($_REQUEST['mdp'])) {
    $controller = new UtilisateurController();
    } else {
        $controller = new VisiteurController();
    }
}
if($method == 'POST' || $method == 'PUT') {
    $param = json_decode(file_get_contents('php://input'), true);
    if(isset($param['token']) && isset($param['login']) && isset($param['mdp'])) {
        $controller = new UtilisateurController();
    } else {
        $controller = new VisiteurController();
    }
}
if($method == 'DELETE')
{
    //TODO
}


?>