<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Http\Request;
use \App\Model\Entity\AdmimUserDao;
use \App\Controller\Mensagem\Mensagem;

class SiginAdmin extends PageAdmin
{
    // Função que apresenta a tela de usuario
    public static function getTelaSigin($request, $erroMsg = null)
    {
        $postVars = $request->getPostVars();
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::renderAdmin('login/sign', [
            'nome' => $nome ?? '',
            'email' => $email ?? '',
            'senha' => $senha,
            'msg' => $status,
        ]);
        return parent::getPageAdminLogin('Admin - Criar conta  ', $content, null);
    }

    /** Função para logar o usuario
     * @param Request  
     */
    public static function setSignAdmin($request)
    {
        $obAdmimUser = new AdmimUserDao;

        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';
        $confirmaSenha = $postVars['ConfirmaSenha'] ?? '';


        // verifica se as senhas são iguais
        if ($senha != $confirmaSenha) {
            return self::getTelaSigin($request, '<p>Erro na confirmação de senha,digita novamente</p>');
        }

        // verifica se o email ja foi cadastrado por outro usuario
        $obAdmimUser1 = AdmimUserDao::getUsuarioEmail($email);

        if (!$obAdmimUser1 instanceof AdmimUserDao) {
            return self::getTelaSigin($request, '<p>Erro este email já esta ser utilizado</p>');
        }

        if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['ConfirmaSenha'])) {

            $obAdmimUser->nome = $nome;
            $obAdmimUser->email = $email;
            $obAdmimUser->senha = password_hash($senha, PASSWORD_DEFAULT);
            $obAdmimUser->nivel = 'Administrador';
            $obAdmimUser->imagem = 'anonimo.png';
            $obAdmimUser->cadastrar();
            $request->getRouter()->redirect('/admin/confirmado');
            exit;
        }
        // redireciona para a pagina de login
        $request->getRouter()->redirect('/admin/sigin');
    }

    public static function telaSiginConfirma($request)
    {
        // $obAdmimUser1 = AdmimUserDao::getUsuarioEmail($email);

        $content = View::renderAdmin('login/contaRegistrado', [
            'nome' => $nome ?? '',
            'email' => $email ?? '',
        ]);
        return parent::getPageAdminLogin('Conta registrado ', $content, null);
    }

}
