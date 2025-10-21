<?php

namespace App\Controller\Pages;

use \App\Utils\View;

use \App\Model\Entity\FuncionarioDao;
use \App\Utils\Pagination;


use \App\Controller\Mensagem\Mensagem;


class Configuracao extends Page
{


    // Método para apresenatar os registos dos Funcionario
    private static function getFuncionario($request, &$obPagination)
    {

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_funcionario LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = FuncionarioDao::listarFuncionario($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 11);

        $resultado = FuncionarioDao::listarFuncionario($where, 'nome_funcionario ', $obPagination->getLimit());


        while ($obFuncionario = $resultado->fetchObject(FuncionarioDao::class)) {
            $item .= View::render('configuracao/listarPermissao', [
                'id_funcionario' => $obFuncionario->id_funcionario,
                'imagem' => $obFuncionario->imagem_funcionario,
                'nome' => $obFuncionario->nome_funcionario,
                'genero' => $obFuncionario->genero_funcionario,
                'telefone' => $obFuncionario->telefone1_funcionario,
                'email' => $obFuncionario->email_funcionario,
                'cargo' => $obFuncionario->cargo_funcionario,
                'numero' => $obFuncionario->numeroordem_funcionario,
                'dataRegistro' => $obFuncionario->registrado
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

        return $item;
    }



    // Método que apresenta a tela do Funcionario
    public static function telaConfiguracao($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/configuracao', [
            'pesquisar' => $buscar,
            'item' => self::getFuncionario($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination),
            'active' => 'blue-grey darken-3 white-text',

        ]);
        return parent::getPage('Configuração', $content);
    }


    // Método que apresenta a tela do Funcionario
    public static function cadastrosBasico($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/item/cadastros_basico', [
            'pesquisar' => $buscar,
            'active' => 'blue-grey darken-3 white-text',
            'item' => self::getFuncionario($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Configuração-Cadastro básico', $content);
    }
}
