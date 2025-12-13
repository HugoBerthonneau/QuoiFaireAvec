<?php

include_once('controllers/VisiteurController.php');
include_once('controllers/UtilisateurController.php');

$uri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),14);
$method = $_SERVER['REQUEST_METHOD'];
$headers = getallheaders();

if (isset($headers['Authorization'])) {
    $authorizationHeader = $headers['Authorization'];
    if(preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches) && $matches[1] )
    {
        $token = $matches[1];
    }
}

if($method == 'GET') {
    if(isset($_GET['login']) && $token == ModeleUtilisateur::getToken($_GET['login'])) {
        $controller = new UtilisateurController($uri);
    } else {
        $controller = new VisiteurController($uri);
    }
}
if($method == 'POST' || $method == 'PUT') {
    $param = json_decode(file_get_contents('php://input'), true);
    if(isset($param['login']) && $token == ModeleUtilisateur::getToken($param['login'])) {
        $controller = new UtilisateurController($uri);
    } else {
        $controller = new VisiteurController($uri);
    }
}
if($method == 'DELETE') {
    $login = explode('/',$uri)[4];
    if($token == ModeleUtilisateur::getToken($login)) {
        $controller = new UtilisateurController($uri);
    } else {
        $controller = new VisiteurController($uri);
    }
}

?>