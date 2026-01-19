<?php

include_once("./modeles/ModeleUtilisateur.php");
include_once("./modeles/ModeleReserve.php");
include_once("./services/RecipeAPIService.php");
include_once('Controller.php');

class UtilisateurController extends Controller {
    
    #region CONSTRUCTEUR
    
    public function __construct(string $uri) {
        $uriExploded = explode("/QuoiFaireAvec",parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $uri = $uriExploded[1];
        $method = $_SERVER['REQUEST_METHOD'];
        header('Content-Type: application/json; charset=UTF-8');
        if($method == 'GET') {
            switch($uri) {
                case "/api/utilisateur/getAllReserves":
                    $this->getAllReserves();
                    break;
                case "/api/utilisateur/getRecetteAvecListe":
                    $this->getRecetteAvecListe();
                    break;
                default:
                    parent::__construct($uri);
                    
            }
        }
        if($method == 'POST') {
            $param = json_decode(file_get_contents('php://input'), true);
            switch($uri) {
                case "/api/utilisateur/createReserve":
                    $this->createReserve();
                    break;
                case "/api/utilisateur/createIngredient":
                    $this->createIngredient();
                    break;
                case "/api/utilisateur/ajouterIngredient":
                    $this->ajouterIngredient();
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['error' => 'Endpoint non trouvé']);
            }
        }
        if($method == 'PUT') {
            $param = json_decode(file_get_contents('php://input'), true);
            switch($uri) {
                case "/api/utilisateur/modifierQuantite":
                    $this->modifierQuantite();
                    break;
                case "/api/utilisateur/modifierNomReserve":
                    $this->modifierNomReserve();
                    break;
                case "/api/utilisateur/modiferIngredient":
                    $this->modiferIngredient();
                    break;
                case "/api/utilisateur/modifierMotDePasse":
                    $this->modifierMotDePasse();
                    break;
                default:                        
                    http_response_code(404);
                    echo json_encode(['error' => 'Endpoint non trouvé']);
            }
        }
        if($method == 'DELETE') {
            $uriExploded = explode('/',$uri);
            $endpoint = "/" . $uriExploded[1] . "/" . $uriExploded[2] . "/" . $uriExploded[3];
            switch($endpoint) {
                case "/api/utilisateur/supprimerIngredient":
                    $id = $uriExploded[5];
                    $this->supprimerIngredient($id);
                    break;
                case "/api/utilisateur/supprimerIngredientDeReserve":
                    $login = $uriExploded[4];
                    $numero = $uriExploded[5];
                    $idIngredient = $uriExploded[6];
                    $this->supprimerIngredientDeReserve($login,$numero,$idIngredient);
                    break;
                case "/api/utilisateur/supprimerReserve":
                    $numero = $uriExploded[5];
                    $login = $uriExploded[4];
                    $this->supprimerReserve($numero,$login);
                    break;
                default:                        
                    http_response_code(404);
                    echo json_encode(['error' => 'Endpoint non trouvé']);
            }
        }
    }

    #endregion

    #region GET

    private function getAllReserves() : void {
        echo json_encode(ModeleReserve::getReservesByLoginUtilisateur($_GET['login']));
    }

    private function getRecetteAvecListe() : void {
        $reserves = ModeleReserve::getReservesByLoginUtilisateur($_GET['login']);
        echo json_encode(RecipeAPIService::genererRecetteAvecIngredients($reserves)["data"]);
    }

    #endregion

    #region POST

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

    private function createIngredient() : void {
        $param = json_decode(file_get_contents('php://input'), true);
        if(isset($param['nom']) && isset($param['unite'])) {
            ModeleIngredient::insertIngredient($param['nom'], $param['unite']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'paramètre manquant']);
        }
    }

    #endregion

    #region PUT

    private function modifierQuantite() : void {
        $param = json_decode(file_get_contents('php://input'), true);
        if(isset($param['numero']) && isset($param['idIngredient']) && isset($param['nombre'])) {
            ModeleReserve::updateQuantiteIngredient($param['idIngredient'], $param['login'], $param['numero'], $param['nombre']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'paramètre manquant']);
        }
    }

    private function modifierNomReserve() : void {
        $param = json_decode(file_get_contents('php://input'), true); 
        if(isset($param['nom']) && isset($param['numero'])) {
            ModeleReserve::updateNomReserve($param['nom'], $param['login'], $param['numero']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'paramètre manquant']);
        }
    }

    private function modiferIngredient() : void {
        $param = json_decode(file_get_contents('php://input'), true);
        if(isset($param['nom']) && isset($param['unite']) && isset($param['idIngredient'])) {
            ModeleIngredient::updateIngredient($param['nom'], $param['unite'], $param['idIngredient']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'paramètre manquant']);
        }
    }

    private function modifierMotDePasse() : void {
        $param = json_decode(file_get_contents('php://input'), true);
        if(isset($param['nouveauMdp']) && Validation::validationMdp($param['nouveauMdp'])) {
            ModeleUtilisateur::updateMdp($param['login'], password_hash($param['nouveauMdp'], PASSWORD_DEFAULT));
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'nouveau mot de passe manquant']);
        }
    }

    #endregion

    #region DELETE

    private function supprimerIngredient(string $id) : void {
        if(!empty($id+1)) {
                ModeleIngredient::deleteIngredientById($id);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'numero manquant']);
        }
    }

    private function supprimerReserve(string $numero, string $login) : void {
        if($numero !== null && $numero !== "" && !empty($login)) {
            ModeleReserve::deleteReserve($numero,$login);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'numero et/ou login manquant']);
        }
    }

    private function supprimerIngredientDeReserve(string $login, int $numero, int $idIngredient) : void {
        if($numero !== null && $numero !== "" && !empty($login) && $idIngredient !== null && $idIngredient !== "") {
            ModeleReserve::deleteIngredientFromReserve($numero,$login,$idIngredient);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'numero et/ou login et/ou idIngredient manquant(s)']);
        }
    }

    #endregion
}


?>