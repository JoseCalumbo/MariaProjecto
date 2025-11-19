<?php

<?php
// supõe que $pdo já é uma instância PDO conectada

try {
    // Normalizar/pegar valores do POST (caso não existam, vira array vazio)
    $tiposRaw      = $_POST['examesTipo'] ?? [];
    $nomesRaw      = $_POST['examesNome'] ?? [];
    $parametrosRaw = $_POST['exameParametro'] ?? [];
    $urgenciasRaw  = $_POST['examesEmergrncia'] ?? [];

    // Se algum campo veio como string (quando só há um elemento), transformar em array
    $tipos      = is_array($tiposRaw)      ? $tiposRaw      : [$tiposRaw];
    $nomes      = is_array($nomesRaw)      ? $nomesRaw      : [$nomesRaw];
    $parametros = is_array($parametrosRaw) ? $parametrosRaw : [$parametrosRaw];
    $urgencias  = is_array($urgenciasRaw)  ? $urgenciasRaw  : [$urgenciasRaw];

    // Opcional: trim em todos os valores
    $trimArray = function(array $a){
        return array_map(function($v){ return is_string($v)? trim($v) : $v; }, $a);
    };
    $tipos      = $trimArray($tipos);
    $nomes      = $trimArray($nomes);
    $parametros = $trimArray($parametros);
    $urgencias  = $trimArray($urgencias);

    // Determinar quantos itens tratar (usar o máximo para não perder dados)
    $max = max(count($tipos), count($nomes), count($parametros), count($urgencias));

    // Inserir a consulta primeiro (exemplo)
    $idPaciente = $idPaciente; // pega de sessão/variável
    $idMedico   = $idMedico;   // idem

    $pdo->beginTransaction();

    $sqlConsulta = "INSERT INTO consulta
        (id_paciente, medico_id, data_consulta, queixa_principal, hda, diagnostico, conduta)
        VALUES (?, ?, NOW(), ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sqlConsulta);
    $stmt->execute([
        $idPaciente,
        $idMedico,
        $_POST['motivo'] ?? null,
        $_POST['obs'] ?? null,
        $_POST['diagnostico'] ?? null,
        $_POST['conduta'] ?? null
    ]);
    $idConsulta = $pdo->lastInsertId();

    // Preparar statement para exames
    $sqlExame = "INSERT INTO consulta_exame
        (id_consulta, tipo_exame, exame_nome, parametros, emergencia, data_solicitacao)
        VALUES (?, ?, ?, ?, ?, NOW())";
    $stmtEx = $pdo->prepare($sqlExame);

    // Loop seguro: percorrer até $max e usar valores por índice se existirem
    for ($i = 0; $i < $max; $i++) {
        // Pegar cada campo com fallback para null
        $tipo      = $tipos[$i]      ?? null;
        $nome      = $nomes[$i]      ?? null;
        $parametro = $parametros[$i] ?? null;
        $urgencia  = $urgencias[$i]  ?? null;

        // Se todos os campos estiverem vazios/nulos, pular
        if ($tipo === null && $nome === null && $parametro === null && $urgencia === null) {
            continue;
        }

        // Opcional: validar campos obrigatórios (por exemplo, tipo ou nome)
        if (empty($tipo) && empty($nome)) {
            // Pula ou lança exceção dependendo da tua regra
            continue;
        }

        // Executar insert do exame
        $stmtEx->execute([
            $idConsulta,
            $tipo,
            $nome,
            $parametro,
            $urgencia
        ]);
    }

    // Se tudo ok
    $pdo->commit();

    echo "Consulta e exames inseridos com sucesso. ID consulta: " . $idConsulta;

} catch (Exception $e) {
    // Reverter se erro
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    // Para produção, registar o erro. Aqui exibimos para debug.
    echo "Erro: " . $e->getMessage();
}
