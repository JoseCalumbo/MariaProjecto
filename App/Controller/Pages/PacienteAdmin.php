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


class PacienteAdmin extends Page
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
            case 'confirma':
                return Mensagem::msgAlerta('Alerta é necessria a tua confirmação para pagar os dados ');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Paciente Apagado com sucesso');
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
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 5);

        $resultado = PacienteDao::listarPaciente($where, 'nome_paciente', $obPagination->getLimit());

        while ($obPaciente = $resultado->fetchObject(PacienteDao::class)) {

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($obPaciente->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::render('configuracao/paciente/listarPacienteAdmin', [
                'id_paciente' => $obPaciente->id_paciente,
                'imagem' => $obPaciente->imagem_paciente,
                'nome' => $obPaciente->nome_paciente,
                'genero' => $obPaciente->genero_paciente,
                'nascimento' => $idade,
                'telefone' => $obPaciente->telefone1_paciente,
                'estados' => $obPaciente->estado_paciente,
                'criado' => $obPaciente->create_paciente,
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

    //Apresenta o painel de admim paciente
    public static function getAdminPaciente($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/paciente/adminPaciente', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getPacientes($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Panel Administrador Paciente', $content);
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

            $request->getRouter()->redirect('/config-paciente?msg=apagado');
        } else {

            $request->getRouter()->redirect('/config-paciente?msg=confirma');
        }
    }
}
