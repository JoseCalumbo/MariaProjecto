<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;
use \App\Model\Entity\PacienteDao;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\AddNegocioDao;
use App\Model\Entity\ContaDao;


class Paciente extends Page
{

    // exibe a messagem de operacao
    public static function exibeMensagem($request)
    {

        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Vendedor Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Vendedor Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Vendedor Apagdo com sucesso');
                break;
        } // fim do switch
    }

    //lista os usuario e paginacao
    private static function getPacientes($request, &$obPagination)
    {

        $item = '';
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $condicoes = [
            strlen($buscar) ? 'nome LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela vendedor
        $quantidadetotal = PacienteDao::listarPaciente($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = PacienteDao::listarPaciente($where, 'nome_paciente', $obPagination->getLimit());

        while ($obPaciente = $resultado->fetchObject(PacienteDao::class)) {

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($obPaciente->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::render('paciente/listarPaciente', [
                'id_paciente' => $obPaciente->id_paciente,
                'imagem' => $obPaciente->imagem_paciente,
                'nome' => $obPaciente->nome_paciente,
                'genero' => $obPaciente->genero_paciente,
                'nascimento' => $idade,
                'telefone' => $obPaciente->telefone1_paciente,
                'estados' => $obPaciente->estado_paciente,
            ]);
        }

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

    //tela de vendedor
    public static function getTelaPaciente($request)
    {

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $content = View::render('paciente/paciente', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getPacientes($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Panel Paciente', $content);
    }

    // funcao que cadastra um novo registros na tabela vendedor
    public static function cadastrarPaciente($request)
    {

        $obPaciente = new PacienteDao;

        $postVars = $request->getPostVars();

        if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['telefone1'], $_POST['telefone2'], $_POST['email'], $_POST['morada'], $_POST['nivel'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obPaciente->nome_paciente = $postVars['nome'];
                $obPaciente->genero_paciente = $postVars['genero'];
                $obPaciente->nascimento_paciente = $postVars['data'];
                $obPaciente->pai_paciente = $postVars['pai'];
                $obPaciente->mae_paciente = $postVars['mae'];
                $obPaciente->bilhete_paciente = $postVars['bilhete'];
                $obPaciente->telefone1_paciente = $postVars['telefone1'];
                $obPaciente->telefone2_paciente = $postVars['telefone2'];
                $obPaciente->email_paciente = $postVars['email'];
                $obPaciente->morada_paciente = $postVars['morada'];
                $obPaciente->imagem_paciente = 'anonimo.png';
                $obPaciente->cadastrarPaciente();

                $request->getRouter()->redirect('/vendedor?msg=cadastrado');
                exit;
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/vendedor', false);

            $obPaciente->nome_paciente = $postVars['nome'];
            $obPaciente->genero_paciente = $postVars['genero'];
            $obPaciente->nascimento_paciente = $postVars['data'];
            $obPaciente->pai_paciente = $postVars['pai'];
            $obPaciente->mae_paciente = $postVars['mae'];
            $obPaciente->bilhete_paciente = $postVars['bilhete'];
            $obPaciente->telefone1_paciente = $postVars['telefone1'];
            $obPaciente->telefone2_paciente = $postVars['telefone2'];
            $obPaciente->email_paciente = $postVars['email'];
            $obPaciente->morada_paciente = $postVars['morada'];
            // $obPaciente->nivelacademico = $postVars['nivel'];
            $obPaciente->imagem_paciente = $obUpload->getBaseName();
            $obPaciente->cadastrarPaciente();

            if ($sucess) {
                $request->getRouter()->redirect('/vendedor?msg=cadastrado');
                exit;
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        $content = View::render('paciente/formPaciente', [
            'titulo' => 'Cadastrar Novo Paciente',
            'button' => 'Cadastrar',
            'msg' => '',
            'nome' => '',
            'genero' => '',
            'data' => '',
            'bilhete' => '',
            'telefone1' => '',
            'telefone2' => '',
            'email' => '',
            'pai' => '',
            'mae' => '',
            'morada' => '',
            'imagem' => 'anonimo.png'
        ]);

        return parent::getPage('Cadastrar Vendedor', $content);
    }

    // funcao que actualizar um novo registros na tabela vendedor
    public static function atualizarVendedor($request, $id)
    {

        $obPaciente = PacienteDao::getPacienteId($id);
        $postVars = $request->getPostVars();

        if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['telefone1'], $_POST['telefone2'], $_POST['email'], $_POST['morada'], $_POST['nivel'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obPaciente->nome = $postVars['nome'] ?? $obPaciente->nome;
                $obPaciente->genero = $postVars['genero'] ?? $obPaciente->genero;
                $obPaciente->nascimento = $postVars['data'] ?? $obPaciente->nascimento;
                $obPaciente->pai = $postVars['pai'] ?? $obPaciente->pai;
                $obPaciente->mae = $postVars['mae'] ?? $obPaciente->mae;
                $obPaciente->bilhete = $postVars['bilhete'] ?? $obPaciente->bilhete;
                $obPaciente->telefone1 = $postVars['telefone1'] ?? $obPaciente->telefone1;
                $obPaciente->telefone2 = $postVars['telefone2'] ?? $obPaciente->telefone2;
                $obPaciente->email = $postVars['email'] ?? $obPaciente->email;
                $obPaciente->morada = $postVars['morada'] ?? $obPaciente->morada;
                $obPaciente->id_zona = $postVars['zona'] ?? $obPaciente->id_zona;
                $obPaciente->nivelAcademico = $postVars['nivel'] ?? $obPaciente->nivelacademico;
                $obPaciente->imagem =  $obPaciente->imagem != null ? $obPaciente->imagem : 'anonimo.png';

                $obPaciente->atualizar();

                $request->getRouter()->redirect('/vendedor?msg=alterado' . $obPaciente->nome . '');
                exit;
            } // fim do if da verificacao da imagem

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/vendedor', false);

            $obPaciente->nome = $postVars['nome'] ?? $obPaciente->nome;
            $obPaciente->genero = $postVars['genero'] ?? $obPaciente->genero;
            $obPaciente->nascimento = $postVars['data'] ?? $obPaciente->nascimento;
            $obPaciente->pai = $postVars['pai'] ?? $obPaciente->pai;
            $obPaciente->mae = $postVars['mae'] ?? $obPaciente->mae;
            $obPaciente->bilhete = $postVars['bilhete'] ?? $obPaciente->bilhete;
            $obPaciente->telefone1 = $postVars['telefone1'] ?? $obPaciente->telefone1;
            $obPaciente->telefone2 = $postVars['telefone2'] ?? $obPaciente->telefone2;
            $obPaciente->email = $postVars['email'] ?? $obPaciente->email;
            $obPaciente->morada = $postVars['morada'] ?? $obPaciente->morada;
            $obPaciente->id_zona = $postVars['zona'] ?? $obPaciente->id_zona;
            $obPaciente->nivelAcademico = $postVars['nivel'] ?? $obPaciente->nivelacademico;
            $obPaciente->imagem = $obUpload->getBaseName() ?? $obPaciente->imagem;;
            $obPaciente->atualizar();

            if ($sucess) {
                $request->getRouter()->redirect('/vendedor?msg=alterado' . $obPaciente->nome . '');
                exit;
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        $content = View::render('vendedor/formVendedor1', [
            'titulo' => 'Editar Vendedor',
            'button' => 'Actualizar',
            'msg' => '',
            'nome' => $obPaciente->nome,
            'genero' => $obPaciente->genero == 'Feminino' ? 'checked' : '',
            'data' => $obPaciente->nascimento,
            'pai' => $obPaciente->pai,
            'mae' => $obPaciente->mae,
            'bilhete' => $obPaciente->bilhete,
            'telefone1' => $obPaciente->telefone1,
            'telefone2' => $obPaciente->telefone2,
            'email' => $obPaciente->email,
            'morada' => $obPaciente->morada,
            'base-nivel' => $obPaciente->nivelAcademico == 'base' ? 'selected' : '',
            'medio' => $obPaciente->nivelAcademico == 'medio' ? 'selected' : '',
            'licenciado' => $obPaciente->nivelAcademico == 'licenciado' ? 'selected' : '',
            'imagem' => $obPaciente->imagem,

        ]);

        return parent::getPage('Editar Vendedor', $content);
    }

    // metodo para apagar um vendedor
    public static function apagarVendedor($request, $id)
    {

        $obAddNegocio = new AddNegocioDao();

        $conta = new ContaDao();

        $obPaciente = PacienteDao::getPacienteId($id);

        // validacao do click do botao apagar
        if (isset($_POST['apagar'])) {

            $obAddNegocio->deleteAddNegocio($id);

            $conta->apagarConta($id);

            $obPaciente->apagar();

            $request->getRouter()->redirect('/vendedor?msg=apagado');
            exit;
        }

        $content = View::render('vendedor/apagarVendedor', [
            'titulo' => ' Apagar o Vendedor',
            'id' => $obPaciente->id,
            'nome' => $obPaciente->nome_paciente,
            'Criado' => $obPaciente->create_vs,
            'imagem' => $obPaciente->imagem,
        ]);

        return parent::getPage('Apagar Vendedor', $content);
    }
}
