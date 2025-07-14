<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Http\Request;
use \App\Model\Entity\FuncionarioDao;
use \App\Controller\Mensagem\Mensagem;
use \App\Utils\Upload;

class Conta extends Page
{

    /**
     * Metodo para exibir  a mensagem 
     * @param Request $request
     * @return string
     */
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg'])) return '';

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
    }

    // funcão para apresentar os dados do user 
    private static function getUsuarioConta()
    {
        $item = '';
        //Obtem o id do usuario atraveis da Sessão
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];

        // Busca os dados funcionario pelo id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id);

        $formatada = date("h", strtotime($obFuncionario->registrado));

        echo '<pre>';
        print_r($formatada);
        echo '<pre>';
        print_r($obFuncionario->registrado);
        echo '</pre>';
         exit;

        $item .= View::render('conta/dadosConta', [
            'id' => $obFuncionario->id_funcionario,
            'nome' => $obFuncionario->nome_funcionario,
            'genero' => $obFuncionario->genero_funcionario,
            'nascimento' => $obFuncionario->nascimento_funcionario,
            'bilhete' => $obFuncionario->bilhete_funcionario,
            'email' => $obFuncionario->email_funcionario,
            'telefone' => $obFuncionario->telefone1_funcionario,
            'telefone1' => $obFuncionario->telefone2_funcionario,
            'nivel' => $obFuncionario->cargo_funcionario,
            'registro' => $obFuncionario->registrado
        ]);
        return $item;
    }

    // Metodo para apresenatar os dados do menu user dados 
    private static function getUsuarioMenu()
    {
        $item = '';

        $usuarioLogado = Session::getUsuarioLogado();
        $id = $usuarioLogado['id'];

        // Busca os dados funcionario pelo id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id);

        $item .= View::render('conta/menuConta', [
            'id' => $obFuncionario->id_funcionario,
            'nome' => $obFuncionario->nome_funcionario,
            'imagem' => $obFuncionario->imagem_funcionario,
        ]);
        return $item;
    }

    // metodo que renderiza a tela  do usuario 
    public static function telaConta($request)
    {

        // Obetm o id do usuario da sessão
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];

        // Busca os dados funcionario pelo id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id);

        $content = View::render('conta/conta', [
            'dadosconta' => self::getUsuarioConta(),
            'menuconta' => self::getUsuarioMenu(),
            'imagem' => $obFuncionario->imagem_funcionario,
            'msg' => self::exibeMensagem($request),
            'msgVazio' => ''
        ]);
        return parent::getPage('Painel Usuario', $content);
    }

    /**
     * Metodo para editar os dados 
     *@param Request $request
     *@return string
     */
    public static function editarConta($request, $id_us)
    {

        // Obetm o id do usuario da sessão
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];

        // Busca os dados funcionario pelo id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id);

        $content = View::render('conta/registrosConta', [
            'msg' => '',
            'menuconta' => self::getUsuarioMenu(),
            'msgVazio' => '',
            'imagem' => $obFuncionario->imagem_funcionario,
        ]);
        return parent::getPage('Editar conta', $content);

    }

    // metodo que renderiza a tela alter senha
    public static function telaAlterarSenha($request, $erroMsg)
    {

        // pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $id = $usuarioLogado['id'];

        $obFuncionario = FuncionarioDao::getFuncionarioId($id);
        $postVars = $request->getPostVars();

        // post do form da alteracao 
        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::mensagemErro($erroMsg) : '';

        $content = View::render('conta/alterarsenha', [
            'menuconta' => self::getUsuarioMenu(),
            'senhaAntiga' => $senhaAntiga,
            'senhaNova' => $senhaNova,
            'senhaConf' => $senhaConfirmada,
            'msg' => $status,
            'msgVazio' => '',
            'imagem' => $obFuncionario->imagem_funcionario,
        ]);
        return parent::getPage('Funcionario Alterar senha', $content);
    }

    //metodo post para alterar senha
    public static function setAlterarSenha($request, $id_us)
    {

        // obtem o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $id = $usuarioLogado['id'];

        $postVars = $request->getPostVars();

        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';

        $obFuncionario = FuncionarioDao::getFuncionarioId($id);

        // validacao da senha se corresponde
        if (!password_verify($senhaAntiga, $obFuncionario->senha_funcionario)) {
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
            $obFuncionario->senha_funcionario = password_hash($postVars['senhaNova'], PASSWORD_DEFAULT);
            $obFuncionario->atualizarSenha();
        }

        $request->getRouter()->redirect('/conta?msg=senhaEditada');
    }

    // metodo para alterar a imagem do usuario
    public static function alterarImagem($request)
    {

        $postVars = $request->getPostVars();

        // Obetm o id do usuario da sessão
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];

        // Busca os dados funcionario pelo id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id);

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
                    'imagem' => $obFuncionario->imagem_funcionario,
                    //exibe a mensagem de nao carregar uma foto
                    'msgVazio' => '<p class="div-conta-inf red center">Não selecionaste nenhuma imagem nova</p>',
                ]);
                return parent::getPage('Usuario Alterar senha', $content);
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obFuncionario->imagem_funcionario = $obUpload->getBaseName();
            $obFuncionario->actualizarImage();

            if ($sucess) {
                $request->getRouter()->redirect('/conta?msg=imagemAlterado');
                exit;
            }
        }
    }

}