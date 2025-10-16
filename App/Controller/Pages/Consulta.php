<?php

namespace App\Controller\Pages;

use App\Model\Entity\ConsultorioDao;
use \App\Utils\Pagination;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\ZonaDao;
use \App\Model\Entity\VendedorDao;
use \App\Utils\View;


class Consulta extends Page
{

    // Metodo que apresenta os pacientes aspera da consulta
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
        $quantidadetotal = ConsultorioDao::listarTriagemFeita($where, 'risco_triagem', null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 6);

        $resultado = ConsultorioDao::listarTriagemFeita($where, 'risco_triagem', $obPagination->getLimit());

        while ($obPacientesEspera = $resultado->fetchObject(ConsultorioDao::class)) {

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
                'id_paciente' => $obPacientesEspera->id_triagem,
                'imagem' => $obPacientesEspera->imagem_paciente,
                'nome_paciente' => $obPacientesEspera->nome_paciente,
                'genero' => $obPacientesEspera->genero_paciente,
                'idade' => $idade,
                'perioridade' => $triagemAtender,
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

    // Metodo para apresentar a tela do consultorio
    public static function telaConsulta($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('consulta/Consultorio', [
            'pesquisar' => $buscar,
            'listarConsulta' => self::getConsultasEspera($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Consultorio', $content);
    }

    // Metodo que inicia as consultas
    public static function iniciarConsulta($request, $id_paciente)
    {
        $obZona = new ZonaDao;

        if (isset($_POST['a'], $_POST['a'], $_POST['a'], $_POST['a'])) {

            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];

            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=cadastrado');
        }

        $content = View::render('consulta/formConsulta2', [
            'titulo' => 'Ficha de Consulta',
            'nome' => 'Ana luis',
            'button' => 'Salvar',
            'zona' => '',
            'fim' => '',
            'inicio' => '',
            //'paciente'=>self::getPaciente(),
            'mercado' => ''

        ]);
        return parent::getPage('Cadastrar nova Zona', $content);
    }

    // Metodo para apresentar a tela Consulta 
    public static function comfirmarConsulta($request)
    {

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('consulta/formConfirmaConsulta', [
            'pesquisar' => $buscar,
            'listarZona' => self::getConsultasEspera($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Consulta', $content);
    }

    // Metodo que cadastra consultas
    public static function cadastrarConsulta1($request)
    {

        $obZona = new ZonaDao;

        if (isset($_POST['zona'], $_POST['inicio'], $_POST['fim'], $_POST['mercado'])) {

            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];
            $obZona->cadastrarZona();
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=cadastrado');
        }

        $content = View::render('consulta/formConsulta', [
            'titulo' => 'Registrar Nova Consultas',
            'button' => 'Salvar',
            'zona' => '',
            'fim' => '',
            'inicio' => '',
            //'paciente'=>self::getPaciente(),
            'mercado' => ''

        ]);
        return parent::getPage('Cadastrar nova Zona', $content);
    }


       //metodo responsavel para pegar os paciente
    public static function getPaciente()
    {
        $paciente = '';
        $paciente = VendedorDao::listarVendedor();
        while ($obpaciente = $paciente->fetchObject(VendedorDao::class)) {
            $paciente .= View::render('item/paciente', [
                'nome' => $obpaciente->nome,
                'value' => $obpaciente->id
            ]);
        }
        return $paciente;
    }
}
