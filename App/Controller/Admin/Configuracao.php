<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\SessionAdmin;
use \App\Utils\Upload;
use \App\Http\Request;
use \App\Model\Entity\AdmimUserDao;
use \App\Controller\Mensagem\MensagemAdmin;



class Configuracao extends PageAdmin
{

    /** Metodo para exibir  a mensagem 
     *@param Request $request
     *@return string
     */
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg']))
            return '';
        switch ($queryParam['msg']) {
            case 'cadastrado':
                return MensagemAdmin::msgSucesso('Usuario Cadastrado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Usuario Alterado com sucesso');
                break;
            case 'apagado':
                return MensagemAdmin::msgSucesso('Usuario Apagdo com sucesso');
                break;
            case 'nivel':
                return MensagemAdmin::msgAlerta('Imponssivel Apagar o tua conta deste modo');
                break;
            case 'confirma':
                return MensagemAdmin::msgAlerta('Confirma a tua ação antes de Apagar');
                break;
        }// fim do switch
        return true;
    }

    // Metodo para apresenatar os registos dos dados 
    private static function getUsuario($request, &$obPagination)
    {

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = AdmimUserDao::listarUsuario($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = AdmimUserDao::listarUsuario($where, 'nome', $obPagination->getLimit());

        while ($obUsuario = $resultado->fetchObject(AdmimUserDao::class)) {

            $item .= View::renderAdmin('usuario/listarUsuario', [
                'id' => $obUsuario->id,
                'imagem' => $obUsuario->imagem,
                'nome' => $obUsuario->nome,
                'email' => $obUsuario->email,
                'telefone' => $obUsuario->telefone,
                'cargo' => $obUsuario->nivel,
                'Registro' => $obUsuario->criado
            ]);
        }

        // Verifica se foi realizada uma pesquisa
        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::renderAdmin('pesquisar/box_resultado', [
                'pesquisa' => $buscar,
                'item' => $item,
                'numResultado' => $quantidadetotal,
            ]);
        }

        return $item;
    }

    // Metodo que apresenta a tela de usuario
    public static function getTelaDefinicao($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::renderAdmin('configuracao/configuracao', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getUsuario($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);

        return parent::getPageAdmin('Admin - Painel Usuario', $content);
    }

}



