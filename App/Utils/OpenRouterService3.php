<?php

namespace App\Utils;

class OpenRouterService3
{
    private string $apiKey;
    private string $baseUrl = "https://openrouter.ai/api/v1/chat/completions";
    private string $model = "deepseek/deepseek-chat";

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
