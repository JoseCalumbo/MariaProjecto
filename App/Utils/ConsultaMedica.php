<?php

namespace App\Utils;

// require_once "GeminiClient.php";

class ConsultaMedica
{
    private $gemini;

    public function __construct()
    {
        // Insira sua API KEY
        //  $this->gemini = new GeminiClient("AIzaSyBrQGauAyOrjnzBZRfwq1Y31kqqjcfIxc4");
       // $this->gemini = new GeminiClient("AIzaSyC1neetpZ1KelvehH4odb82wPm91wmfiS8");
        $this->gemini = new GeminiClient("AIzaSyBpDt5OyNACLn7N52H0RlgRpfh5AhgZEF8");
    }

    public function analisarPaciente($dadosPaciente)
    {
        $prompt = "
            És um assistente médico virtual... (SEU PROMPT COMPLETO AQUI)

            Exemplo de entrada: $dadosPaciente
        ";

        return $this->gemini->gerarResposta($prompt);
    }
}
