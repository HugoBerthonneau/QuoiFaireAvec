<?php

include_once("./classes/Reserve.php");

class RecipeAPIService {

    static function genererRecetteAleatoire(): array {
        $url = 'https://openrouter.ai/api/v1/chat/completions';
        $model = 'tngtech/deepseek-r1t2-chimera:free';
        $apiKey = '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';
        
        $systemPrompt = "Tu es un assistant culinaire. Tu dois UNIQUEMENT répondre avec du JSON valide, sans texte avant ou après, sans balises markdown (pas de ```json ni ```). Le JSON doit contenir un tableau 'recettes' avec 5 recettes.";
    
        $userPrompt = "
        Propose 5 recettes COMPLÈTES. Réponds UNIQUEMENT avec ce format JSON exact (pas de ```json ni ``` ni texte supplémentaire) :
        {
        \"recettes\": [
            {
            \"nom\": \"Nom de la recette\",
            \"ingredients\": [
                {\"nom\": \"tomate\", \"quantite\": 200, \"unite\": \"g\"},
                {\"nom\": \"oeuf\", \"quantite\": 3, \"unite\": \"unité\"},
                {\"nom\": \"farine\", \"quantite\": 100, \"unite\": \"g\"}
                ],
            \"temps_preparation\": \"20 min\",
            \"difficulte\": \"facile\",
            \"instructions\": [\"Etape 1\",\"Etape 2\",\"Etape 3\",\"Etape 4\",\"Etape 5\",\"Etape 6\",\"Etape 7\",\"Etape 8\",\"Etape 9\",\"Etape 10\"]
            }
        ]
        }

        IMPORTANT : 
        - Toutes les 5 recettes doivent être complètes
        - Chaque ingrédient doit inclure sa quantité (ex: \"200g de poulet\", \"2 oignons\", \"1L de lait\")
        - Pas de balises markdown ```json ou ```";
            
            $data = [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $userPrompt
                    ]
                ],
                'max_tokens' => 4000,
                'temperature' => 0.7,
                'response_format' => ['type' => 'json_object'] // Force le JSON
            ];
            
            $options = [
                'http' => [
                    'header' => [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $apiKey
                    ],
                    'method' => 'POST',
                    'content' => json_encode($data),
                    'ignore_errors' => true,
                    'timeout' => 30
                ]
            ];
            
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                return ['error' => 'Erreur lors de la requête API'];
            }
            
            $result = json_decode($response, true);
            
            if (isset($result['choices'][0]['message']['content'])) {
                $content = $result['choices'][0]['message']['content'];
                
                // Nettoyer le contenu de TOUTES les variations de balises markdown
                $content = preg_replace('/^```json\s*/i', '', $content);  // Début avec ```json
                $content = preg_replace('/^```\s*/i', '', $content);      // Début avec ```
                $content = preg_replace('/\s*```$/i', '', $content);      // Fin avec ```
                $content = trim($content);
                
                $recipes = json_decode($content, true);
                
                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'success' => true,
                        'data' => $recipes,
                        'model' => $result['model'] ?? $model
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => 'Erreur de parsing JSON: ' . json_last_error_msg(),
                        'raw_content' => $content
                    ];
                }
            }
            
            return [
                'success' => false,
                'error' => $result['error']['message'] ?? 'Erreur inconnue',
                'full_response' => $result
            ];
    }

    static function genererRecetteAvecIngredients(array $reserves) : array {

        $url = 'https://openrouter.ai/api/v1/chat/completions';
        $model = 'tngtech/deepseek-r1t2-chimera:free';
        $apiKey = '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';

        $userPrompt = "À partir des ingrédients suivants UNIQUEMENT : ";

        foreach($reserves as $res) {
            foreach ($res->getLesIngredients() as $ingredient) {
                $userPrompt .= $ingredient->getNom() ." ". $ingredient->getQuantite()->getValeur() . $ingredient->getQuantite()->getUnite() .",";
            }
        }
        
        $systemPrompt = "Tu es un assistant culinaire. Tu dois UNIQUEMENT répondre avec du JSON valide, sans texte avant ou après, sans balises markdown (pas de ```json ni ```). Le JSON doit contenir un tableau 'recettes' avec 5 recettes.";
    
        $userPrompt .= "
        Propose 5 recettes COMPLÈTES. Réponds UNIQUEMENT avec ce format JSON exact (pas de ```json ni ``` ni texte supplémentaire) :
        {
        \"recettes\": [
            {
            \"nom\": \"Nom de la recette\",
            \"ingredients\": [
                {\"nom\": \"tomate\", \"quantite\": 200, \"unite\": \"g\"},
                {\"nom\": \"oeuf\", \"quantite\": 3, \"unite\": \"unité\"},
                {\"nom\": \"farine\", \"quantite\": 100, \"unite\": \"g\"}
                ],
            \"temps_preparation\": \"20 min\",
            \"difficulte\": \"facile\",
            \"instructions\": [\"Etape 1\",\"Etape 2\",\"Etape 3\",\"Etape 4\",\"Etape 5\",\"Etape 6\",\"Etape 7\",\"Etape 8\",\"Etape 9\",\"Etape 10\"]
            }
        ]
        }

        IMPORTANT : 
        - Toutes les 5 recettes doivent être complètes
        - Chaque ingrédient doit inclure sa quantité (ex: \"200g de poulet\", \"2 oignons\", \"1L de lait\")
        - Pas de balises markdown ```json ou ```";
            
            $data = [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $userPrompt
                    ]
                ],
                'max_tokens' => 4000,
                'temperature' => 0.7,
                'response_format' => ['type' => 'json_object'] // Force le JSON
            ];
            
            $options = [
                'http' => [
                    'header' => [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $apiKey
                    ],
                    'method' => 'POST',
                    'content' => json_encode($data),
                    'ignore_errors' => true,
                    'timeout' => 30
                ]
            ];
            
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            
            if ($response === false) {
                return ['error' => 'Erreur lors de la requête API'];
            }
            
            $result = json_decode($response, true);
            
            if (isset($result['choices'][0]['message']['content'])) {
                $content = $result['choices'][0]['message']['content'];
                
                // Nettoyer le contenu de TOUTES les variations de balises markdown
                $content = preg_replace('/^```json\s*/i', '', $content);  // Début avec ```json
                $content = preg_replace('/^```\s*/i', '', $content);      // Début avec ```
                $content = preg_replace('/\s*```$/i', '', $content);      // Fin avec ```
                $content = trim($content);
                
                $recipes = json_decode($content, true);
                
                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'success' => true,
                        'data' => $recipes,
                        'model' => $result['model'] ?? $model
                    ];
                } else {
                    return [
                        'success' => false,
                        'error' => 'Erreur de parsing JSON: ' . json_last_error_msg(),
                        'raw_content' => $content
                    ];
                }
            }
            
            return [
                'success' => false,
                'error' => $result['error']['message'] ?? 'Erreur inconnue',
                'full_response' => $result
            ];
            }
}

?>