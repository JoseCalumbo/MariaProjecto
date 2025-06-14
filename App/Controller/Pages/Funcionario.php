<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;
use \App\Http\Request;
use \App\Model\Entity\FuncionarioDao;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\PostoDao;
use \App\Controller\Mensagem\Mensagem;
use \App\Controller\Pages\Posto;
class Funcionario extends Page
{

    /* Metodo para exibir  as mensagens
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
                return Mensagem::msgSucesso('Funcionario Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Funcionario Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Funcionario Apagdo com sucesso');
                break;
            case 'confirma':
                return Mensagem::msgSucesso('Cliqua em sim antes de apagar');
                break;
        }// fim do switch
    }

    // Método para apresenatar os registos dos Funcionario
    private static function getFuncionario($request, &$obPagination)
    {

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_funcionario LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = FuncionarioDao::listarFuncionario($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 2);

        $resultado = FuncionarioDao::listarFuncionario($where, 'nome_funcionario ', $obPagination->getLimit());


        while ($obFuncionario = $resultado->fetchObject(FuncionarioDao::class)) {
            $item .= View::render('funcionario/listarFuncionario', [
                'id_funcionario' => $obFuncionario->id_funcionario,
                'imagem' => $obFuncionario->imagem_funcionario,
                'nome' => $obFuncionario->nome_funcionario,
                'genero' => $obFuncionario->genero_funcionario,
                'telefone' => $obFuncionario->telefone1_funcionario,
                'cargo' => $obFuncionario->cargo_funcionario,
                'numero' => $obFuncionario->numeroordem_funcionario,
                'dataRegistro' => $obFuncionario->registrado
            ]);
        }

        // Verifica se foi realizada uma pesquisa
        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::render('pesquisar/box_resultado', [
                'pesquisa' => $buscar,
                'item' => $item,
                'numResultado' => $quantidadetotal,
            ]);

        }

        return $item;
    }

    // Método que apresenta a tela d Funcionario
    public static function telaFuncionario($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $content = View::render('funcionario/funcionario', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getFuncionario($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);

        return parent::getPage('Painel funcionario', $content);
    }

    // Metodo que cadastra novo Funcionario
    public static function cadastrarFuncionario($request)
    {
        // Instancia o Model Funcionario
        $obFuncionario = new FuncionarioDao;

        $postVars = $request->getPostVars();
        // Obtem os postos cadastrados 
        //$obPosto = new Posto();

        if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['email'], $_POST['telefone1'], $_POST['cargo'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obFuncionario->nome_funcionario = $_POST['nome'];
                $obFuncionario->genero_funcionario = $_POST['genero'];
                $obFuncionario->nascimento_funcionario = $_POST['data'];
                $obFuncionario->bilhete_funcionario = $_POST['bilhete'];
                $obFuncionario->numeroordem_funcionario = $_POST['ordem'];
                $obFuncionario->email_funcionario = $_POST['email'];
                $obFuncionario->telefone1_funcionario = $_POST['telefone1'];
                $obFuncionario->telefone2_funcionario = $_POST['telefone2'];
                $obFuncionario->cargo_funcionario = $_POST['cargo'];
                $obFuncionario->senha_funcionario = password_hash($_POST['bilhete'], PASSWORD_DEFAULT);
                $obFuncionario->imagem_funcionario = 'anonimo.png';
                $obFuncionario->cadastrarFuncionario();

                $request->getRouter()->redirect('/funcionario?msg=cadastrado');
                exit;
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obFuncionario->nome_funcionario = $_POST['nome'];
            $obFuncionario->genero_funcionario = $_POST['genero'];
            $obFuncionario->nascimento_funcionario = $_POST['data'];
            $obFuncionario->bilhete_funcionario = $_POST['bilhete'];
            $obFuncionario->numeroordem_funcionario = $_POST['ordem'];
            $obFuncionario->email_funcionario = $_POST['email'];
            $obFuncionario->telefone1_funcionario = $_POST['telefone1'];
            $obFuncionario->telefone2_funcionario = $_POST['telefone2'];
            $obFuncionario->cargo_funcionario = $_POST['cargo'];
            $obFuncionario->senha_funcionario = password_hash($_POST['bilhete'], PASSWORD_DEFAULT);
            $obFuncionario->imagem_funcionario = $obUpload->getBaseName();
            $obFuncionario->cadastrarFuncionario();

            if ($sucess) {
                $request->getRouter()->redirect('/funcionario?msg=cadastrado');
                exit;
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        // Renderiza a tela de formulario do funcionario
        $content = View::render('funcionario/formFuncionario', [
            'titulo' => 'Cadastrar Novo Funcionario',
            'button' => 'Cadastrar',
            'msg' => '',
            'nome' => '',
            'ordem' => '',
            'morada' => '',
            'femenino' => '',
            'data' => '',
            'bilhete' => '',
            'email' => '',
            'telefone2' => '',
            'telefone1' => '',
            'nivel' => '',
            'imagem' => 'anonimo.png',
            // 'itemPosto' => self::getPosto(),
            'pot' => ''

        ]);

        return parent::getPage('Cadastrar Funcionario', $content);
    }

    // Método que edita dados do Funcionario
    public static function getAtualizarFuncionario($request, $id_funcionario)
    {
        // Busca um Funcionario por id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id_funcionario);

        $content = View::render('funcionario/formFuncionario', [
            'titulo' => 'Editar Dados do Funcionario',
            'button' => 'Actulizar',
            'msg' => '',
            'nome' => $obFuncionario->nome_funcionario,
            'genero' => $obFuncionario->genero_funcionario == 'Feminino' ? 'checked' : '',
            'data' => $obFuncionario->nascimento_funcionario,
            'bilhete' => $obFuncionario->bilhete_funcionario,
            'ordem' => $obFuncionario->numeroordem_funcionario,
            'email' => $obFuncionario->email_funcionario,
            'telefone1' => $obFuncionario->telefone1_funcionario,
            'telefone2' => $obFuncionario->telefone2_funcionario,
            'morada' => $obFuncionario->morada_funcionario,
            'cargo-admin' => $obFuncionario->cargo_funcionario == 'administrador' ? 'selected' : '',
            'cargo-medico' => $obFuncionario->cargo_funcionario == 'Médico' ? 'selected' : '',
            'cargo-enfermero' => $obFuncionario->cargo_funcionario == 'Enfermeiro' ? 'selected' : '',
            'cargo-farmaceutico' => $obFuncionario->cargo_funcionario == 'Farmacêuticos' ? 'selected' : '',
            'cargo-analista' => $obFuncionario->cargo_funcionario == 'Analista Clínico' ? 'selected' : '',
            'cargo-tecnico' => $obFuncionario->cargo_funcionario == 'Técnicos de Enfermagem' ? 'selected' : '',
            'imagem' => $obFuncionario->imagem_funcionario,
        ]);

        return parent::getPage('Eidtar dados Funcionario', $content);
    }

    // Metodo para editar Funcionario
    public static function setAtualizarFuncionario($request, $id_funcionario)
    {
        // Busca um Funcionario por id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id_funcionario);

        $postVars = $request->getPostVars();

        if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['email'], $_POST['telefone1'], $_POST['cargo'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obFuncionario->nome_funcionario = $_POST['nome'];
                $obFuncionario->genero_funcionario = $_POST['genero'];
                $obFuncionario->nascimento_funcionario = $_POST['data'];
                $obFuncionario->bilhete_funcionario = $_POST['bilhete'];
                $obFuncionario->numeroordem_funcionario = $_POST['ordem'];
                $obFuncionario->email_funcionario = $_POST['email'];
                $obFuncionario->telefone1_funcionario = $_POST['telefone1'];
                $obFuncionario->telefone2_funcionario = $_POST['telefone2'];
                $obFuncionario->cargo_funcionario = $_POST['cargo'];
                $obFuncionario->senha_funcionario = password_hash($_POST['bilhete'], PASSWORD_DEFAULT);
                $obFuncionario->imagem_funcionario = 'anonimo.png';
                $obFuncionario->atualizarFuncionario();

                $request->getRouter()->redirect('/funcionario?msg=alterado');

            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obFuncionario->nome_funcionario = $_POST['nome'];
            $obFuncionario->genero_funcionario = $_POST['genero'];
            $obFuncionario->nascimento_funcionario = $_POST['data'];
            $obFuncionario->bilhete_funcionario = $_POST['bilhete'];
            $obFuncionario->numeroordem_funcionario = $_POST['ordem'];
            $obFuncionario->email_funcionario = $_POST['email'];
            $obFuncionario->telefone1_funcionario = $_POST['telefone1'];
            $obFuncionario->telefone2_funcionario = $_POST['telefone2'];
            $obFuncionario->cargo_funcionario = $_POST['cargo'];
            $obFuncionario->senha_funcionario = password_hash($_POST['bilhete'], PASSWORD_DEFAULT);
            $obFuncionario->imagem_funcionario = $obUpload->getBaseName();
            ;
            $obFuncionario->atualizarFuncionario();

            if ($sucess) {

                $request->getRouter()->redirect('/funcionario?msg=alterado');
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }
        $content = View::render('funcionario/formUser', []);

        return parent::getPage('Actualizar Funcionario', $content);
    }

    // Metodo para ir na pagina de apagar Funcionario 
    public static function apagarUser($request, $id_us)
    {
        $obUsuario = UsuarioDao::getUsuarioId($id_us);

        $content = View::render('funcionario/apagarUser', [
            'titulo' => ' Apagar o Usuario',
            'id' => $obUsuario->id_us,
            'imagem' => $obUsuario->imagem_us,
            'nome' => $obUsuario->nome_us,
            'Criado' => $obUsuario->create_us,
        ]);
        return parent::getPage('Apagar Usuario {{id}}', $content);
    }

    // Metodo para apagar Funcionario
    public static function setApagarFuncionario($request, $id_funcionario)
    {
        if (isset($_POST['confirmo'])) {

            // Busca o funcionario por ID
            $obFuncionario = FuncionarioDao::getFuncionarioId($id_funcionario);
            $obFuncionario->apagarFuncionario();
            $request->getRouter()->redirect('/funcionario?msg=apagado');
        }

         $request->getRouter()->redirect('/funcionario?msg=confirma');
    }
}



