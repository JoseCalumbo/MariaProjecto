<?php

namespace App\Utils;
        
class OpenRouterService
{
    private string $apiKey;
    private string $baseUrl = "https://openrouter.ai/api/v1/chat/completions";
    private string $model = "deepseek/deepseek-chat";


    //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

    #novo
    //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

    #git novo
    //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

    public function __construct()
    {
        // Ideal: guardar a chave no .env
        $this->apiKey = $_ENV['OPENROUTER_API_KEY'] ?? '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';
    }

    /**
     * Envia uma mensagem para a OpenRouter
     */
    public function sendMessage(string $userMessage, string $model = null): array
    {
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer {$this->apiKey}"
        ];

        $payload = [
            "model" => $model ?? $this->model,
            'max_tokens' => 80, // <<< MUITO IMPORTANTE
            'stream' => true,
            "messages" => [
                ["role" => "user", "content" => $userMessage]
            ],
            "stream" => false
        ];

        $ch = curl_init($this->baseUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return [
                "error" => true,
                "message" => "Erro CURL: " . curl_error($ch)
            ];
        }

        curl_close($ch);

        $decoded = json_decode($response, true);

        return $this->formatResponse($decoded);
    }

    /**
     * Formata a resposta vinda da API
     */
    private function formatResponse(array $response): array
    {
        if (isset($response['choices'][0]['message']['content'])) {

            return [
                "error" => false,
                "reply" => trim($response['choices'][0]['message']['content']),
                "tokens" => $response['usage']['total_tokens'] ?? null,
                "cost"   => $response['usage']['cost'] ?? null,
                "raw"    => $response
            ];
        }

        // Erro da API OpenRouter
        return [
            "error" => true,
            "message" => $response['error']['message'] ?? 'Erro desconhecido',
            "raw" => $response
        ];
    }
}
