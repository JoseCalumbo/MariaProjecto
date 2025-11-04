<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;

use \App\Model\Entity\ExameDao;
use \App\Controller\Mensagem\MensagemAdmin;
use App\Model\Entity\MedicamentoDao;
use App\Model\Entity\FornecedorDao;

class Medicamento extends Page
{

    /* Metodo para exibir  as mensagens
     *@param Request 
     *@ return string
     */
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg']))
            return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return MensagemAdmin::msgSucesso('Farmacia Cadastrado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Medicamento Alterado com sucesso');
                break;
            case 'alteradonivel':
                return MensagemAdmin::msgSucesso('Farmacia Alterado com sucesso');
                break;
            case 'seleciona':
                return MensagemAdmin::msgAlerta('Ação não realizada');
                break;
            case 'apagado':
                return MensagemAdmin::msgSucesso('Medicamento Apagado com sucesso');
                break;
            case 'confirma':
                return MensagemAdmin::msgAlerta('Clica em Confirmar antes de apagar');
                break;
        } // fim do switch
    }

    // busca todos os Nivel  cadastrado
    public static function getFornecedor()
    {
        $resultadoFornecedor = '';

        $listarFornecedor = FornecedorDao::listarFornecedor(null, 'nome_fornecedor');

        while ($obFornecedor = $listarFornecedor->fetchObject(FornecedorDao::class)) {

            $resultadoFornecedor .= View::render('configuracao/medicamento/itemFornecedor/fornecedor', [
                'value' => $obFornecedor->id_fornecedor,
                'fornecedor' => $obFornecedor->nome_fornecedor,
            ]);
        }
        return $resultadoFornecedor;
    }

    // Método para apresenatar os registos do medicamentos cadastrados
    private static function getMedicamentos($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_medicamento LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela Medicamentos
        $quantidadetotal = MedicamentoDao::listarMedicamento($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacão
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 8);

        $resultado = MedicamentoDao::listarMedicamento($where, 'nome_medicamento ', $obPagination->getLimit());

        while ($obMedicamento = $resultado->fetchObject(MedicamentoDao::class)) {

            $item .= View::render('configuracao/medicamento/listarMedicamento', [
                'id_medicamento' => $obMedicamento->id_medicamento,
                'nome' => $obMedicamento->nome_medicamento,
                'quantidade' => $obMedicamento->estoque_medicamento,
                'valor' => $obMedicamento->preco_medicamento,
                'dataValidade' => date('d-m-Y', strtotime($obMedicamento->validade_medicamento)),
                'dataRegistro' => date('d-m-Y', strtotime($obMedicamento->criado_medicamento)),
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
        //Nenhum Exame encontado
        return $item = strlen($item) ? $item : '<tr class="no-hover no-border" style="height: 60px;">
                                                   <td colspan="7" class="center-align no-border" style="vertical-align: middle; height:120px; font-size:18px">
                                                    Base de dados sem registos de medicamentos.
                                                    </td>
                                                </tr>';
    }

    // Método que apresenta a tela do Funcionario
    public static function telaMedicamento($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/medicamento/medicamento', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getMedicamentos($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination),
        ]);
        return parent::getPage('Painel Medicamentos', $content);
    }


    // Metodo que apresenta a pagina do novo medicamento
    public static function getCadastrarMedicamento($request)
    {
        $content = View::render('configuracao/medicamento/formMedicamento', [
            'titulo' => 'Cadastrar novo medicamento',
            'button' => 'Salvar',
            'fornecedores' => self::getFornecedor(),

            'nome' => '',
            'valor' => '',
            'dosagem' => '',
            'estoque' => '',
            'tipo' => '',
            'validade' => '',
            'descrisao' => '',

            'descrisaoF' => '',
            'nomeFornecedor' => "",
            'nif' => "",
            'contacto' => "",
            'email' => "",
        ]);

        return parent::getPage('Cadaastrar novo medicamento', $content);
    }


    // Metodo que apresenta a pagina do novo medicamento
    public static function setCadastrarMedicamento($request)
    {
        // Instancia a classe Medicamento
        $obMedicamento = new MedicamentoDao();

        if (isset($_POST['nome'], $_POST['valor'])) {

            $obMedicamento->nome_medicamento = $_POST['nome'];
            $obMedicamento->preco_medicamento = $_POST['valor'];
            $obMedicamento->descricao_medicamento = $_POST['descrisao'];
            $obMedicamento->dosagem_medicamento = $_POST['dosagem'];
            $obMedicamento->forma_medicamento = $_POST['forma'];
            $obMedicamento->estoque_medicamento = $_POST['estoque'];
            $obMedicamento->fornecedor_medicamento = $_POST['fornecedor'];
            $obMedicamento->tipo_medicamento = $_POST['tipo'];
            $obMedicamento->validade_medicamento = $_POST['validade'];
            $obMedicamento->cadastrarMedicamento();

            $request->getRouter()->redirect('/medicamento?msg=cadastrados');
            exit;
        } else {
        }
    }

    // Método que edita dados do Medicamento
    public static function getAtualizarMedicamento($request, $id_medicamento)
    {
        // Busca o exame por id
        $obMedicamento = MedicamentoDao::getMedicamentoId($id_medicamento);

        $content = View::render('configuracao/medicamento/formMedicamento', [
            'titulo' => 'Edita Dados Exame',
            'button' => 'salvar',
            'fornecedores' => self::getFornecedor(),

            'nomeFornecedor' => "",
            'nif' => "",
            'contacto' => "",
            'email' => "",

            'nome' => $obMedicamento->nome_medicamento,
            'tipo' => $obMedicamento->tipo_medicamento,
            'valor' => $obMedicamento->preco_medicamento,
            'descrisao' => $obMedicamento->descricao_medicamento,
            'dosagem' => $obMedicamento->dosagem_medicamento,
            'estoque' => $obMedicamento->estoque_medicamento,
            'validade' => date('Y-m-d', strtotime($obMedicamento->validade_medicamento)),

            'Ampola' => $obMedicamento->forma_medicamento == 'Ampola' ? 'selected' : '',
            'Xarope' => $obMedicamento->forma_medicamento == 'Xarope' ? 'selected' : '',
            'Creme' => $obMedicamento->forma_medicamento == 'Creme' ? 'selected' : '',
            'Comprimido' => $obMedicamento->forma_medicamento == 'Comprimido' ? 'selected' : '',

        ]);

        return parent::getPage('Eidtar dados Exame', $content);
    }

    // Metodo para editar Medicamento
    public static function setAtualizarMedicamento($request, $id_medicamento)
    {
        // Busca o exame por id
        $obMedicamento = MedicamentoDao::getMedicamentoId($id_medicamento);

        if (isset($_POST['nome'], $_POST['valor'])) {

            $obMedicamento->nome_medicamento = $_POST['nome'] ?? $obMedicamento->nome_medicamento;
            $obMedicamento->preco_medicamento = $_POST['valor'] ?? $obMedicamento->preco_medicamento;
            $obMedicamento->descricao_medicamento = $_POST['descrisao'] ?? $obMedicamento->descricao_medicamento;
            $obMedicamento->dosagem_medicamento = $_POST['dosagem'] ?? $obMedicamento->dosagem_medicamento;
            $obMedicamento->forma_medicamento = $_POST['forma'];
            $obMedicamento->estoque_medicamento = $_POST['estoque'];
            $obMedicamento->fornecedor_medicamento = $_POST['fornecedor'] ?? $obMedicamento->fornecedor_medicamento;
            $obMedicamento->tipo_medicamento = $_POST['tipo']  ?? $obMedicamento->tipo_medicamento;
            $obMedicamento->validade_medicamento = $_POST['validade'];
            $obMedicamento->atualizarMedicamento();

            $request->getRouter()->redirect('/medicamento?msg=alterado');
            exit;
        }
    }


    // Metodo para apagar Funcionario
    public static function setApagarMedicamento($request, $id_medicamento)
    {
        if (isset($_POST['Salvar'], $_POST['confirmo'])) {
            // Busca o exame por id
            $obExame = MedicamentoDao::getMedicamentoId($id_medicamento);
            $obExame->apagarMedicamento();
            $request->getRouter()->redirect('/medicamento?msg=apagado');
        } else {
            $request->getRouter()->redirect('/medicamento?msg=confirma');
        }
    }
}
