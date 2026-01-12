<?php

namespace App\Utils;

class OpenRouterService2
{
    private string $apiKey;
    private string $baseUrl = "https://openrouter.ai/api/v1/chat/completions";
    private string $model = "deepseek/deepseek-chat";

    public function __construct()
    {
        // Ideal: guardar a chave no .env
        $this->apiKey = $_ENV['OPENROUTER_API_KEY'] ?? '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';
    }

public function sendMessage(string $userMessage, string $model = null): array
{
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer {$this->apiKey}"
    ];

    $payload = [
        "model" => $model ?? $this->model,
        "messages" => [
            ["role" => "user", "content" => $userMessage]
        ]
    ];

    $ch = curl_init($this->baseUrl);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_CONNECTTIMEOUT => 10, // tempo para conectar
        CURLOPT_TIMEOUT => 30          // tempo total
    ]);

    $response = curl_exec($ch);

    // ❌ Sem internet / timeout / erro de rede
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);

        return [
            "error" => true,
            "type" => "network",
            "message" => "⚠️ Sem ligação à internet ou serviço indisponível.",
            "details" => $error
        ];
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // ❌ API respondeu mas com erro
    if ($httpCode !== 200) {
        return [
            "error" => true,
            "type" => "api",
            "message" => "⚠️ Serviço de IA temporariamente indisponível.",
            "http_code" => $httpCode
        ];
    }

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
