<?php

include_once("./modeles/ModeleUtilisateur.php");
include_once("./utilitaire/GestionToken.php");
include_once("./utilitaire/Validation.php");

class VisiteurController {

    public function __construct() {
        $uri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),14);
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'GET')
            {

                switch($uri) {
                    case "/api/visiteur/verifLoginMotDePasse":
                        $this->verifLoginMotDePasse();
                        break;

                    default:
                        http_response_code(404);
                        echo json_encode(['error' => 'Endpoint non trouvé']);
                        break;
                }
        } 
    }

    private function verifLoginMotDePasse() : void {
        if(isset($_GET['login']) && isset($_GET['mdp'])) {
            $login = trim($_GET['login']);
            $mdp = trim($_GET['mdp']);
            $mdpBase = ModeleUtilisateur::getMotDePasseHache($login);
            if(password_verify($mdp,ModeleUtilisateur::getMotDePasseHache($login))) {
                $jwt = GestionToken::genererJWT($login);
                ModeleUtilisateur::updateToken($login,$jwt);
                header('Content-Type: application/json; charset=UTF-8');
                echo '{
                            "access_token": "' . $jwt . '",
                            "token_type": "Bearer",
                            "expires_in": 3600
                        }';
            }
            else
            {
                http_response_code(400);
            }
        }
    }
}

?>