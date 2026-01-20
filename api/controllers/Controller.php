<?php

include_once("./modeles/ModeleUtilisateur.php");

class Controller {
    public function __construct(string $uri) {
        $uriExploded = explode("/api",parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $uri = "/api" . $uriExploded[1];
        $method = $_SERVER['REQUEST_METHOD'];
        header('Content-Type: application/json; charset=UTF-8');
        if($method == 'GET') {
            switch($uri) {
                case "/api/estConnecte":
                    $this->estConnecte();
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['error' => 'Endpoint non trouvé']);
            }
        }
    } 

    private function estConnecte() : void {
        $headers = getallheaders();
        if (isset($_GET['login']) && isset($headers['Authorization'])) {
            $authorizationHeader = $headers['Authorization'];
            if(preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches) && $matches[1] )
            {
                $token = $matches[1];
                if($token == ModeleUtilisateur::getToken($_GET['login'])) {
                    echo json_encode(['info' => $_GET['login']]);
                } else {
                    echo json_encode(['info' => 'non connecté']);
                }
            }
        }
    }
}

?>