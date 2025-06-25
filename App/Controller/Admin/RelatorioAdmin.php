<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\AdmimUserDao;
use \App\Utils\Session;
use \App\Utils\SessionAdmin;
use \App\Http\Request;
use \App\Controller\Mensagem\Mensagem;
use \App\Utils\Upload;


class RelatorioAdmin extends PageAdmin
{

    /**
     * Metodo para exibir  a mensagem 
     *@param Request $request
     *@return string
     */
    public static function exibeMensagem($request)
    {

        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg']))
            return '';

        switch ($queryParam['msg']) {
            case 'senhaEditada':
                return Mensagem::msgSucesso('Senha Alterado com sucesso');
                break;
            case 'imagemAlterado':
                return Mensagem::msgSucesso('Imagem Alterado com sucesso');
                break;
            case 'contaeditada':
                return Mensagem::msgSucesso('Conta editada com sucesso');
                break;
        }// fim do switch

        return true;
    }

    // metodo que renderiza a tela  do usuario 
    public static function getTelaRelatorio($request)
    {
        // Pega o usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        $content = View::renderAdmin('relatorio/relatorio', [

            'imagem' => $obUsuario->imagem,
            'msg' => self::exibeMensagem($request),
            'msgVazio' => ''
        ]);
        return parent::getPageAdmin('Painel Usuario', $content);
    }

  

}