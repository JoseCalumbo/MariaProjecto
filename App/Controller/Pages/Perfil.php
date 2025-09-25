<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\FuncionarioDao;
use \App\Utils\Pagination;
use \App\Controller\Mensagem\Mensagem;

Class Perfil extends Page {

    // exibe a messagem de operacao
    public static function exibeMensagem($request){
        $queryParam = $request->getQueryParams();
        
        if(!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Vendedor Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Vendedor Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Vendedor Apagdo com sucesso');
                break;
        }// fim do switch
    }

        // Método para apresenatar os registos dos Funcionario
    private static function getPerfil($request, &$obPagination)
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
    public static function getPerfilAcesso($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/perfil', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getPerfil($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Perfil de Acesso', $content);
    }

}