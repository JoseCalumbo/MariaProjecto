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
    /* Metodo para exibir  as mensagens
     * @param Request 
     * @ return string
     */
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg']))
            return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Triagem Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Triagem Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Triagem Apagado com sucesso');
                break;
            case 'confirma':
                return Mensagem::msgAlerta('Clica em Confirmar antes de apagar');
                break;
        } // fim do switch
    }

    // Metodo para apresenatar os registos dos dados 
    private static function getTriagem($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $buscar1 = filter_input(INPUT_GET, 'pesquisar1', FILTER_SANITIZE_STRING);

        if (empty($buscar1)) {
            # code...
            $condicoes = [
                strlen($buscar) ? ' nome_paciente LIKE "' . $buscar . '%"' : null,
            ];
        } else {
            # code...
            $condicoes = [
                strlen($buscar1) ? ' bilhete_paciente LIKE "' . $buscar1 . '%"' : null,
            ];
        }

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela triagem
        $quantidadetotal = TriagemDao::listarTriagem($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 6);

        $resultado = TriagemDao::listarTriagem($where, 'id_triagem', $obPagination->getLimit());

        while ($triagem = $resultado->fetchObject(TriagemDao::class)) {

            // formata o hora 
            $formatadaHora = date("d-m-Y / h:i", strtotime($triagem->data_triagem));

            $atender =  $triagem->risco_triagem;
            $triagemAtender = "";
            switch ($atender) {
                case 'a':
                    $triagemAtender = "Vermelho";
                    break;
                case 'b':
                    $triagemAtender = "Laranja";
                    break;
                case 'c':
                    $triagemAtender = "Amarelo";
                    break;
                case 'd':
                    $triagemAtender = "Verde";
                    break;
                case 'e':
                    $triagemAtender = "Azul";
                    break;
            } // fim do switch

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($triagem->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::render('triagem/listarTriagem', [
                'id_triagem' => $triagem->id_triagem,
                'Nome' => $triagem->nome_paciente,
                'genero' => $triagem->genero_paciente,
                'imagem' => $triagem->imagem_paciente,
                'hora' => $formatadaHora,
                'Atendimento' => $triagemAtender,
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
            'msg' => self::exibeMensagem($request),
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
        $bilhetePaciente = $postVars['bilhete'] ?? '';

        $obTriagem = new TriagemDao;

        if (isset($_POST['nome'], $_POST['genero'], $_POST['nascimento'])) {

            $obTriagem->peso_triagem = $_POST['peso'];
            $obTriagem->temperatura_triagem = $_POST['temperatura'];
            $obTriagem->cardiaca_triagem = $_POST['cardiaca'];
            $obTriagem->frequencia_triagem = $_POST['frequencia'];
            $obTriagem->saturacao_triagem = $_POST['Saturacao_oxigenio'];
            $obTriagem->pressao_triagem = $_POST['pressao'];
            $obTriagem->risco_triagem = $_POST['pioridade'];
            $obTriagem->observacao_triagem = $_POST['obs'];

            // Método de acesso para enviar dados para cadastrar triagem
            $id_triagem = $obTriagem->cadastrarTriagem($nomePacinete, $generoPacinete, $nascimentoPacinete, $bilhetePaciente);

            $request->getRouter()->redirect('/triagem/confirmar/' . $id_triagem . '');
            exit;
        }
        $content = View::render('triagem/formTriagem', [
            'titulo' => 'Cadastrar nova triagem',
            'pesquisar' => '',
            'nome' => '',
            'bilhete' => '',
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

    //Método responsavel por cadastrar novo triagem para os paciente
    public static function cadastrarNovaTriagem($request, $id_triagem)
    {
        //Instancia da classe model da triagem
        $triagemCadastrar = TriagemDao::getTriagemRegistradoId($id_triagem);

        $idPaciente = $triagemCadastrar->id_paciente;

        $postVars = $request->getPostVars();

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

            $request->getRouter()->redirect('/triagem/confirmar/' . $id_triagem . '');
            exit;
        }
        $content = View::render('triagem/formTriagemNova', [
            'titulo' => ' ' . $triagemCadastrar->nome_paciente . ' - Cadastrar  Nova triagem',
            'pesquisar' => '',
            'nome' => $triagemCadastrar->nome_paciente,
            'data' => $triagemCadastrar->nascimento_paciente,
            'bilhete' => $triagemCadastrar->bilhete_paciente,
            'genero' => $triagemCadastrar->genero_paciente == 'Feminino' ? 'checked' : '',
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

    //cadastra novo triagem
    public static function getTriagemRegistrada($request, $id_triagem)
    {

        // Verifica se foi finalizado
        if (isset($_POST['finaliza'])) {
            $request->getRouter()->redirect('/triagem?msg=cadastrado');
            exit;
        }

        //Instancia da classe model da triagem
        $triagemRegistrado = TriagemDao::getTriagemRegistradoId($id_triagem);

        // formata a idade do paciente
        $formataIdade = date("Y", strtotime($triagemRegistrado->nascimento_paciente));
        $idade = date("Y") - $formataIdade;

        $atender = $triagemRegistrado->risco_triagem;
        $triagemAtender = "";
        switch ($atender) {
            case 'a':
                $triagemAtender = "Vermelho";
                break;
            case 'b':
                $triagemAtender = "Laranja";
                break;
            case 'c':
                $triagemAtender = "Amarelo";
                break;
            case 'd':
                $triagemAtender = "Verde";
                break;
            case 'e':
                $triagemAtender = "Azul";
                break;
        } // fim do switch

        $content = View::render('triagem/confirmarTriagem', [
            'titulo' => 'Triagem realizada com sucesso',
            'id_triagem' => $triagemRegistrado->id_triagem,
            'nome' => $triagemRegistrado->nome_paciente,
            'genero' => $triagemRegistrado->genero_paciente,
            'bilhete' => $triagemRegistrado->bilhete_paciente,
            'ano' => $idade,
            'pioridade' => $triagemAtender,
            'peso' => $triagemRegistrado->peso_triagem,

            'temperatura' => $triagemRegistrado->temperatura_triagem,

            'pressao' => $triagemRegistrado->pressao_arterial_triagem,

            'frequencia_cardiaca' => $triagemRegistrado->frequencia_cardiaca_triagem,
            'frequencia_respiratorio' => $triagemRegistrado->frequencia_respiratorio_triagem,
            'saturacao' => $triagemRegistrado->Saturacao_oxigenio_triagem,
            'observação' => $triagemRegistrado->observacao_triagem,
            'button1' => 'Finalizar',
        ]);

        return parent::getPage('Triagem Registrada ', $content);
    }

    //edita triagem
    public static function editarTriagem($request, $id_triagem)
    {
        //Instancia da classe model da triagem
        $triagemRegistrado = TriagemDao::getTriagemRegistradoId($id_triagem);

        if (isset($_POST['nome'], $_POST['btn'])) {

            $postVars = $request->getPostVars();

            $idPaciente = $triagemRegistrado->id_paciente;

            $nomePacinete = $postVars['nome'] ?? $triagemRegistrado->nome_paciente;
            $generoPacinete = $postVars['genero'] ?? $triagemRegistrado->genero_paciente;
            $nascimentoPacinete = $postVars['nascimento'] ?? $triagemRegistrado->nascimento_paciente;
            $bilhetePaciente = $postVars['bilhete'] ?? $triagemRegistrado->bilhete_triagem;

            $triagemRegistrado->peso_triagem = $_POST['peso'] ?? $triagemRegistrado->peso_triagem;
            $triagemRegistrado->temperatura_triagem = $_POST['temperatura'] ?? $triagemRegistrado->temperatura_triagem;
            $triagemRegistrado->pressao_triagem = $_POST['pressao'] ??  $triagemRegistrado->pressao_arterial_triagem;
            $triagemRegistrado->frequencia_triagem = $_POST['frequencia'] ?? $triagemRegistrado->frequencia_respiratorio_triagem;
            $triagemRegistrado->cardiaca_triagem = $_POST['cardiaca'] ?? $triagemRegistrado->frequencia_cardiaca_triagem;
            $triagemRegistrado->saturacao_triagem = $_POST['Saturacao_oxigenio'] ?? $triagemRegistrado->Saturacao_oxigenio_triagem;
            $triagemRegistrado->risco_triagem = $_POST['pioridade'] ??  $triagemRegistrado->risco_triagem;
            $triagemRegistrado->observacao_triagem = $_POST['obs'] ??  $triagemRegistrado->observacao_triagem;

            $triagemRegistrado->atualizarTriagem($nomePacinete, $generoPacinete, $nascimentoPacinete, $idPaciente, $bilhetePaciente);

            $request->getRouter()->redirect('/triagem?msg=alterado');
            exit;
        }

        $content = View::render('triagem/formTriagem', [
            'titulo' => ' Editar Triagem',
            'nome' => $triagemRegistrado->nome_paciente,
            'bilhete' => $triagemRegistrado->bilhete_paciente,
            'data' => $triagemRegistrado->nascimento_paciente,
            'genero' => $triagemRegistrado->genero_paciente == 'Feminino' ? 'checked' : '',
            'peso' => $triagemRegistrado->peso_triagem,
            'temperatura' => $triagemRegistrado->temperatura_triagem,
            'cardiaca' => $triagemRegistrado->frequencia_cardiaca_triagem,
            'frequencia' => $triagemRegistrado->frequencia_respiratorio_triagem,
            'saturacao' => $triagemRegistrado->Saturacao_oxigenio_triagem,
            'pressao' => $triagemRegistrado->pressao_arterial_triagem,
            'obs' => $triagemRegistrado->observacao_triagem,
            'a' => $triagemRegistrado->risco_triagem == 'a' ? 'selected' : '',
            'b' => $triagemRegistrado->risco_triagem == 'b' ? 'selected' : '',
            'c' => $triagemRegistrado->risco_triagem == 'c' ? 'selected' : '',
            'd' => $triagemRegistrado->risco_triagem == 'd' ? 'selected' : '',
            'e' => $triagemRegistrado->risco_triagem == 'e' ? 'selected' : '',
            'button' => 'Actualizar Triagem '
        ]);

        return parent::getPage('Editar triagem paciente ', $content);
    }

    //apagar triagem
    public static function apagaTriagem($request, $id_triagem)
    {
        $cancelar = $_POST['cancelar'] ?? "";

        // Verifica se o usuario clicou em cancelar
        if ($cancelar == "cancelar") {
            $request->getRouter()->redirect('/triagem');
            exit;
        }

        if (isset($_POST['confirmo'])) {

            // Busca o funcionario por ID
            $obTriagem = TriagemDao::getTriagemId($id_triagem);
            $obTriagem->apagarTriagem();
            $request->getRouter()->redirect('/triagem?msg=apagado');
        }

        $request->getRouter()->redirect('/triagem?msg=confirma');
    }
}
