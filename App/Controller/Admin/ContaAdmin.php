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


class ContaAdmin extends PageAdmin
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

    // funcao para apresenatar os dados do user dados 
    private static function getUsuarioConta()
    {
        $item = '';

        // Busca o usuario logado no sistema
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        $item .= View::renderAdmin('conta/dadosConta', [
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'nascimento' => "",
            'email' => $obUsuario->email,
            'telefone' => $obUsuario->telefone,
            'nivel' => $obUsuario->nivel,
            'registro' => $obUsuario->criado
        ]);
        return $item;
    }

    // metodo que renderiza a tela  do usuario 
    public static function telaConta($request)
    {
        // Pega o usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        $content = View::renderAdmin('conta/conta', [
            'dadosconta' => self::getUsuarioConta(),
            'imagem' => $obUsuario->imagem,
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'active' => 'blue-grey darken-3 white-text',
            'msg' => self::exibeMensagem($request),
            'msgVazio' => ''
        ]);
        return parent::getPageAdmin('Admin - Conta Informaçao', $content);
    }

    /**
     * Metodo para editar os dados 
     *@param Request $request
     *@return string
     */
    public static function getEditarConta($request, $id_us)
    {
        // Pega o usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        $content = View::renderAdmin('conta/contaPerfil', [
            'msg' => '',
            'msgVazio' => '',
            'imagem' => $obUsuario->imagem,
            'id' => $obUsuario->id,
            'active' => 'blue-grey darken-3 white-text',
            'nome' => $obUsuario->nome
        ]);
        return parent::getPageAdmin('Admin - Personalização', $content);

    }


    // metodo que renderiza a tela alter senha
    public static function getTelaSeguranca($request, $erroMsg)
    {
        // Pega o id do usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];

        $obUsuario = AdmimUserDao::getAdminUserId($id);
        $postVars = $request->getPostVars();

        // post do form da alteracao 
        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::mensagemErro($erroMsg) : '';

        $content = View::renderAdmin('conta/contaSeguranca', [
            'senhaAntiga' => $senhaAntiga,
            'senhaNova' => $senhaNova,
            'senhaConf' => $senhaConfirmada,
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'active' => 'blue-grey darken-3 white-text',
            'msg' => $status,
            'msgVazio' => '',
            'imagem' => $obUsuario->imagem,
        ]);
        return parent::getPageAdmin('Admin Segurança', $content);
    }


    // metodo que renderiza a tela alter senha
    public static function getRegistrosConta($request, $erroMsg)
    {
        // Pega o id do usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];
        $obUsuario = AdmimUserDao::getAdminUserId($id);


        $status = !is_null($erroMsg) ? Mensagem::mensagemErro($erroMsg) : '';

        $content = View::renderAdmin('conta/ContaRegistro', [
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'active' => 'blue-grey darken-3 white-text',
            'msg' => $status,
            'msgVazio' => '',
            'imagem' => $obUsuario->imagem,
        ]);
        return parent::getPageAdmin('Usuario Alterar senha', $content);
    }

    // metodo que renderiza a tela alter senha
    public static function getTelaSeguranca1($request, $erroMsg)
    {
        // Pega o id do usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];

        $obUsuario = AdmimUserDao::getAdminUserId($id);
        $postVars = $request->getPostVars();

        // post do form da alteracao 
        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::mensagemErro($erroMsg) : '';

        $content = View::renderAdmin('conta/alterarsenha', [
            'senhaAntiga' => $senhaAntiga,
            'senhaNova' => $senhaNova,
            'senhaConf' => $senhaConfirmada,
            'msg' => $status,
            'msgVazio' => '',
            'imagem' => $obUsuario->imagem,
        ]);
        return parent::getPageAdmin('Usuario Alterar senha', $content);
    }



    //metodo post para alterar senha
    public static function setAlterarSenha($request, $id_us)
    {
        // Busca o usuario logado no sistema
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];

        $postVars = $request->getPostVars();

        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';

        $obUsuario = AdmimUserDao::getAdminUserId($id);

        // validacao da senha se corresponde
        if (!password_verify($senhaAntiga, $obUsuario->senha)) {
            return self::telaAlterarSenha($request, '<p class="black-text"> Erro! Senha Incorreta </p>');
            exit;
        }

        // validacao da confirmacao da senha
        if ($senhaNova !== $senhaConfirmada) {
            return self::telaAlterarSenha($request, '<p> Erro! As senhas não são iguais</p>');
            exit;
        }

        // valida os campos das senhas 
        if (isset($postVars['senhaAntiga'], $postVars['senhaNova'], $postVars['senhaConfirmada'])) {

            //faz a alteracao da senha
            $obUsuario->senha = password_hash($postVars['senhaNova'], PASSWORD_DEFAULT);
            $obUsuario->atualizarSenha();
        }

        $request->getRouter()->redirect('/conta?msg=senhaEditada');
    }

    // metodo para alterar a imagem do usuario
    public static function alterarImagem($request)
    {

        $postVars = $request->getPostVars();

        // obtem o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $id_us = $usuarioLogado['id_us'];

        // instancia do user
        $obUsuario = UsuarioDao::getUsuarioId($id_us);

        // instancia da class que carrega a imagem
        $obUpload = new Upload($_FILES['imagem']) ?? '';

        if (isset($postVars['salvar'])) {

            // verifica se foi carregado uma imagem 
            if ($_FILES['imagem']['error'] == 4) {
                $content = View::render('conta/conta', [
                    'msg' => '',
                    //exibe os dados do user na pagina
                    'dadosconta' => self::getUsuarioConta(),
                    // exibe o menu do user na pagina
                    'menuconta' => self::getUsuarioMenu(),
                    // coloca a class para manter o modal de alter a foto
                    'blocks' => 'block',
                    'imagem' => $obUsuario->imagem_us,
                    //exibe a mensagem de nao carregar uma foto
                    'msgVazio' => '<p class="div-conta-inf red center">Não selecionaste nenhuma imagem nova</p>',
                ]);
                return parent::getPage('Usuario Alterar senha', $content);
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obUsuario->imagem_us = $obUpload->getBaseName();
            $obUsuario->atualizarImagem();

            if ($sucess) {
                $request->getRouter()->redirect('/conta?msg=imagemAlterado');
                exit;
            }
        }
    }

    // metodo que renderiza a tela de controle 
    public static function getControleConta($request, $erroMsg)
    {
        // Pega o id do usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];

        $obUsuario = AdmimUserDao::getAdminUserId($id);

        $status = !is_null($erroMsg) ? Mensagem::mensagemErro($erroMsg) : '';

        $content = View::renderAdmin('conta/contaControle', [
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'active' => 'blue-grey darken-3 white-text',
            'msg' => $status,
            'msgVazio' => '',
            'imagem' => $obUsuario->imagem,
        ]);
        return parent::getPageAdmin('Admin- Controle conta', $content);
    }


    // metodo que renderiza a tela alter senha
    public static function setApagarConta($request, $erroMsg)
    {
        // Pega o id do usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];

        $obUsuario = AdmimUserDao::getAdminUserId($id);

        $postVars = $request->getPostVars();

        // post do form da alteracao 
        $senhaAntiga = $postVars['senhaAntiga'] ?? '';

        $obUsuario->apagar();

        //Redireciona a tela de login
        $request->getRouter()->redirect('/admin/login');

    }

}