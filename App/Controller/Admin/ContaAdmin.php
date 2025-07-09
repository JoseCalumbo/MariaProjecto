<?php

namespace App\Controller\Admin;

use App\Controller\Mensagem\MensagemAdmin;
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
                return MensagemAdmin::msgSucesso('Senha Alterado com sucesso');
                break;
            case 'senhaNaoEditada':
                return MensagemAdmin::msgAlerta('Alerta Senha não alterarda');
                break;
            case 'senhaErrada':
                return MensagemAdmin::msgErro('Erro senha digitada invalida, senha não alterarda');
                break;
            case 'imagem-Nao-carregada':
                return MensagemAdmin::msgAlerta('Imagem não carregada tenta novamente');
                break;
            case 'imagemAlterado':
                return MensagemAdmin::msgSucesso('Imagem Alterada com sucesso');
                break;
            case 'imagemNaoAlterada':
                return MensagemAdmin::msgErro('Erro Imagem não Alterada, Tenta de novamente');
                break;
            case 'contaeditada':
                return MensagemAdmin::msgSucesso('Conta editada com sucesso');
                break;
            case 'contaNaoEditada':
                return MensagemAdmin::msgErro('Conta não editada');
                break;
            case 'confirma':
                return MensagemAdmin::msgAlerta('Clica em Confirmar antes de processeguir');
                break;
            case 'NaoDeletado':
                return MensagemAdmin::msgErro('Erro: Conta Não  Apagada, Tenta novamente ou consulta o administrador');
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
            'genero' => $obUsuario->genero,
            'email' => $obUsuario->email,
            'telefone' => $obUsuario->telefone,
            'nivel' => $obUsuario->nivel,
            'morada' => $obUsuario->morada,
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

    /** Metodo para editar os dados 
     *@param Request $request
     *@return string
     */
    public static function getEditarConta($request)
    {
        // Pega o usuario logado
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $id = $usuarioLogado['id'];

        // busca o usuario po id
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        $content = View::renderAdmin('conta/contaPerfil', [
            'msg' => '',
            'nome' => $obUsuario->nome,
            'email' => $obUsuario->email,
            'telefone' => $obUsuario->telefone,
            'imagem' => $obUsuario->imagem,
            'morada' => $obUsuario->morada,
            'masculino' => $obUsuario->genero == 'Masculino' ? 'selected' : '',
            'feminino' => $obUsuario->genero == 'Feminino' ? 'selected' : '',
            'id' => $obUsuario->id,
            'active' => 'blue-grey darken-3 white-text',
            'msg1' => self::exibeMensagem($request),

        ]);
        return parent::getPageAdmin('Admin - Personalização', $content);

    }


    // metodo que renderiza a tela de Segurança controle
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
            'msg1' => self::exibeMensagem($request),
        ]);
        return parent::getPageAdmin('Admin Segurança', $content);
    }


    // metodo que renderiza a tela de registro
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
        return parent::getPageAdmin('admin- Registro', $content);
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
            'msg1' => self::exibeMensagem($request),

            'msgVazio' => '',
            'imagem' => $obUsuario->imagem,
        ]);
        return parent::getPageAdmin('Admin- Controle conta', $content);
    }


    //metodo post para alterar senha
    public static function setAlterarSenha($request, $id)
    {
        // Busca o usuario logado no sistema
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        //$id = $usuarioLogado['id'];

        $obUsuario = AdmimUserDao::getAdminUserId($id);

        // Guarda os inputs post do formularios
        $postVars = $request->getPostVars();

        //Pega o valor do botão cancelar
        $cancelou = $postVars['cancelar'] ?? '';

        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';

        if ($cancelou == "cancelar") {
            $request->getRouter()->redirect('/admin/seguranca');
            exit;
        }

        // valida os campos das senhas 
        if (isset($postVars['senhaAntiga'], $postVars['senhaNova'], $postVars['senhaConfirmada'])) {

            // validacao da senha se corresponde
            if (!password_verify($senhaAntiga, $obUsuario->senha)) {
                $request->getRouter()->redirect('/admin/seguranca?msg=senhaErrada');
                // return self::getTelaSeguranca($request, '<p class="black-text"> Erro! Senha Incorreta </p>');
            }

            // validacao da confirmacao da senha
            if ($senhaNova !== $senhaConfirmada) {
                // Redereciona para a pagina de segurança com msg sucesso
                $request->getRouter()->redirect('/admin/seguranca?msg=senhaNaoEditada');
                // return self::getTelaSeguranca($request, '<p> Erro! As senhas não são iguais</p>');
            }

            //faz a alteracao da senha
            $obUsuario->senha = password_hash($postVars['senhaNova'], PASSWORD_DEFAULT);
            $obUsuario->atualizarSenha();
            // Redereciona para a pagina de segurança com msg sucesso
            $request->getRouter()->redirect('/admin/seguranca?msg=senhaEditada');

        }

    }


    // metodo para alterar a imagem do usuario
    public static function alterarImagem($request, $id)
    {
        $postVars = $request->getPostVars();
        //Pega o valor do botão cancelar
        $cancelou = $postVars['cancelar'] ?? '';

        if ($cancelou == "cancelar") {
            $request->getRouter()->redirect('/conta/perfil');
            exit;
        }

        // instancia do user
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        // instancia da class que carrega a imagem
        $obUpload = new Upload($_FILES['imagem']) ?? '';

        if (isset($postVars['salvar'])) {

            // verifica se foi carregado uma imagem 
            if ($_FILES['imagem']['error'] == 4) {
                $request->getRouter()->redirect('/conta/perfil?msg=imagem-Nao-carregada');
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obUsuario->imagem = $obUpload->getBaseName();
            $obUsuario->atualizarImagem();

            if ($sucess) {
                $request->getRouter()->redirect('/conta/perfil?msg=imagemAlterado');
                exit;
            } else {
                $request->getRouter()->redirect('/conta/perfil?msg=imagemNaoAlterada');

            }
        }

    }

    // metodo para alterar dados user
    public static function setAlterarDados($request, $id)
    {
        $postVars = $request->getPostVars();
        //Pega o valor do botão cancelar
        $cancelou = $postVars['cancelar'] ?? '';

        if ($cancelou == "cancelar") {
            $request->getRouter()->redirect('/conta/perfil');
            exit;
        }

        // instancia do user
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        if (isset($postVars['salvar'])) {

            $obUsuario->nome = $_POST['nome'] ?? $obUsuario->nome;
            $obUsuario->genero = $_POST['genero'] ?? $obUsuario->genero;
            $obUsuario->email = $_POST['email'] ?? $obUsuario->email;
            $obUsuario->telefone = $_POST['telefone'] ?? $obUsuario->telefone;
            $obUsuario->morada = $_POST['morada'] ?? $obUsuario->morada;
            $obUsuario->atualizar();
            $request->getRouter()->redirect('/conta/perfil?msg=contaeditada');
            exit;
        } else {
            $request->getRouter()->redirect('/conta/perfil?msg=contaNaoEditada');

        }

    }

    // metodo que renderiza a tela alter senha
    public static function setApagarConta($request, $id)
    {

        $postVars = $request->getPostVars();

        $confirmo = $_POST['confirmo'] ?? "";

        //Pega o valor do botão cancelar
        $cancelou = $postVars['cancelar'] ?? '';

        if ($cancelou == "cancelar") {
            $request->getRouter()->redirect('/admin/controle');
            exit;
        }

        $obUsuario = AdmimUserDao::getAdminUserId($id);

        if (isset($postVars['apagar'])) {

            // Verifica se o usuario confirmou o operaçao
            if (!$confirmo == "on") {
                $request->getRouter()->redirect('/admin/controle?msg=confirma');
                exit;
            }

            $obUsuario->apagar();

            //Redireciona a tela de login
            $request->getRouter()->redirect('/admin/logout');

        } else {
            $request->getRouter()->redirect('/admin/controle?msg=NaoDeletado');

        }
    }

}