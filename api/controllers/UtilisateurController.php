<?php

include_once("./modeles/ModeleUtilisateur.php");
include_once("./modeles/ModeleReserve.php");

class UtilisateurController {
    
    public function __construct() {
        $uri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),14);
        $method = $_SERVER['REQUEST_METHOD'];
        if($_REQUEST['token'] == ModeleUtilisateur::getToken($_GET['login'])) {
            if($method == 'GET')
            {
                switch($uri) {
                    case "/api/utilisateur/getAllReserves":
                        $this->getAllReserves();
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(['error' => 'Endpoint non trouvé']);
                    break;
                }
            }
        }
    }

    private function getAllReserves() : void {
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(ModeleReserve::getReservesByLoginUtilisateur($_GET['login']));
    }
}


?>