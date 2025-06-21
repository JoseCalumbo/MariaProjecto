<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Http\Request;
use \App\Model\Entity\FuncionarioDao;
use \App\Controller\Mensagem\Mensagem;

class Login extends Page
{

    /** Função para apresentar a pagina de LOGUIN dos usuario
     * @param Request  
     */
    public static function telaLogin($request, $erroMsg = null)
    {
        $postVars = $request->getPostVars();
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::render('login/login', [
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
    public static function setLogin($request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $obFuncionario = FuncionarioDao::getFuncionarioEmail($email);

        if (!$obFuncionario instanceof FuncionarioDao) {
            return self::telaLogin($request, '<p>Erro Email ou Senha Invalidos</p>');
        }

        if (!password_verify($senha, $obFuncionario->senha_funcionario)) {
            return self::telaLogin($request, '<p>Erro Email ou Senha Invalido2 </p>');
           }

        //criar uma nova Sessão de Login
        Session::login($obFuncionario);

        if ($obFuncionario->cargo_funcionario == 'administrador') {
            // redireciona para a pagina principal
            $request->getRouter()->redirect('/');
        }

        if ($obFuncionario->cargo_funcionario == 'Médico' || $obFuncionario->cargo_funcionario == 'Medico') {
            // redireciona para a pagina de home 
            $request->getRouter()->redirect('/');
        }

        // redireciona para a pagina de home 
        $request->getRouter()->redirect('/');
    }

    /**
     * Metodo para deslogar o usuario
     * @param Request @request
     */
    public static function setDeslogar($request)
    {

        //desfaz session de login
        Session::logout();

        // direciona para a tela de login
        $request->getRouter()->redirect('/login');
    }

    /**
     * Metodo para tela de  recuperar senha usuario
     * @param Request @request
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

        $obUsuario = UsuarioDao::getUsuarioEmail($email);

        if (!$obUsuario instanceof UsuarioDao) {
            return self::recuperarSenha($request, 'Erro! Não foi encontrado nenhuma conta com este email');
        }

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::render('login/enviarEmail', [
            'msg' => $status,
            'id' => $obUsuario->id_us,
            'nome' => $obUsuario->nome_us,
            'imagem' => $obUsuario->imagem_us,
            'email' => $obUsuario->email_us,
        ]);

        return parent::getPageLogin('Recuperar senha', $content, null);
    }

    public static function emailEnviado($request, $erroMsg)
    {
        $content = View::render('login/emailEnviado', [
            // 'msg' =>$status,
            // 'id' =>$obUsuario->id_us,
            // 'nome' =>$obUsuario->nome_us,
            // 'imagem' =>$obUsuario->imagem_us,
            // 'email' =>$obUsuario->email_us,
        ]);

        return parent::getPageLogin('Recuperar senha -email ', $content, null);
    }
}
