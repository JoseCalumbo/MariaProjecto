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
                return MensagemAdmin::msgSucesso('Consulta finalizada');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Exame Alterado com sucesso');
                break;
            case 'validar':
                return MensagemAdmin::msgAlerta('Consulta foi salva, mas é necessario validar ');
                break;
        } // fim do switch
    }

    // Metodo que apresenta os pacientes aspera da consulta PRINCIPAL
    private static function getConsultasEspera($request, &$obPagination)
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
        $quantidadetotal = TriagemDao::listarTriagemFeita($where, 'risco_triagem', null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = TriagemDao::listarTriagemFeita($where, 'risco_triagem', $obPagination->getLimit());

        while ($obPacientesEspera = $resultado->fetchObject(TriagemDao::class)) {

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

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($obPacientesEspera->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::render('consulta/listarConsulta', [
                'id_triagem' => $obPacientesEspera->id_triagem,
                'id_paciente' => $obPacientesEspera->id_paciente,
                'imagem' => $obPacientesEspera->imagem_paciente,
                'nome_paciente' => $obPacientesEspera->nome_paciente,
                'genero' => $obPacientesEspera->genero_paciente,
                'idade' => $idade,
                'estado' => $obPacientesEspera->estado_paciente,
                'perioridade' => $triagemAtender,
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
        $quantidadetotal = TriagemDao::listarTriagemFeita($where, 'risco_triagem', null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = TriagemDao::listarTriagemFeita($where, 'risco_triagem', $obPagination->getLimit());

        while ($obPacientesEspera = $resultado->fetchObject(TriagemDao::class)) {

            $atender =  $obPacientesEspera->risco_triagem;

            $item .= View::render('consulta/listarMeusPaciente', [
                'id_triagem' => $obPacientesEspera->id_triagem,
                'id_paciente' => $obPacientesEspera->id_paciente,
                'imagem' => $obPacientesEspera->imagem_paciente,
                'nome_paciente' => $obPacientesEspera->nome_paciente,
                'genero' => $obPacientesEspera->genero_paciente,
                'estado' => $obPacientesEspera->estado_paciente,
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
                                                    Sem registos de pacientes em espera.
                                                    </td>
                                                </tr>';
    }


    // Metodo que apresenta os pacientes agendados
    private static function getMinhaAgenda($request, &$obPagination)
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
                                                    Sem consultas marcadas.
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

    // Metodo que apresenta os pacientes agendados
    private static function getExameSolicitado($request, &$obPagination)
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
                                                    Sem exames solicitados concluido no momento.
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
            'pesquisar' => $buscar,

            'listarConsulta' => self::getConsultasEspera($request, $obPagination),

            'listarMinhaConsulta' => self::getMinhaConsulta($request, $obPagination),

            'listarMinhaAgenda' => self::getMinhaAgenda($request, $obPagination),

            'listarConsultaFinalizada' => self::getConsultaFinalizada($request, $obPagination),

            'listarExames' => self::getExameSolicitado($request, $obPagination),

            'paginacao' => parent::getPaginacao($request, $obPagination)
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

        $content = View::render('consulta/formConfirmaConsulta', [

            "button1" => "Validar consulta",
            "button2" => "Finalizar consulta",

            'nome' => $obConsultaRealizada->nome_paciente,
            'nome' => $obConsultaRealizada->nome_paciente,

            "msg" => self::exibeMensagem($request),
            "receita" => self::getConsultaReceita($id_consulta),
            "exames" => self::getConsultaExame($id_consulta)





        ]);
        return parent::getPage('Validação da consulta', $content);
    }

    // Metodo que apresenta os pacientes aspera da consulta
    private static function getConsultaExame($id_consulta)
    {
        $item2 = '';

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






    // Metodo que marca a consulta
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
}
