<!-- src/Views/prescricao_medica.php -->
<?php
// Variáveis esperadas dessa view (defina no Controller antes de incluir):
// $paciente (array or object) com campos id, nome, idade, sexo, peso, alergias
// $medico_id (int)
// $csrf_token (string) opcional

$paciente = $paciente ?? (object)[
    'id' => $_GET['id_paciente'] ?? 1,
    'nome' => 'Paciente Exemplo',
    'idade' => '20',
    'sexo' => 'F',
    'peso' => '60kg',
    'alergias' => 'Nenhuma'
];
$medico_id = $medico_id ?? ($_GET['id_medico'] ?? 1);
$csrf_token = $csrf_token ?? bin2hex(random_bytes(16));

?>

<!doctype html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel de Prescrição com IA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f9fc
        }

        .card {
            border-radius: 12px
        }

        .sidebar {
            min-height: 70vh
        }

        pre.ia-output {
            white-space: pre-wrap;
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e9ecef
        }

        .small-muted {
            font-size: .85rem;
            color: #6c757d
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Clínica AI</a>
            <div class="d-flex align-items-center">
                <div class="me-3 small-muted">Dr. João Manuel — Clínico</div>
                <div class="badge bg-success">IA: Online</div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row g-3">

            <!-- SIDEBAR: DADOS DO PACIENTE -->
            <aside class="col-lg-3">
                <div class="card shadow-sm sidebar p-3">
                    <h5 class="mb-2">Paciente</h5>
                    <p class="mb-1"><strong>
                            <?= htmlspecialchars($paciente->nome) ?>
                        </strong></p>
                    <p class="small-muted mb-1">ID:
                        <?= htmlspecialchars($paciente->id) ?>
                    </p>
                    <p class="mb-1">Idade:
                        <?= htmlspecialchars($paciente->idade) ?>
                    </p>
                    <p class="mb-1">Sexo:
                        <?= htmlspecialchars($paciente->sexo) ?>
                    </p>
                    <p class="mb-1">Peso:
                        <?= htmlspecialchars($paciente->peso) ?>
                    </p>
                    <p class="mb-1">Alergias:
                        <?= htmlspecialchars($paciente->alergias) ?>
                    </p>

                    <hr>
                    <h6 class="mb-2">Exames recentes</h6>
                    <div class="small-muted">Nenhum exame recente disponível</div>

                    <hr>
                    <div class="d-grid">
                        <a href="/index.php?r=consulta_list&id_medico=<?= $medico_id ?>"
                            class="btn btn-outline-primary btn-sm">Ver Minhas Consultas</a>
                    </div>
                </div>
            </aside>

            <!-- AREA PRINCIPAL: PRESCRIÇÃO E IA -->
            <main class="col-lg-6">
                <div class="card shadow-sm p-3">
                    <h5 class="mb-3">Gerar Sugestão de Prescrição (IA)</h5>

                    <form id="form-prescricao" method="post" action="/index.php?r=consulta_create">
                        <input type="hidden" name="id_paciente" value="<?= htmlspecialchars($paciente->id) ?>">
                        <input type="hidden" name="id_medico" value="<?= htmlspecialchars($medico_id) ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                        <div class="mb-3">
                            <label class="form-label">Resumo clínico / Sintomas</label>
                            <textarea id="sintomas" name="sintomas" class="form-control" rows="5"
                                placeholder="Descrever queixas, sinais, duração, medicações em uso...">Paciente com febre 38°C há 2 dias, tosse seca, sem alergias</textarea>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <input type="text" name="idade" class="form-control" placeholder="Idade"
                                    value="<?= htmlspecialchars($paciente->idade) ?>">
                            </div>
                            <div class="col-6">
                                <input type="text" name="peso" class="form-control" placeholder="Peso"
                                    value="<?= htmlspecialchars($paciente->peso) ?>">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button id="btn-ia" type="button" class="btn btn-primary">Gerar sugestão com IA</button>
                            <button id="btn-salvar" type="submit" class="btn btn-success">Salvar consulta</button>
                            <button id="btn-limpar" type="button" class="btn btn-outline-secondary">Limpar</button>
                        </div>
                    </form>

                    <hr>

                    <div id="ia-card" class="mt-3 d-none">
                        <h6>Resultado da IA</h6>
                        <div class="mb-2 small-muted">(Revise sempre antes de aceitar — obrigatório confirmar por
                            profissional)</div>
                        <div id="ia-output" class="ia-output mb-2">—</div>

                        <div class="d-flex gap-2">
                            <button id="btn-aceitar" class="btn btn-outline-success btn-sm">Aceitar Prescrição</button>
                            <button id="btn-editar" class="btn btn-outline-primary btn-sm">Editar</button>
                            <a id="btn-download" class="btn btn-outline-secondary btn-sm d-none" href="#">Baixar PDF</a>
                        </div>
                    </div>

                </div>

                <!-- Histórico rápido (opcional) -->
                <div class="card shadow-sm mt-3 p-3">
                    <h6>Histórico de Prescrições Rápidas</h6>
                    <div class="small-muted">Últimas 5 prescrições do paciente</div>
                    <ul id="historico" class="list-group list-group-flush mt-2">
                        <!-- preenchido via servidor ou AJAX -->
                    </ul>
                </div>

            </main>

            <!-- COLUNA DIREITA: RESUMO E AÇÕES -->
            <aside class="col-lg-3">
                <div class="card shadow-sm p-3">
                    <h6>Resumo</h6>
                    <div class="small-muted">Ações rápidas e alertas</div>

                    <div class="mt-3">
                        <div><strong>Alertas de alergia:</strong> <span id="alerta-alergia">
                                <?= htmlspecialchars($paciente->alergias) ?>
                            </span></div>
                    </div>

                    <hr>
                    <div class="d-grid">
                        <a id="ver-pdf" href="#" class="btn btn-outline-secondary btn-sm disabled">Visualizar PDF</a>
                    </div>

                </div>
            </aside>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const btnIA = document.getElementById('btn-ia');
            const outputCard = document.getElementById('ia-card');
            const output = document.getElementById('ia-output');
            const form = document.getElementById('form-prescricao');
            const btnAceitar = document.getElementById('btn-aceitar');
            const btnEditar = document.getElementById('btn-editar');
            const btnDownload = document.getElementById('btn-download');
            const historico = document.getElementById('historico');

            // Gera sugestão via AJAX para endpoint do Controller
            btnIA.addEventListener('click', async function () {
                btnIA.disabled = true; btnIA.innerText = 'Gerando...';

                const formData = new FormData(form);

                try {
                    const resp = await fetch('/index.php?r=consulta_generate_ai', {
                        method: 'POST',
                        body: formData
                    });

                    if (!resp.ok) throw new Error('Erro no servidor');

                    const data = await resp.json();

                    if (data.success) {
                        output.innerText = data.text;
                        outputCard.classList.remove('d-none');
                        btnDownload.href = '/index.php?r=consulta_download_pdf_preview&id=' + (data.consulta_id ?? '');
                        btnDownload.classList.remove('d-none');
                        btnDownload.classList.remove('disabled');
                        // opcional: preencher historico se enviado
                        if (data.historico && data.historico.length) {
                            historico.innerHTML = '';
                            data.historico.forEach(h => {
                                const li = document.createElement('li'); li.className = 'list-group-item small'; li.innerText = h;
                                historico.appendChild(li);
                            });
                        }
                    } else {
                        output.innerText = 'A IA não retornou sugestão: ' + (data.error || 'erro desconhecido');
                        outputCard.classList.remove('d-none');
                    }

                } catch (err) {
                    console.error(err);
                    output.innerText = 'Erro ao contactar o servidor: ' + err.message;
                    outputCard.classList.remove('d-none');
                }

                btnIA.disabled = false; btnIA.innerText = 'Gerar sugestão com IA';
            });

            // Aceitar -> submete formulário normalmente para salvar no banco
            btnAceitar.addEventListener('click', function () {
                // opcional: preencher hidden com texto da IA antes de submeter
                const iaText = output.innerText || '';
                // cria campo hidden resposta_ia
                let f = form.querySelector('input[name="resposta_ia"]');
                if (!f) {
                    f = document.createElement('input'); f.type = 'hidden'; f.name = 'resposta_ia'; form.appendChild(f);
                }
                f.value = iaText;

                form.submit();
            });

            // Editar -> copia texto da IA para textarea para o medico ajustar
            btnEditar.addEventListener('click', function () {
                const txt = output.innerText || '';
                const ta = document.getElementById('sintomas');
                ta.value = txt;
                window.scrollTo({ top: ta.offsetTop - 80, behavior: 'smooth' });
            });

            // Limpar
            document.getElementById('btn-limpar').addEventListener('click', function () {
                form.reset(); output.innerText = '—'; outputCard.classList.add('d-none');
            });
        })();
    </script>

</body>

</html>