<?php

namespace App\Controller\Pages;

use \App\Utils\Pagination;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\ZonaDao; 
use \App\Model\Entity\VendedorDao;
use \App\Utils\View;


class ConsultaDiaria extends Page
{

    // Metodo para fazer pesquisa 
    private static function getBusca($request, &$obPagination){

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

    // Metodo para apresentar a tela Consulta Diaria 
    public static function telaConsultaDiaria($request)
    {

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('consulta/consultaDiaria', [
            'pesquisar' => $buscar,
            'listarZona' => self::getBusca($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Consultas Diaria', $content);
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

    // Metodo que Atende o Paciente
    public static function atenderConsulta($request,$id_zona)
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

    // Metodo que apagar Zona
    public static function apagarZona($request, $id_zona)
    {

        $obZona = ZonaDao::getZona($id_zona);

        if (isset($_POST['apagar'])) {

            $obZona->apagarZona();

            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=apagado');
        }

        $content = View::render('zonas/deletaZona', [
            'titulo' => 'Apagar Zona',
            'button' => 'Sim',
            'zona' => $obZona->zona,
            'id_zona' => $obZona->id_zona,
            'mercado' => $obZona->mercado
        ]);
        return parent::getPage('Apagar Zona', $content);
    }
}
