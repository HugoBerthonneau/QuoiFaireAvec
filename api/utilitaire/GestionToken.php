<?php

require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class GestionToken {

    static public function genererJWT(string $login) : string {
        $secretKey = 'ONLY_A_SITH_DEALS_IN_ABSOLUTES';
        $algorithm = 'HS256';
        $expirationTime = time() + (60 * 60);
        $issuedAt = time();
        $payload = [
            'iss' => 'quoiFaireAvec',
            'aud' => 'quoiFaireAvec/api',
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'username' => $login
        ];
        try {
            $jwt = JWT::encode($payload, $secretKey, $algorithm);
            // ENREGISTRER LE TOKEN EN BASE
            return $jwt;
        } catch (Exception $e) {
            echo "Erreur lors de la génération du token : " . $e->getMessage();
        }
    }
}

?>