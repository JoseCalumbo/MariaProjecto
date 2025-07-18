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
    private static function getTriagem($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? ' nome_paciente LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela triagem
        $quantidadetotal = TriagemDao::listarTriagem($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = TriagemDao::listarTriagem($where, 'id_triagem', $obPagination->getLimit());

        while ($triagem = $resultado->fetchObject(TriagemDao::class)) {

            // formata o hora 
            $formatadaHora = date("h:i", strtotime($triagem->data_triagem));

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($triagem->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::render('triagem/listarTriagem', [
                'id_negocio' => $triagem->id_triagem,
                'Nome' => $triagem->nome_paciente,
                'genero' => $triagem->genero_paciente,
                'hora' => $formatadaHora,
                'Atendimento' => $triagem->risco_triagem,
                'idade' => $idade,
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

    // Apresenta a listagem da Triagem 
    public static function pagTriagem($request)
    {
        $content = View::render('triagem/triagem', [
            'msg' => '',
            'pesquisar' => '',
            'item' => self::getTriagem($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Triagem', $content);
    }

    //Método responsavel por cadastrar novo triagem
    public static function cadastrarTriagem($request)
    {
        $postVars = $request->getPostVars();

        $nomePacinete = $postVars['nome'] ?? '';
        $generoPacinete = $postVars['genero'] ?? '';
        $nascimentoPacinete = $postVars['nascimento'] ?? '';

        $obTriagem = new TriagemDao;

        if (isset($_POST['nome'], $_POST['genero'], $_POST['nascimento'],)) {

            $obTriagem->peso_triagem = $_POST['peso'];
            $obTriagem->temperatura_triagem = $_POST['temperatura'];
            $obTriagem->presao_triagem = $_POST['presao'];
            $obTriagem->frequencia_triagem = $_POST['frequencia'];
            $obTriagem->observacao_triagem = $_POST['obs'];

            $id_triagem = $obTriagem->cadastrarTriagem($nomePacinete, $generoPacinete, $nascimentoPacinete);

            $request->getRouter()->redirect('/triagem/confirmar/' . $id_triagem . '');
            exit;
        }
        $content = View::render('triagem/formTriagem', [
            'titulo' => 'Cadastrar nova triagem',
            'pesquisar' => '',
            'nome' => '',
            'frequencia' => '',
            'pressao' => '',
            'peso' => '',
            'temperatura' => '36',
            'data' => '',
            'obs' => '',
            'button' => 'Salvar',
        ]);

        return parent::getPage('Registrar nova triagem ', $content);
    }

    //cadastra novo triagem
    public static function getTriagemRegistrada($request, $id_triagem)
    {
        //Instancia da classe model da triagem
        $triagemRegistrado = TriagemDao::getTriagemRegistradoId($id_triagem);

        // formata a idade do paciente
        $formataIdade = date("Y", strtotime($triagemRegistrado->nascimento_paciente));
        $idade = date("Y") - $formataIdade;

        $content = View::render('triagem/confirmarTriagem', [
            'titulo' => 'Triagem realizada com sucesso',
            'nome' => $triagemRegistrado->nome_paciente,
            'genero' => $triagemRegistrado->genero_paciente,
            'ano' => $idade,
            'peso' => $triagemRegistrado->peso_triagem,
            'temperatura' => $triagemRegistrado->temperatura_triagem,
            'pressao' => $triagemRegistrado->pressao_triagem,
            'frequencia_cardiaca' => $triagemRegistrado->pressao_triagem,
            'frequencia_respiratorio' => $triagemRegistrado->frequencia_triagem,
            'observação' => $triagemRegistrado->observacao_triagem,
            'button1' => 'Finalizar',
        ]);

        return parent::getPage('Triagem Registrada ', $content);
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
