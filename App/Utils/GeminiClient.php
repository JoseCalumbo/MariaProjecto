<?php

namespace App\Utils;

use \Exception;

class GeminiClient
{
    private $apiKey;
    private $modelUrl;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;

        // URL do modelo
        $this->modelUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . $apiKey;
    }

    // 🔹 Método principal para enviar prompts
    public function gerarResposta($texto)
    {
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $texto]
                    ]
                ]
            ]
        ];

        $jsonData = json_encode($data);

        // Configurando a requisição cURL
        $ch = curl_init($this->modelUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // remover em produção

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("Erro cURL: " . curl_error($ch));
        }

        curl_close($ch);

        $result = json_decode($response, true);

        // Retornando somente o texto da IA
        return $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }
}
