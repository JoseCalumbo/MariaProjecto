<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Utils\Upload;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\AdmimUserDao;
use \App\Controller\Mensagem\Mensagem;

class Sigin extends Page
{
    // Funcao que apresenta a tela de usuario
    public static function telaSigin($request, $erroMsg = null)
    {
        $postVars = $request->getPostVars();
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::render('login/sign', [
            'email' => $email ?? '',
            'senha' => $senha,
            'msg' => $status,
        ]);
        return parent::getPageLogin('Logar ', $content, null);
    }

    /**
     * Função para logar o usuario
     * @param Request  
     */
    public static function criarConta($request)
    {
        $obAdmimUser = new AdmimUserDao;

        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';
        $confirmaSenha = $postVars['ConfirmaSenha'] ?? '';

        if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['ConfirmaSenha'])) {

            $obAdmimUser->nome_us = $nome;
            $obAdmimUser->email_us = $email;
            $obAdmimUser->senha_us = password_hash($senha, PASSWORD_DEFAULT);
            $obAdmimUser->imagem_us = 'anonimo.png';
            $obAdmimUser->cadastrar();

            $request->getRouter()->redirect('/usuario?msg=cadastrado');
            exit;

            if ($sucess) {
                $request->getRouter()->redirect('/usuario?msg=cadastrado');
                exit;
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        // redireciona para a pagina de login
        $request->getRouter()->redirect('/login');
    }

    /**
     * Metodo para tela de  recuperar senha usuario
     * @param 
     */
    public static function recuperarSenha($request, $erroMsg)
    {

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::render('login/recuperarSenha', [
            'msg' => $status,
        ]);

        return parent::getPageLogin('Recuperar senha', $content, null);
    }


    public static function setRecuperarSenha($request, $erroMsg)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';

        $obAdmimUser = UsuarioDao::getUsuarioEmail($email);

        if (!$obAdmimUser instanceof UsuarioDao) {
            return self::recuperarSenha($request, 'Erro! Não foi encontrado nenhuma conta com este email');
        }

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::render('login/enviarEmail', [
            'msg' => $status,
            'id' => $obAdmimUser->id_us,
            'nome' => $obAdmimUser->nome_us,
            'imagem' => $obAdmimUser->imagem_us,
            'email' => $obAdmimUser->email_us,
        ]);

        return parent::getPageLogin('Recuperar senha', $content, null);
    }

    public static function emailEnviado($request, $erroMsg)
    {
        $content = View::render('login/emailEnviado', [
            // 'msg' =>$status,
            // 'id' =>$obAdmimUser->id_us,
            // 'nome' =>$obAdmimUser->nome_us,
            // 'imagem' =>$obAdmimUser->imagem_us,
            // 'email' =>$obAdmimUser->email_us,
        ]);

        return parent::getPageLogin('Recuperar senha -email ', $content, null);
    }
}
