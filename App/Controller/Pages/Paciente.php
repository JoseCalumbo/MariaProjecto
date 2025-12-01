<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;
use \App\Model\Entity\PacienteDao;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\TriagemDao;

use \App\Utils\Session;
use \App\Model\Entity\NivelDao;


class Paciente extends Page
{

    // exibe a messagem de operacao
    public static function exibeMensagem($request)
    {

        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Paciente Cadastrado com sucesso');
                break;
            case 'cadastrados':
                return Mensagem::msgSucesso('Triagem Registrada com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Paciente Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Paciente Apagdo com sucesso');
                break;
        } // fim do switch
    }

    //lista os usuario e paginacao
    private static function getPacientes($request, &$obPagination)
    {
        $item = '';
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $condicoes = [
            strlen($buscar) ? 'nome_paciente LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela vendedor
        $quantidadetotal = PacienteDao::listarPaciente($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 7);

        $resultado = PacienteDao::listarPaciente($where, 'nome_paciente', $obPagination->getLimit());

        while ($obPaciente = $resultado->fetchObject(PacienteDao::class)) {

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($obPaciente->nascimento_paciente));
            $idades = date("Y") - $formataIdade;

           //$idade = $idades == 2025 ? $idade : "0";

            $item .= View::render('paciente/listarPaciente', [
                'id_paciente' => $obPaciente->id_paciente,
                'imagem' => $obPaciente->imagem_paciente,
                'nome' => $obPaciente->nome_paciente,
                'genero' => $obPaciente->genero_paciente,
                'nascimento' => $idades,
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
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];
        $resultado = NivelDao::VerificarNivel1($id);
        $permissoes = array_column($resultado, "codigo_permisao");

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $content = View::render('paciente/paciente', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getPacientes($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination),

            'REGISTROS_DELETE'        => in_array("REGISTROS_DELETE", $permissoes) ? "Com permissão " : "disabled-link",
            'enable_btn'        => in_array("REGISTROS_DELETE", $permissoes) ? "Com permissão " : "grey lighten-4",

        ]);
        return parent::getPage('Panel Paciente', $content);
    }

    // funcao que cadastra um novo registros na tabela vendedor
    public static function cadastrarPaciente($request)
    {
        $obPaciente = new PacienteDao;

        $postVars = $request->getPostVars();

        if (isset($_POST['cadastrar'], $_POST['nome'], $_POST['genero'], $_POST['nascimento'], $_POST['bilhete'], $_POST['telefone1'], $_POST['telefone2'], $_POST['email'], $_POST['morada'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obPaciente->nome_paciente = $postVars['nome'];
                $obPaciente->pai_paciente = $postVars['pai'];
                $obPaciente->mae_paciente = $postVars['mae'];
                $obPaciente->genero_paciente = $postVars['genero'];
                $obPaciente->nascimento_paciente = $postVars['nascimento'];
                $obPaciente->nacionalidade_paciente = $postVars['nacionalidade'];
                $obPaciente->bilhete_paciente = $postVars['bilhete'];

                $obPaciente->telefone1_paciente = $postVars['telefone1'];
                $obPaciente->telefone2_paciente = $postVars['telefone2'];
                $obPaciente->email_paciente = $postVars['email'];
                $obPaciente->morada_paciente = $postVars['morada'];

                $obPaciente->motivo_paciente = $postVars['motivo'];
                $obPaciente->estado_paciente = $postVars['estado'];


                $obPaciente->responsavelNome_paciente = $postVars['responsavelNome'];
                $obPaciente->responsavelTelefone_paciente = $postVars['responsavelTelefone'];

                $obPaciente->imagem_paciente = 'anonimo.png';
                $obPaciente->documentos_paciente = 'documentos';
                $obPaciente->cadastrarPaciente();

                $request->getRouter()->redirect('/paciente?msg=cadastrado');
                exit;
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/paciente', false);

            $obPaciente->nome_paciente = $postVars['nome'];
            $obPaciente->pai_paciente = $postVars['pai'];
            $obPaciente->mae_paciente = $postVars['mae'];
            $obPaciente->genero_paciente = $postVars['genero'];
            $obPaciente->nascimento_paciente = $postVars['nascimento'];
            $obPaciente->nacionalidade_paciente = $postVars['nacionalidade'];
            $obPaciente->bilhete_paciente = $postVars['bilhete'];

            $obPaciente->telefone1_paciente = $postVars['telefone1'];
            $obPaciente->telefone2_paciente = $postVars['telefone2'];
            $obPaciente->email_paciente = $postVars['email'];
            $obPaciente->morada_paciente = $postVars['morada'];

            $obPaciente->motivo_paciente = $postVars['motivo'];
            $obPaciente->estado_paciente = $postVars['estado'];
            $obPaciente->responsavelNome_paciente = $postVars['responsavelNome'];
            $obPaciente->responsavelTelefone_paciente = $postVars['responsavelTelefone'];

            $obPaciente->documentos_paciente = 'documentos';
            $obPaciente->imagem_paciente = $obUpload->getBaseName();
            $obPaciente->cadastrarPaciente();

            if ($sucess) {
                $request->getRouter()->redirect('/paciente?msg=cadastrado');
                exit;
            } else {
                echo 'Ficheiro não Enviado';
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
            'motivo' => '',
            'responsavelNome' => '',
            'responsavelTelefone' => '',
            'morada' => '',
            'imagem' => 'anonimo.png'
        ]);

        return parent::getPage('Registrar paciente', $content);
    }

    // funcao que actualizar um novo registros na tabela paciente
    public static function editarPaciente($request, $id_paciente)
    {
        // Seleciona o paciente pelo ID
        $obPaciente = PacienteDao::getPacienteId($id_paciente);

        $postVars = $request->getPostVars();

        if (isset($_POST['cadastrar'], $_POST['nome'], $_POST['genero'], $_POST['nascimento'], $_POST['bilhete'], $_POST['telefone1'], $_POST['telefone2'], $_POST['email'], $_POST['morada'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obPaciente->nome_paciente = $postVars['nome'] ?? $obPaciente->nome_paciente;
                $obPaciente->pai_paciente = $postVars['pai'] ?? $obPaciente->pai_paciente;
                $obPaciente->mae_paciente = $postVars['mae'] ?? $obPaciente->mae_paciente;
                $obPaciente->genero_paciente = $postVars['genero'] ?? $obPaciente->genero_paciente;
                $obPaciente->nascimento_paciente = $postVars['nascimento'] ?? $obPaciente->nascimento_paciente;
                $obPaciente->nacionalidade_paciente = $postVars['nacionalidade'] ?? $obPaciente->nacionalidade_paciente;
                $obPaciente->bilhete_paciente = $postVars['bilhete'] ?? $obPaciente->bilhete_paciente;

                $obPaciente->telefone1_paciente = $postVars['telefone1'] ?? $obPaciente->telefone1_paciente;
                $obPaciente->telefone2_paciente = $postVars['telefone2'] ?? $obPaciente->telefone2_paciente;
                $obPaciente->email_paciente = $postVars['email'] ?? $obPaciente->email_paciente;
                $obPaciente->morada_paciente = $postVars['morada'] ?? $obPaciente->morada_paciente;

                $obPaciente->motivo_paciente = $postVars['motivo'] ?? $obPaciente->motivo_paciente;

                $obPaciente->estado_paciente = $postVars['estado'] ?? $obPaciente->estado_paciente;
                $obPaciente->responsavelNome_paciente = $postVars['responsavelNome'];
                $obPaciente->responsavelTelefone_paciente = $postVars['responsavelTelefone'];

                $obPaciente->imagem_paciente =  $obPaciente->imagem_paciente != null ? $obPaciente->imagem_paciente : 'anonimo.png';

                $obPaciente->atualizar();

                $request->getRouter()->redirect('/paciente?msg=alterado' . $obPaciente->nome_paciente . '');
                exit;
            } // fim do if da verificacao da imagem

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/paciente', false);

            $obPaciente->nome_paciente = $postVars['nome'] ?? $obPaciente->nome_paciente;
            $obPaciente->pai_paciente = $postVars['pai'] ?? $obPaciente->pai_paciente;
            $obPaciente->mae_paciente = $postVars['mae'] ?? $obPaciente->mae_paciente;
            $obPaciente->genero_paciente = $postVars['genero'] ?? $obPaciente->genero_paciente;
            $obPaciente->nascimento_paciente = $postVars['nascimento'] ?? $obPaciente->nascimento_paciente;
            $obPaciente->nacionalidade_paciente = $postVars['nacionalidade'] ?? $obPaciente->nacionalidade_paciente;
            $obPaciente->bilhete_paciente = $postVars['bilhete'] ?? $obPaciente->bilhete_paciente;

            $obPaciente->telefone1_paciente = $postVars['telefone1'] ?? $obPaciente->telefone1_paciente;
            $obPaciente->telefone2_paciente = $postVars['telefone2'] ?? $obPaciente->telefone2_paciente;
            $obPaciente->email_paciente = $postVars['email'] ?? $obPaciente->email_paciente;
            $obPaciente->morada_paciente = $postVars['morada'] ?? $obPaciente->morada_paciente;

            $obPaciente->motivo_paciente = $postVars['motivo'] ?? $obPaciente->motivo_paciente;
            $obPaciente->estado_paciente = $postVars['estado'] ?? $obPaciente->estado_paciente;
            $obPaciente->responsavelNome_paciente = $postVars['responsavelNome'];
            $obPaciente->responsavelTelefone_paciente = $postVars['responsavelTelefone'];

            $obPaciente->imagem_paciente = $obUpload->getBaseName() ?? $obPaciente->imagem_paciente;
            $obPaciente->atualizar();

            if ($sucess) {
                $request->getRouter()->redirect('/paciente?msg=alterado' . $obPaciente->nome . '');
                exit;
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        $content = View::render('paciente/formPaciente', [
            'titulo' => 'Editar Paciente',
            'button' => 'Actualizar',
            'msg' => '',
            'nome' => $obPaciente->nome_paciente,
            'pai' => $obPaciente->pai_paciente,
            'mae' => $obPaciente->mae_paciente,
            'genero' => $obPaciente->genero_paciente == 'Feminino' ? 'checked' : '',
            'data' => $obPaciente->nascimento_paciente,

            'bilhete' => $obPaciente->bilhete_paciente,

            'angolana' => $obPaciente->nacionalidade_paciente == 'Angolana' ? 'selected' : '',
            'estrageiro' => $obPaciente->nacionalidade_paciente == 'Estrangeiro' ? 'selected' : '',

            'telefone1' => $obPaciente->telefone1_paciente,
            'telefone2' => $obPaciente->telefone2_paciente,
            'email' => $obPaciente->email_paciente,
            'morada' => $obPaciente->morada_paciente,
            'motivo' => $obPaciente->motivo_paciente,
            'Atendimento agendado' => $obPaciente->estado_paciente == 'Atendimento agendado' ? 'selected' : '',
            'Em Triagem' => $obPaciente->estado_paciente == 'Em Triagem' ? 'selected' : '',
            'Em tratamento' => $obPaciente->estado_paciente == 'Em tratamento' ? 'selected' : '',
            'Em atendimento' => $obPaciente->estado_paciente == 'Em atendimento' ? 'selected' : '',
            'Consulta Marcada' => $obPaciente->estado_paciente == 'Consulta Marcada' ? 'selected' : '',
            'Alta' => $obPaciente->estado_paciente == 'Alta' ? 'selected' : '',
            'Aberto' => $obPaciente->estado_paciente == 'Aberto' ? 'selected' : '',

            'responsavelNome' => $obPaciente->responsavel_paciente,
            'responsavelTelefone' => $obPaciente->telefoneResponsavel_paciente,
            'imagem' => $obPaciente->imagem_paciente,

        ]);

        return parent::getPage('Editar paciente', $content);
    }

    // Metodo para apresenta a conta do paciente
    public static function contaPaciente($request, $id_paciente)
    {
        // Seleciona o paciente pelo ID
        $obPaciente = PacienteDao::getPacienteId($id_paciente);

        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];
        $resultado = NivelDao::VerificarNivel1($id);
        $permissoes = array_column($resultado, "codigo_permisao");

        $content = View::render('paciente/pacientePerfil', [
            'id_paciente' => $obPaciente->id_paciente,
            'nome' => $obPaciente->nome_paciente,
            'pai' => $obPaciente->pai_paciente,
            'mae' => $obPaciente->mae_paciente,
            'genero' => $obPaciente->genero_paciente,
            'data' => $obPaciente->nascimento_paciente,

            'bilhete' => $obPaciente->bilhete_paciente,
            'angolana' => $obPaciente->nacionalidade_paciente == 'Angolana' ? 'selected' : '',
            'estrageiro' => $obPaciente->nacionalidade_paciente,

            'telefone1' => $obPaciente->telefone1_paciente,
            'telefone2' => $obPaciente->telefone2_paciente,
            'email' => $obPaciente->email_paciente,
            'morada' => $obPaciente->morada_paciente,
            'motivo' => $obPaciente->motivo_paciente,
            'Atendimento agendado' => $obPaciente->estado_paciente == 'Atendimento agendado' ? 'selected' : '',
            'Em Triagem' => $obPaciente->estado_paciente == 'Em Triagem' ? 'selected' : '',
            'Em tratamento' => $obPaciente->estado_paciente == 'Em tratamento' ? 'selected' : '',
            'Em atendimento' => $obPaciente->estado_paciente == 'Em atendimento' ? 'selected' : '',
            'Consulta Marcada' => $obPaciente->estado_paciente == 'Consulta Marcada' ? 'selected' : '',
            'Alta' => $obPaciente->estado_paciente == 'Alta' ? 'selected' : '',
            'estado' => $obPaciente->estado_paciente,

            'responsavelNome' => $obPaciente->responsavel_paciente,
            'responsavelTelefone' => $obPaciente->telefoneResponsavel_paciente,
            'imagem' => $obPaciente->imagem_paciente,

            'USER_PERFIL_VIEW'     => in_array("USER_PERFIL_VIEW", $permissoes) ? "Com permissão" : "disabled-link",

        ]);

        return parent::getPage('Conta paciente', $content);
    }

    //Método responsavel por cadastrar novo triagem para os paciente
    public static function addTriagem($request, $id_paciente)
    {
        // Seleciona o paciente pelo ID
        $obPaciente = PacienteDao::getPacienteId($id_paciente);

        $idPaciente = $obPaciente->id_paciente;

        $obTriagem = new TriagemDao;

        if (isset($_POST['peso'], $_POST['temperatura'])) {

            $obTriagem->peso_triagem = $_POST['peso'];
            $obTriagem->temperatura_triagem = $_POST['temperatura'];
            $obTriagem->cardiaca_triagem = $_POST['cardiaca'];
            $obTriagem->frequencia_triagem = $_POST['frequencia'];
            $obTriagem->saturacao_triagem = $_POST['Saturacao_oxigenio'];
            $obTriagem->pressao_triagem = $_POST['pressao'];
            $obTriagem->risco_triagem = $_POST['pioridade'];
            $obTriagem->observacao_triagem = $_POST['obs'];

            // Método de acesso para enviar dados para cadastrar triagem
            $id_triagem = $obTriagem->cadastrarNovaTriagem($idPaciente);

            // Seleciona o paciente pelo ID
            $obPaciente = PacienteDao::getPacienteId($obTriagem->id_paciente);
            // busca alterar o estado do paciente
            $obPaciente->atualizarEstadoAgurdando();

            $request->getRouter()->redirect('/paciente?msg=cadastrados');
            exit;
        }
        $content = View::render('triagem/formAddTriagem', [
            'titulo' => ' ' . $obPaciente->nome_paciente . ' - Registrar Nova triagem',
            'pesquisar' => '',
            'nome' => $obPaciente->nome_paciente,
            'data' => $obPaciente->nascimento_paciente,
            'bilhete' => $obPaciente->bilhete_paciente,
            'genero' => $obPaciente->genero_paciente == 'Feminino' ? 'checked' : '',
            'frequencia' => '',
            'pressao' => '',
            'saturacao' => '',
            'cardiaca' => '',
            'peso' => '',
            'temperatura' => '36',

            'obs' => '',
            'button' => 'Salvar',
        ]);

        return parent::getPage('Registrar nova triagem ', $content);
    }

    // metodo para apagar um paciente
    public static function apagarPaciente($request, $id_paciente)
    {
        // Seleciona o paciente pelo id
        $obPaciente = PacienteDao::getPacienteId($id_paciente);

        $idPaciente = $obPaciente->id_paciente;

        // $TriagemPaciente = TriagemDao::getListarTriagemPaciente($id_paciente);
        // Instancia da class Triagem
        $TriagemPaciente = new TriagemDao;

        if (isset($_POST['Salvar'],$_POST['confirmo'],)) {

            $TriagemPaciente->apagarTriagemPaciente($id_paciente);

            $obPaciente->apagarPaciente();

            $request->getRouter()->redirect('/paciente?msg=apagado');
        } else {

            $request->getRouter()->redirect('/paciente?msg=confirma');
        }
    }

}




