<?php

namespace App\Controller\Pages;

use \App\Utils\Pagination;
use \App\Model\Entity\ZonaDao;
use \App\Model\Entity\PacienteDao;
use \App\Model\Entity\ConsultaDao;
use \App\Model\Entity\MarcarConsultaDao;
use \App\Utils\View;


class Consulta extends Page
{

    // Metodo para fazer pesquisa 
    private static function getBusca($request, &$obPagination)
    {

        $queryParam = $request->getQueryParams();

        //$obPagination = new Pagination(null, null, null);

        // Var que retorna o conteudo
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'zona LIKE "%' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = ZonaDao::listarZona($where, 'zona', null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 9);

        $resultado = ZonaDao::listarZona($where, 'zona', $obPagination->getLimit());

        while ($obZona = $resultado->fetchObject(ZonaDao::class)) {

            $item .= View::render('consulta/listarConsultaDiaria', [
                'id_zona' => $obZona->id_zona,
                'zona' => $obZona->zona,
                'iniciovenda' => $obZona->inicio_venda,
                'fimvenda' => $obZona->fim_venda,
                'mercado' => $obZona->mercado
            ]);
        }

        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::render('pesquisar/item', [
                'pesquisa' => $buscar,
                'resultados' => $item,
                'numResultado' => $quantidadetotal,
            ]);
        }

        return $item;
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

            $item .= View::render('consulta/listarPacientesEspera', [
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

    // Metodo que apresenta as consultas marcadas
    private static function getConsultasMarcas($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_fornecedor LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela exames
        $quantidadetotal = MarcarConsultaDao::listarConsultaMarcada($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        $resultado = MarcarConsultaDao::listarConsultaMarcada($where, 'data_consulta ', $obPagination->getLimit());

        while ($obFornecedors = $resultado->fetchObject(MarcarConsultaDao::class)) {

            $item .= View::render('consulta/listarConsultaMarcada', [
                'id_marcacao' => $obFornecedors->id_marcacao,
                'imagem' => $obFornecedors->id_marcacao,
                'nomePaciente' => $obFornecedors->id_paciente,
                'contacto' => $obFornecedors->id_medico,
                'consulta' => $obFornecedors->id_especialidade,
                'especialidade' => $obFornecedors->estado_marcacao,
                'data' => $obFornecedors->data_consulta,
                'hora' => $obFornecedors->hora_consulta,
                'medico' => $obFornecedors->id_medico,
                'dataRegistro' => date('d-m-Y', strtotime($obFornecedors->data_registro)),
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
                                                   <td colspan="10" class="center-align no-border" style="vertical-align: middle; height:120px; font-size:18px">
                                                    Sem nenhuma consulta marcada.
                                                    </td>
                                                </tr>';
    }

    // Metodo para apresentar a tela Consulta Diaria 
    public static function telaPacienteEspera($request)
    {

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('consulta/consultaDiaria', [
            'pesquisar' => $buscar,
            'pesquisar' => $buscar,
            'listarPacienteEspera' => self::getPacienteEspera($request, $obPagination),
            // 'paginacao' => parent::getPaginacao($request, $obPagination)
            'paginacao' => ""
        ]);
        return parent::getPage('Painel Consultas Diaria', $content);
    }

    // Metodo que Atende o Paciente
    public static function atenderConsulta1($request, $id_zona)
    {
        $i = 5;

        $obZona = ZonaDao::getZona($id_zona);

        if (isset($_POST['a'], $_POST['a'], $_POST['a'], $_POST['a'])) {

            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];
            //$obZona->AtualizarZona();

            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/consulta/comfirmar/{id_consulta}');
        }
        $content = View::render('consulta/formConsulta', [
            'titulo' => 'Atender Consulta',
            'nome' => 'Dário Miguel Andre',
            'button' => 'Editar',
            'button-salvar' => 'Salvar',
            'zona' => $obZona->zona,
            'fim' => $obZona->fim_venda,
            'inicio' => $obZona->inicio_venda,
            'mercado' => $obZona->mercado
        ]);
        return parent::getPage('Atender Zona', $content);
    }

    // Metodo que cadastra consultas
    public static function cadastrarNovaConsulta($request)
    {

        $obZona = new ZonaDao;


        if (isset($_POST['a'], $_POST['a'], $_POST['a'], $_POST['a'])) {

            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];
            //  $obZona->cadastrarZona();
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/consulta/comfirmar/{id_consulta}');
        }

        $content = View::render('consulta/formConsulta', [
            'titulo' => 'Atender Consulta',
            'nome' => 'Dário Miguel Andre',
            'button-salvar' => 'Salvar',
            'button-receitar' => 'Gerar Prescrição',
            'zona' => '',
            'fim' => '',
            'inicio' => '',
            //'paciente'=>self::getPaciente(),
            'id_pac' => $obZona->id_zona

        ]);
        return parent::getPage('Cadastrar nova Consulta', $content);
    }

    // Metodo que marca a consulta
    public static function consultaMarcadas($request)
    {
        $content = View::render('consulta/consultaMarcadas', [
            'titulo' => 'Marcação de consulta',
            'button' => 'Salvar',

            'msg' => '',
            'item' => self::getConsultasMarcas($request, $obPagination),
            'paginacao' => '',

            'dia' => '',
            'hora' => '',
            'obs' => '',
            'valor' => '',
            'tempo' => '',
        ]);
        return parent::getPage('Consultas Marcada', $content);
    }

    // Metodo que marca a consulta
    public static function getMarcarConsulta($request, $id_paciente)
    {
        // Seleciona o paciente pelo ID
        $obPaciente = PacienteDao::getPacienteId($id_paciente);
        $content = View::render('consulta/MarcarConsulta', [

            'titulo' => 'Marcação de consulta',
            'button' => 'Salvar',
            'id_paciente' => $obPaciente->id_paciente,
            'nome' => $obPaciente->nome_paciente,
            'telefone' => $obPaciente->telefone1_paciente,
            'email' => $obPaciente->email_paciente,

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

        $content = View::render('consultorio/formConsulta2', [
            'titulo' => 'Ficha de Consulta',
            'nome' => '',
            'button' => 'Salvar',
            'diagnostico' => '',
            'obs' => '',
            'motivo' => '',

        ]);
        return parent::getPage('Ficha - consulta', $content);
    }

    public static function horario(){
        echo "E aqui é php ";
    }
}
