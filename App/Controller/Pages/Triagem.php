<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Model\Entity\NegocioDao;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\TriagemDao;
use App\Model\Entity\PacienteDao;

class Triagem extends Page
{

    // Metodo para apresenatar os registos dos dados 
    private static function getNegocio($request, &$obPagination)
    {

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'negocio LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = NegocioDao::listarNegocio($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = NegocioDao::listarNegocio($where, 'negocio ', $obPagination->getLimit());

        while ($negocio = $resultado->fetchObject(NegocioDao::class)) {

            $item .= View::render('triagem/listarNegocio', [
                'id_negocio' => $negocio->id_negocio,
                'Nome' => "Ana",
                'Sobrenome' => "Carlos",
                'hora' => "12:30",
                'Atendimento' => "1",
                'data' => 12,
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

    public static function pagTriagem($request)
    {

        $content = View::render('triagem/triagem', [
            'msg' => '',
            'pesquisar' => '',
            //    'item' => self::getNegocio($request, $obPagination),
            //   'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Triagem', $content);
    }

    //cadastra novo triagem
    public static function cadastrarTriagem($request)
    {
        $obTriagem = new TriagemDao;

        $obPaciente = new PacienteDao;

        if (isset($_POST['nome'])) {

            $obPaciente->nome_paciente = $_POST['nome'];
            $obTriagem->genero_paciente = $_POST['genero'];
            $obTriagem->nascimento_paciente = $_POST['nascimento'];
            $obTriagem->nascimento_paciente = $_POST['peso'];
            $obTriagem->nascimento_paciente = $_POST['temperatura'];
            $obTriagem->nascimento_paciente = $_POST['presao'];
            $obTriagem->nascimento_paciente = $_POST['obs'];


            $obTriagem->cadastrarTriagem();

            echo '<pre>';
            print_r($obPaciente->cadastrarPaciente());
            echo '</pre>';
            exit;

            $request->getRouter()->redirect('/triagem/comfirmar');
            exit;
        }

        $content = View::render('triagem/formTriagem', [
            'titulo' => 'Cadastrar nova triagem',
            'pesquisar' => '',
            'data' => '',

            'button' => 'Salvar',
        ]);

        return parent::getPage('Cadastrar Novo Negócio ', $content);
    }

    //cadastra novo triagem
    public static function ConfirmarTriagem($request)
    {

        if (isset($_POST['negocio'])) {

            $obNegocio = new NegocioDao;

            $obNegocio->negocio = $_POST['negocio'];
            $obNegocio->cadastrarNegocio();

            $request->getRouter()->redirect('/confirmar-triagem/{id_negocio}');
            exit;
        }

        $content = View::render('triagem/confirmarTriagem', [
            'titulo' => 'Comfirmar Triagem',
            'pesquisar' => '',
            'negocio' => '',
            'nome' => 'Ana Miguel',
            'numero' => 23,
            'button1' => 'Comfirmar',
            'button2' => 'Cancelar'

        ]);

        return parent::getPage('Comfirmar Triagem ', $content);
    }

    //edita triagem
    public static function editarTriagem($request, $id_negocio)
    {

        //Seleciona o negocio por id
        $obNegocio = NegocioDao::getNegocio($id_negocio);

        if (isset($_POST['negocio'])) {

            $obNegocio->negocio = $_POST['negocio'] ?? $obNegocio->negocio;
            $obNegocio->atualizarNegocio();

            $request->getRouter()->redirect('/negocio?msg=editar');
            exit;
        }

        $content = View::render('triagem/formTriagem', [
            'titulo' => ' Editar Triagem',
            'pesquisar' => '',
            'negocio' => $obNegocio->negocio,
            'button' => 'Actualizar Triagem '
        ]);

        return parent::getPage('Editar Negócio id {{id_negocio}}', $content);
    }

    //apagar triagem
    public static function apagaTriagem($request, $id_negocio)
    {

        $obNegocio = NegocioDao::getNegocio($id_negocio);

        $obNegocio->apagarNegocio();

        $request->getRouter()->redirect('/triagem?msg=apagado');
        exit;
    }
}
