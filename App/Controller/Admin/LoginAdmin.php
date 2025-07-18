<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use App\Controller\Admin\PageAdmin;
use \App\Model\Entity\AdmimUserDao;
use \App\Http\Request;
use \App\Utils\SessionAdmin;
use \App\Controller\Mensagem\Mensagem;

class LoginAdmin extends PageAdmin
{

  /** Função para apresentar a pagina de LOGUIN Usuario Gestor Adimin
   * @param Request  
   */
  public static function getTelaLoginAdmin($request, $erroMsg = null)
  {
    $postVars = $request->getPostVars();
    $postVars = $request->getPostVars();
    $email = $postVars['email'] ?? '';
    $senha = $postVars['senha'] ?? '';

    $status = !is_null($erroMsg) ? Mensagem::mensagemErro($erroMsg) : '';

    $content = View::renderAdmin('login/login', [
      'email' => $email ?? '',
      'senha' => $senha,
      'msg' => $status,
    ]);
    return parent::getPageAdminLogin('Admin - Login', $content, null);
  }

    /** Função para logar o Usuario Gestor Adimin
     * @param Request  
     */
    public static function setLoginAdmin($request)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $obAdminUser = AdmimUserDao::getUsuarioEmail($email);

        if (!$obAdminUser instanceof AdmimUserDao) {
            return self::getTelaLoginAdmin($request, 'Erro Email ou Senha Invalidos');
        }

        if (!password_verify($senha, $obAdminUser->senha)) {
            return self::getTelaLoginAdmin($request, 'Senha Invalida');
        }

        //criar uma nova Sessão de Login
        SessionAdmin::login($obAdminUser);
        
        if ($obAdminUser->nivel == 'Administrador' ) {
            // redireciona para a pagina principal
            $request->getRouter()->redirect('/admin');
        }

        if ($obAdminUser->nivel == 'visitante') {
            // redireciona para a pagina de home 
            $request->getRouter()->redirect('/dados');
        }
    }

    /**
     * Metodo para deslogar o usuario Gestor Adimin
     * @param Request @request
     */
    public static function setDeslogarAdmin($request)
    {
        //desfaz session de login
        SessionAdmin::logout();

        // direciona para a tela de login
        $request->getRouter()->redirect('/admin/login');
    }

























    /**
     * Metodo para tela de  recuperar senha usuario
     * @param Request @request
     */
    public static function getRecuperarSenha($request, $erroMsg)
    {
        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';
        $content = View::renderAdmin('login/recuperarSenha', [
            'msg' => $status,
        ]);
        return parent::getPageAdminLogin('Recuperar senha Admin', $content, null);
    }

    public static function setRecuperarSenha($request, $erroMsg)
    {
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';

        $obAdminUser = AdmimUserDao::getUsuarioEmail($email);

        if (!$obAdminUser instanceof AdmimUserDao) {
            return self::getRecuperarSenha($request, 'Erro! Não foi encontrado nenhuma conta com este email');
        }

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::renderAdmin('login/enviarEmail', [
            'msg' => $status,
            'id' => $obAdminUser->id,
            'nome' => $obAdminUser->nome,
            'imagem' => $obAdminUser->imagem,
            'email' => $obAdminUser->email
        ]);

        return parent::getPageAdminLogin('Recuperar senha', $content, null);
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

        return parent::getPageAdminLogin('Recuperar senha -email ', $content, null);
    }
}