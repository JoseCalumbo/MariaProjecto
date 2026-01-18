<?php

namespace App\Utils;

class OpenRouterService
{
    private string $apiKey;
    private string $baseUrl = "https://openrouter.ai/api/v1/chat/completions";
    private string $model = "deepseek/deepseek-chat";


    //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
    // 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

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
            'max_tokens' => 400, // <<< MUITO IMPORTANTE
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
