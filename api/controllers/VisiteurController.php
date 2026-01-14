<?php

include_once("./modeles/ModeleUtilisateur.php");
include_once("./utilitaire/GestionToken.php");
include_once("./utilitaire/Validation.php");
include_once('Controller.php');

class VisiteurController extends Controller  {

    public function __construct(string $uri) {
        $uri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),14);
        $method = $_SERVER['REQUEST_METHOD'];
        header('Content-Type: application/json; charset=UTF-8');
        if($method == 'GET') {
            switch($uri) {
                case "/api/visiteur/verifLoginMotDePasse":
                    $this->verifLoginMotDePasse();
                    break;
                case "/api/visiteur/getRecetteAleatoire":
                    $this->getRecetteAleatoire();                    
                    break;
                case "/api/visiteur/getRecetteAleatoire":
                    $this->getRecetteAleatoire();
                    break;
                case "/api/visiteur/getIngredients":
                    $this->getIngredients();
                    break;
                default:
                    parent::__construct($uri);
            }
        }
        if($method == 'POST') {
            switch($uri) {
                case "/api/visiteur/creationUtilisateur":
                    $this->creationUtilisateur();
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['error' => 'endpoint non trouvé/authentification invalide']);
                    break;
            }    
        }
    }

    #region GET
    
    private function verifLoginMotDePasse() : void {
        if(isset($_GET['login']) && isset($_GET['mdp'])) {
            $login = trim($_GET['login']);
            $mdp = trim($_GET['mdp']);
            if(password_verify($mdp,ModeleUtilisateur::getMotDePasseHache($login))) {
                $jwt = GestionToken::genererJWT($login);
                ModeleUtilisateur::updateToken($login,$jwt);
                echo '{
                            "access_token": "' . $jwt . '",
                            "token_type": "Bearer",
                            "expires_in": 3600
                        }';
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'mot de passe incorrect']);

            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'login et/ou de mot de passe manquant']);

        }
    }

    private function getRecetteAleatoire() : void {
        echo json_encode(RecipeAPIService::genererRecetteAleatoire()["data"]);
    }

    private function getIngredients() : void {
        echo json_encode(ModeleIngredient::getAllIngredients());
    }

    #endregion

    #region POST

    private function creationUtilisateur() : void {
        $param = json_decode(file_get_contents('php://input'), true); 
        if(isset($param['login']) && isset($param['mdp']) && Validation::validationLogin($param['login']) && Validation::validationMdp($param['mdp'])) {
            $res = ModeleUtilisateur::insertUtilisateur($param['login'], password_hash($param['mdp'], PASSWORD_DEFAULT));
            if(!$res) {
                http_response_code(400);
                echo json_encode(['error' => 'erreur lors de l\'insertion de l\'utilisateur']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'login et/ou de mot de passe manquant ou invalides']);
        }
    }

    #endregion
}

?>