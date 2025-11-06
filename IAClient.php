<?php

// --- Configuração Essencial ---
// Esta é a sua "senha" secreta para a API.
$apiKey = 'AIzaSyBrQGauAyOrjnzBZRfwq1Y31kqqjcfIxc4';

// O "endereço" do modelo Gemini que queremos usar.
// Note que estamos usando gemini-1.5-flash, um modelo rápido e eficiente.
//$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey;
// Mudamos para 'v1' e usamos 'gemini-2.5-flash', que é o modelo mais rápido e estável para texto.
$url = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

// --- O Que Vamos Perguntar (Nosso Prompt) ---
$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'És um assistente médico virtual que auxilia médicos na análise de sintomas e na geração de sugestões de prescrições. 
Não és um substituto do médico — todas as recomendações devem ser confirmadas por um profissional humano antes de serem aplicadas.

Função:
- Receber dados clínicos de um paciente (idade, sexo, sintomas, histórico médico, alergias e resultados de exames).
- Sugerir hipóteses diagnósticas prováveis com base nas informações fornecidas.
- Gerar possíveis planos terapêuticos ou medicamentos, considerando doses seguras e interações medicamentosas.
- Explicar o raciocínio clínico de forma clara e justificada.
- Incluir alertas de contraindicações e necessidade de avaliação presencial quando apropriado.

Formato de resposta:
1. **Resumo clínico:** breve descrição dos dados analisados.
2. **Hipóteses diagnósticas prováveis:** (listar de 1 a 3 com justificativas).
3. **Sugestões de tratamento:** (nome do medicamento, dose, via de administração, duração).
4. **Observações e recomendações:** (alertas, necessidade de exames complementares, reavaliação, etc.).
5. **Aviso ético:** incluir “Esta é uma sugestão automatizada e deve ser confirmada por um médico responsável.”

       Exemplo de entrada:paciente,  20 anos, 60 quilos com mais de 38 grau de febre qual medicamento usar?
']
            ]
        ]
    ]
];

// Convertemos nosso array PHP para o formato JSON, que a API entende.
$jsonData = json_encode($data);

// --- Preparando a Requisição cURL ---
$ch = curl_init($url); // Inicia a "ligação"
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Avisa que estamos enviando JSON
curl_setopt($ch, CURLOPT_POST, true); // Diz que estamos "enviando" dados (não apenas "buscando")
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Anexa nossos dados (o prompt)
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Pede para nos devolver a resposta como uma string
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Apenas para testes locais (remove em produção!)

// --- Executar e Obter Resposta ---
$response = curl_exec($ch); // Faz a ligação!

// Verifica se houve algum erro no cURL
if (curl_errno($ch)) {
    echo 'Erro no cURL: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch); // Desliga

// --- Processando a Resposta ---
$result = json_decode($response, true); // Decodifica a resposta JSON para um array PHP

// --- Verificando e Imprimindo a Resposta ---
if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    // Imprime o texto puro da resposta do Gemini
    echo $result['candidates'][0]['content']['parts'][0]['text'];
} else {
    // Se o Gemini bloquear ou der erro, mostra a resposta crua para depuração
    echo "Não foi possível obter uma resposta válida. Resposta recebida:\n";
    print_r($result);
}

?>