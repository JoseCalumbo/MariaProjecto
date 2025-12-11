<?php

namespace App\Controller\Pages;

use App\Model\Entity\ConsultaDao;
use App\Model\Entity\ExameDao;
use App\Model\Entity\ExameSolicitadoDao;
use App\Model\Entity\MarcarConsultaDao;
use App\Model\Entity\PacienteDao;
use App\Model\Entity\TriagemDao;

use \App\Utils\Pagination;
use \App\Utils\View;

use \App\Controller\Mensagem\MensagemAdmin;



class Consulta extends Page
{
    // Metodo para exibir as mensagens
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg']))
            return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return MensagemAdmin::msgSucesso('Consulta registrada com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Exame Alterado com sucesso');
                break;
            case 'validar':
                return MensagemAdmin::msgAlerta('Consulta foi salva, mas é necessario validar ou finalizar o seu estado');
                break;
        } // fim do switch
    }

    // Metodo que apresenta os pacientes aspera da consulta PRINCIPAL
    private static function getPacienteEspera($request, &$obPagination)
    {
        // Var que retorna o conteudo
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $condicoes = [
            strlen($buscar) ? 'nome_paciente LIKE "%' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        $resultado = PacienteDao::listarPacienteEspera($where);

        while ($obPacientesEspera = $resultado->fetchObject(ConsultaDao::class)) {

            $atender =  $obPacientesEspera->risco_triagem;
            $triagemAtender = "";
            switch ($atender) {
                case 'a':
                    $triagemAtender = "Vermelho";
                    break;
                case 'b':
                    $triagemAtender = "Laranja";
                    break;
                case 'c':
                    $triagemAtender = "Amarelo";
                    break;
                case 'd':
                    $triagemAtender = "Verde";
                    break;
                case 'e':
                    $triagemAtender = "Azul";
                    break;
            } // fim do switch

            $item .= View::render('consulta/listarPacienteEspera', [
                'id_triagem' => $obPacientesEspera->id_triagem,
                'id_paciente' => $obPacientesEspera->id_paciente,
                'imagem' => $obPacientesEspera->imagem_paciente,
                'nome_paciente' => $obPacientesEspera->nome_paciente,
                'genero' => $obPacientesEspera->genero_paciente,
                'estado' => $obPacientesEspera->estado_paciente,
                'perioridade' => $triagemAtender,
            ]);
        }

        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisarq'] ?? '') {

            return View::render('pesquisar/box_resultado', [
                'pesquisa' => $buscar,
                'resultados' => $item,
                'item' => '',

            ]);
        }

        return $item = strlen($item) ? $item : '<tr class="no-hover no-border" style="height: 60px;">
                                                   <td colspan="7" class="center-align no-border font-normal" style="vertical-align: middle; height:120px; font-size:18px">
                                                    Sem registos de pacientes em espera.
                                                    </td>
                                                </tr>';
    }

    // Metodo que apresenta os pacientes aspera da minha consulta
    private static function getMinhaConsulta($request, &$obPagination)
    {
        $queryParam = $request->getQueryParams();

        $obPagination = new Pagination(null, null, null);

        // Var que retorna o conteudo
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_paciente LIKE "%' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = ConsultaDao::listarConsultaFeita($where, 'nome_paciente', null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = ConsultaDao::listarConsultaFeita($where, 'nome_paciente', $obPagination->getLimit());

        while ($obMeuPacientesConsulta = $resultado->fetchObject(ConsultaDao::class)) {

            $item .= View::render('consulta/listarMeusPaciente', [
                'id_consulta' => $obMeuPacientesConsulta->id_consulta,
                'id_triagem' => $obMeuPacientesConsulta->id_triagem,
                'id_paciente' => $obMeuPacientesConsulta->id_paciente,
                'imagem' => $obMeuPacientesConsulta->imagem_paciente,
                'nome_paciente' => $obMeuPacientesConsulta->nome_paciente,
                'receita' =>  !empty($obMeuPacientesConsulta->add_receita_consulta) ? $obMeuPacientesConsulta->add_receita_consulta : "______",
                'exames' => $obMeuPacientesConsulta->estado_consulta  == "Exames pendentes" ? $obMeuPacientesConsulta->estado_consulta : "Sem exames",
                'estado' => $obMeuPacientesConsulta->estado_paciente,
            ]);
        }

        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::render('pesquisar/box_resultado', [
                'pesquisa' => $buscar,
                'resultados' => $item,
                'numResultado' => $quantidadetotal,
                'item' => '',

            ]);
        }

        return $item = strlen($item) ? $item : '<tr class="no-hover no-border" style="height: 60px;">
                                                   <td colspan="7" class="center-align no-border font-normal" style="vertical-align: middle; height:120px; font-size:18px">
                                                    Nenhum paciente encontrado.
                                                    </td>
                                                </tr>';
    }

    // Metodo que apresenta os pacientes agendados
    private static function getConsultaFinalizada($request, &$obPagination)
    {
        // Var que retorna o conteudo
        $item = '';

        $resultado = MarcarConsultaDao::listarConsultaMarcada();

        while ($obPacientesEspera = $resultado->fetchObject(MarcarConsultaDao::class)) {

            $item .= View::render('consulta/listarAgenda', [
                'id_triagem' => "",
                'id_paciente' => "",
                'tipo' => "Consulta geral",
                'nome_paciente' => "",
                'dataMarcacao' => "12-10-2026",
                'dataConsulta' => "12-10-2026",
                'estado' => "",
            ]);
        }

        return $item = strlen($item) ? $item : '<tr class="no-hover no-border" style="height: 60px;">
                                                   <td colspan="7" class="center-align no-border font-normal" style="vertical-align: middle; height:120px; font-size:18px">
                                                    Sem consultas finalizada.
                                                    </td>
                                                </tr>';
    }

    // Método para apresenatar os registos do exames finalizados
    private static function getExameSolicitado($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_exame LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela exames
        $quantidadetotal = ExameSolicitadoDao::listarMeuExamesSolicitado($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 8);

        $resultado = ExameSolicitadoDao::listarMeuExamesSolicitado($where, 'emergencia_exame', $obPagination->getLimit());

        while ($obExameSolicitado = $resultado->fetchObject(ExameSolicitadoDao::class)) {

            $item .= View::render('consulta/listarExameSolicitado', [
                'id_exameSolicitado' => $obExameSolicitado->id_exame_solicitado,
                'nome_paciente' => $obExameSolicitado->nome_paciente,
                'exame' => $obExameSolicitado->nome_exame,
                'estado' => $obExameSolicitado->estado_exame_solicitado,
            ]);
        } 

        // Verifica se foi realizada uma pesquisa
        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::render('pesquisar/box_resultado', [
                'pesquisa' => $buscar,
                'item' => $item,
                'numResultado' => $quantidadetotal,
            ]);
        }
        //Nenhum Exame encontado
        return $item = strlen($item) ? $item : '<tr class="no-hover no-border" style="height: 60px;">
                                                   <td colspan="7" class="center-align no-border font-normal" style="vertical-align: middle; height:120px; font-size:18px">
                                                   Nenhum exame solicitado concluido encontrado.
                                                    </td>
                                                </tr>';
    }

    // busca todos os exames para o select dos exames 
    public static function getExamesSelect()
    {
        $resultadoExame = '';

        $listarExames = ExameDao::listarExame(null, 'nome_exame');

        while ($obExame = $listarExames->fetchObject(ExameDao::class)) {
            $resultadoExame .= View::render('consulta/itemConsulta/exames', [
                'value' => $obExame->id_exame,
                'exame' => $obExame->nome_exame,
            ]);
        }
        return $resultadoExame;
    }

    // Metodo para apresentar a tela do consultorio
    public static function telaConsulta($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('consulta/Consultorio', [
            'msg' => self::exibeMensagem($request),

            'pesquisar' => $buscar,

            'listarPacienteEspera' => self::getPacienteEspera($request, $obPagination),

            'listarMinhaConsulta' => self::getMinhaConsulta($request, $obPagination),

            'listarConsultaFinalizada' => self::getConsultaFinalizada($request, $obPagination),

            'listarExames' => self::getExameSolicitado($request, $obPagination),

            'pagConsultasEspera' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Consultorio', $content);
    }

    // Metodo que inicia as consultas
    public static function getcadastrarConsulta($request, $id_triagem)
    {
        $postVars = $request->getPostVars();

        $tipoExame = [];

        // Instancia consultas
        $obConsulta = new ConsultaDao();

        // Instancia Exames solicitados
        $ExameSolicitados = new ExameSolicitadoDao();

        // busca a triagem da consulta
        $obTriagem = TriagemDao::getTriagemId($id_triagem);

        // Seleciona o paciente pelo id
        $obPaciente = PacienteDao::getPacienteId($obTriagem->id_paciente);
        $pacienteID = $obPaciente->id_paciente;

        // formata a idade do paciente
        $formataIdade = date("Y", strtotime($obTriagem->nascimento_paciente));
        $idade = date("Y") - $formataIdade;

        if (isset($_POST['salvar'])) {

            if (isset($_POST['motivo'],)) {
                $obConsulta->id_paciente = $pacienteID;
                $obConsulta->id_triagem = $id_triagem;
                $obConsulta->conduta_consulta = $_POST['conduta'];
                $obConsulta->motivo_consulta = $_POST['motivo'];
                $obConsulta->diagnostico_consulta = $_POST['diagnostico'];
                $obConsulta->observacao_consulta = $_POST['obs'];
                $idconsulta = $obConsulta->cadastrarConsulta();
            }

            if (isset($_POST['examesTipo'], $_POST['examesNome'], $_POST['examesEmergrncia'],)) {

                $tipoExame = $_POST['examesTipo'];
                $nomeExame = $postVars['examesNome'];
                $urgencias = $postVars['examesEmergrncia'];

                // Loop para inserir exame por exame
                for ($i = 0; $i < count($tipoExame); $i++) {

                    $ExameSolicitados->id_consulta = $idconsulta;

                    $ExameSolicitados->id_exame = $nomeExame[$i];
                    $ExameSolicitados->tipo_exame = $tipoExame[$i];
                    $ExameSolicitados->emergencia_exame = $urgencias[$i];
                    $ExameSolicitados->cadastrarExameSolicitado();
                }

                // Redireciona validaçao e gerar consulta
                $request->getRouter()->redirect('/consulta/validar/' . $idconsulta . '?msg=validar');
            } else {

                // Redireciona validaçao e gerar consulta 
                $request->getRouter()->redirect('/consulta/validar/' . $idconsulta . '?msg=validar');
            }
        }

        $content = View::render('consulta/formConsulta1', [

            'titulo' => 'Ficha de Consulta',
            'button' => 'Salvar',

            'exames' => self::getExamesSelect(),

            'id_paciente' => $pacienteID,
            'nome' => $obPaciente->nome_paciente,
            'imagem' => $obPaciente->imagem_paciente,
            'morada' => $obPaciente->morada_paciente,
            'telefone1' => $obPaciente->telefone1_paciente,
            'email' => $obPaciente->email_paciente,
            // 'data' => $obPaciente->nascimento_paciente,
            'data' => $idade,
            'genero' => $obPaciente->genero_paciente,

            'peso' => $obTriagem->peso_triagem,
            'temperatura' => $obTriagem->temperatura_triagem,
            'cardiaca' => $obTriagem->frequencia_cardiaca_triagem,
            'frequencia' => $obTriagem->frequencia_respiratorio_triagem,
            'saturacao' => $obTriagem->Saturacao_oxigenio_triagem,
            'pressao' => $obTriagem->pressao_arterial_triagem,
            'observacao' => $obTriagem->observacao_triagem,

            'diagnostico' => '',
            'obs' => '',
            'motivo' => '',
            'conduta' => '',

        ]);

        return parent::getPage('Ficha - consulta', $content);
    }

    // Metodo para apresentar a tela de validação da consulta 
    public static function getValidarConsulta($request, $id_consulta)
    {
        $obConsultaRealizada = ConsultaDao::getConsultaRelizada($id_consulta);

        // obtem o id da triagem
        $idTriagem = $obConsultaRealizada->id_triagem;
        //Instancia da triagem
        $triagemRegistrado = TriagemDao::getTriagemRegistradoId($idTriagem);

        $content = View::render('consulta/formConfirmaConsulta', [

            "msg" => self::exibeMensagem($request),

            "buttonValidar" => "Salvar e aguardar resultados",
            "buttonFinalizar" => "Finalizar consulta",
            "buttoncancelar" => "Anular consulta",

            // dados do paciente
            'id_paciente' => $obConsultaRealizada->id_paciente,
            'nome' => $obConsultaRealizada->nome_paciente,
            'genero' => $obConsultaRealizada->genero_paciente,
            'ano' => !empty($obConsultaRealizada->nascimento_paciente) ? (date('Y') - date('Y', strtotime($obConsultaRealizada->nascimento_paciente))) : "Indefinido",
            'bilhete' => !empty($obConsultaRealizada->bilhete_paciente) ? $obConsultaRealizada->bilhete_paciente : "indefinido",
            'telefone' => !empty($obConsultaRealizada->telefone1_paciente) ? $obConsultaRealizada->telefone1_paciente : "indefinido",
            'morada' => !empty($obConsultaRealizada->morada_paciente) ? $obConsultaRealizada->morada_paciente : "indefinido",

            // dados da consulta
            'id_consulta' => $obConsultaRealizada->id_consulta,
            'motivo' => !empty($obConsultaRealizada->motivo_consulta) ? $obConsultaRealizada->motivo_consulta : "indefinido",
            'conduta' => !empty($obConsultaRealizada->conduta_consulta) ? $obConsultaRealizada->conduta_consulta : "indefinido",
            'diagnostico' => !empty($obConsultaRealizada->diagnostico_consulta) ? $obConsultaRealizada->diagnostico_consulta : "indefinido",
            'obs' => !empty($obConsultaRealizada->observacao_consulta) ? $obConsultaRealizada->observacao_consulta : "indefinido",
            'retorno' => !empty($obConsultaRealizada->retorno_consulta) ? $obConsultaRealizada->retorno_consulta : "indefinido",
            'data' => !empty($obConsultaRealizada->criado_consulta) ? (date('d-m-Y', strtotime($obConsultaRealizada->criado_consulta))) : "indefinido",

            // dados da triagem
            'id_triagem' => $triagemRegistrado->id_triagem,
            'peso' =>  !empty($triagemRegistrado->temperatura_triagem) ? $triagemRegistrado->temperatura_triagem : "indefinido",
            'temperatura' =>  !empty($triagemRegistrado->temperatura_triagem) ? $triagemRegistrado->temperatura_triagem : "indefinido",
            'pressao' =>  !empty($triagemRegistrado->pressao_arterial_triagem) ? $triagemRegistrado->pressao_arterial_triagem : "indefinido",
            'cardiaca' =>  !empty($triagemRegistrado->frequencia_cardiaca_triagem) ? $triagemRegistrado->frequencia_cardiaca_triagem : "indefinido",
            'respiratorio' =>  !empty($triagemRegistrado->frequencia_respiratorio_triagem) ? $triagemRegistrado->frequencia_respiratorio_triagem : "indefinido",
            'saturacao' =>  !empty($triagemRegistrado->Saturacao_oxigenio_triagem) ? $triagemRegistrado->Saturacao_oxigenio_triagem : "indefinido",
            'observação' =>  !empty($triagemRegistrado->observacao_triagem) ? $triagemRegistrado->observacao_triagem : "indefinido",

            "receita" => self::getConsultaReceita($id_consulta),

            "exames" => self::getConsultaExame($id_consulta)

        ]);
        return parent::getPage('Validação da consulta', $content);
    }

    // Metodo para apresentar a tela de validação da consulta 
    public static function setValidarConsulta($request, $id_consulta)
    {
        $obConsulta = ConsultaDao::getConsulta($id_consulta);

        // Busca a pacinte  da consulta por id
        $obPaciente = PacienteDao::getPacienteId($obConsulta->id_paciente);

        // Verifica se foi finalizado
        if (isset($_POST['finalizar'])) {
            $obConsulta->finalizarConsulta();

            if ($obConsulta->estado_consulta == "Finalizada") {
                $obPaciente->atualizarEstado("Em tratamento");
            }

            // Redireciona ao consultorio
            $request->getRouter()->redirect('/consulta?msg=cadastrado');
        }

        // Verifica se foi validada
        if (isset($_POST['validar'])) {

            $obConsulta->estadoConsulta("Exames pendentes");
            if ($obConsulta->estado_consulta == "Exames pendentes") {
                $obPaciente->atualizarEstado("Em observação");
            }

            // Redireciona ao consultorio
            $request->getRouter()->redirect('/consulta?msg=cadastrado');
        }
    }

    // Metodo que apresenta os pacientes aspera da consulta
    private static function getConsultaExame($id_consulta)
    {
        $item2 = '';
        $idTriagem = '';
        $tabela = '';

        $quantidadeExame = ExameSolicitadoDao::quantidadeExameSolicitado($id_consulta, null, null, 'COUNT(*) as total')->fetchObject(ExameSolicitadoDao::class);
        $totalExame = $quantidadeExame->total;

        $resultadoExame = ExameSolicitadoDao::listarExameSolicitadoValido($id_consulta);
        while ($obExameSolicitado2 = $resultadoExame->fetchObject(ExameSolicitadoDao::class)) {

            $item2 .= View::render('consulta/itemConsulta/listarExameConsulta', [
                'tipo' => $obExameSolicitado2->tipo_exame,
                'exame' => $obExameSolicitado2->nome_exame,
                'emergencia' => $obExameSolicitado2->emergencia_exame,
                'estado' => $obExameSolicitado2->estado_exame_solicitado,
            ]);

            // Busca os id necessarios para link da imprissão 
            $idConsulta = $obExameSolicitado2->id_consulta;
            $idExameSolicitado = $obExameSolicitado2->id_exame_solicitado;
        }

        if ((int)$totalExame == 0) {
            return $tabela = strlen($tabela) ? $tabela :
                '<ul>
                     <li class="font-normal center"> Sem exame adicionada há consulta </li>
                </ul>';
            exit;
        } else {

            $tabela .= View::render('consulta/itemConsulta/tabelaExame', [
                'itemExames' => $item2,
                'id_consulta' => $idConsulta,
                'id_exame_solicitado' => $idExameSolicitado,
            ]);
        }
        return $tabela;
    }

    // Metodo que apresenta os pacientes aspera da consulta
    private static function getConsultaReceita($id_consulta)
    {
        $item = '';

        $tabela = '';

        $resultado = TriagemDao::listarTriagemFeita('risco_triagem');

        while ($obPacientesEspera = $resultado->fetchObject(TriagemDao::class)) {
            $item .= View::render('consulta/itemConsulta/listarReceitaConsulta', []);
        }

        //quantidade total
        //$quantidadetotal = TriagemDao::listarTriagemFeita('risco_triagem', null, 'COUNT(*) as quantidade');
        if (false) {

            $tabela .= View::render('consulta/itemConsulta/tabelaReceita', [
                'iteMedicamento' => $item
            ]);
        } else {

            return $tabela = strlen($tabela) ? $tabela :
                '<ul>
                     <li class="font-normal center"> Consulta sem prescrição adicionada</li>
                </ul>';
        }

        return $tabela;
    }






    /* Metodo que marca a consulta
    public static function getMarcarConsulta($request, $id_paciente)
    {
        $content = View::render('consulta/formMarcarConsulta', [
            'titulo' => 'Marcação de consulta',
            'button' => 'Salvar',
            'dia' => '',
            'hora' => '',
            'obs' => '',
            'valor' => '',
            'tempo' => '',
        ]);
        return parent::getPage('Marcação de consulta', $content);
    }
    // Metodo que marca a consulta
    public static function setMarcarConsulta($request, $id_paciente)
    {
        //$obConsultorio = new ConsultorioDao;

        if (isset($_POST['salvar'])) {

            // $obZona->zona = $_POST['zona'];

            // Redireciona validaçao e gerar consulta
            $request->getRouter()->redirect('/consulta/validar?msg=cadastrado');
        }

        $content = View::render('consulta/formConsulta2', [
            'titulo' => 'Ficha de Consulta',
            'nome' => '',
            'button' => 'Salvar',
            'diagnostico' => '',
            'obs' => '',
            'motivo' => '',

        ]);
        return parent::getPage('Ficha - consulta', $content);
    }
    */
}
