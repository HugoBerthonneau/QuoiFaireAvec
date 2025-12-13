<?php

include_once("./modeles/ModeleUtilisateur.php");
include_once("./modeles/ModeleReserve.php");

class UtilisateurController {
    
    public function __construct() {
        $uri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),14);
        $method = $_SERVER['REQUEST_METHOD'];
        header('Content-Type: application/json; charset=UTF-8');
        if($method == 'GET') {
            if($_REQUEST['token'] == ModeleUtilisateur::getToken($_REQUEST['login'])) {
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
        if($method == 'POST') {
            $param = json_decode(file_get_contents('php://input'), true);
            if($param['token'] == ModeleUtilisateur::getToken($param['login'])) {
                switch($uri) {
                    case "/api/utilisateur/createReserve":
                        $this->createReserve();
                        break;
                    case "/api/utilisateur/ajouterIngredient":
                        $this->ajouterIngredient();
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(['error' => 'Endpoint non trouvé']);
                }
            }
        }
        if($method == 'PUT') {
            $param = json_decode(file_get_contents('php://input'), true);
            if($param['token'] == ModeleUtilisateur::getToken($param['login'])) {
                switch($uri) {
                    case "/api/utilisateur/modifierQuantite":
                        $this->modifierQuantite();
                        break;
                    default:                        
                        http_response_code(404);
                        echo json_encode(['error' => 'Endpoint non trouvé']);

                    
                }
            }
        }
    }

    #region METHODE GET

    private function getAllReserves() : void {
        echo json_encode(ModeleReserve::getReservesByLoginUtilisateur($_GET['login']));
    }

    #endregion

    #region METHODE POST

    private function createReserve() : void {
        $param = json_decode(file_get_contents('php://input'), true); 
        if(isset($param['nom'])) {
            ModeleReserve::insertReserve($param['login'], $param['nom']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'nom manquant']);
        }
    }

    private function ajouterIngredient() : void {
        $param = json_decode(file_get_contents('php://input'), true);
        if(isset($param['numero']) && isset($param['idIngredient']) && isset($param['nombre'])) {
            ModeleReserve::addIngredientToReserve($param['idIngredient'], $param['login'], $param['numero'], $param['nombre']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'paramètre manquant']);
        }
    }

    #endregion

    #region METHODE PUT

    private function modifierQuantite() : void {
        $param = json_decode(file_get_contents('php://input'), true);
        if(isset($param['numero']) && isset($param['idIngredient']) && isset($param['nombre'])) {
            ModeleReserve::updateQuantiteIngredient($param['idIngredient'], $param['login'], $param['numero'], $param['nombre']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'paramètre manquant']);
        }
    }


    #endregion
}


?>