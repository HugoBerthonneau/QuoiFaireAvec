<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');

header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}



include_once('controllers/VisiteurController.php');
include_once('controllers/UtilisateurController.php');

$uriExploded = explode("/api",parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$uri = "/api" . $uriExploded[1];

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
    if(isset($_GET['login']) && !empty($token) && $token == ModeleUtilisateur::getToken($_GET['login'])) {
        $controller = new UtilisateurController($uri);
    } else {
        $controller = new VisiteurController($uri);
    }
}
if($method == 'POST' || $method == 'PUT') {
    $param = json_decode(file_get_contents('php://input'), true);
    if(isset($param['login']) && !empty($token) && $token == ModeleUtilisateur::getToken($param['login'])) {
        $controller = new UtilisateurController($uri);
    } else {
        $controller = new VisiteurController($uri);
    }
}
if($method == 'DELETE') {
    $login = explode('/',$uri)[4];
    if(!empty($token) && $token == ModeleUtilisateur::getToken($login)) {
        $controller = new UtilisateurController($uri);
    } else {
        $controller = new VisiteurController($uri);
    }
}


?>