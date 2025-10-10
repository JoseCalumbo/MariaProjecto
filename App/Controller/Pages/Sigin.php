<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Http\Request;
use \App\Model\Entity\FuncionarioDao;
use \App\Model\Entity\AdmimUserDao;
use \App\Controller\Mensagem\Mensagem;

class Sigin extends Page
{
    // Funcão que apresenta a tela de cadastramento do funcionario
    public static function telaSigin($request, $erroMsg = null)
    {
        $postVars = $request->getPostVars();
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::msgErro($erroMsg) : '';

        $content = View::render('login/sign', [
            'nome' => $nome ?? '',
            'email' => $email ?? '',
            'senha' => $senha,
            'msg' => $status,
        ]);
        return parent::getPageLogin('Criar conta ', $content, null);
    }

    /**
     * M+etodo que faz o cadastramento do funcionario 
     * @param Request  
     */

    
    public static function criarConta($request)
    {
        $obFuncionario = new FuncionarioDao;

        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';
        $confirmaSenha = $postVars['ConfirmaSenha'] ?? '';


        // verifica se as senhas são iguais
        if ($senha != $confirmaSenha) {
            return self::telaSigin($request, '<p>Erro na confirmação de senha,digita novamente</p>');
        }

        // verifica se o email ja foi cadastrado por outro Funcionario
         $obEmailFuncionario = FuncionarioDao::getFuncionarioEmail($email);
            if ($obEmailFuncionario instanceof FuncionarioDao) {
             return self::telaSigin($request, '<p>Erro este email já esta ser utilizado</p>');
        }

        if (isset($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['ConfirmaSenha'])) {

            $obFuncionario->nome_funcionario = $nome;
            $obFuncionario->email_funcionario = $email;
            $obFuncionario->senha_funcionario = password_hash($senha, PASSWORD_DEFAULT);
            $obFuncionario->cargo_funcionario = 'Administrador';
            $obFuncionario->imagem_funcionario = 'anonimo.png';
            $obFuncionario->cadastrarFuncionario();

            $request->getRouter()->redirect('/sigin/confirmado/'.$email.'');
            exit;
        }
        // redireciona para a pagina de login
        $request->getRouter()->redirect('/sigin');
    }

    public static function getContaCadastrada($request,$email)
    {
         $emailFuncionario = FuncionarioDao::getFuncionarioEmail($email);

        $content = View::render('login/contaRegistrado', [
            'nome' => $emailFuncionario->nome_funcionario,
            'email' => $emailFuncionario->email_funcionario,
        ]);
        return parent::getPageLogin('Conta registrado ', $content, null);
    }

}
