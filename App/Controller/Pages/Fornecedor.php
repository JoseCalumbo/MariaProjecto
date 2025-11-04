<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Controller\Mensagem\MensagemAdmin;
use App\Model\Entity\FornecedorDao;

class Fornecedor extends Page
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
            case 'sucesso':
                return MensagemAdmin::msgSucesso('Fornecedor Cadastrado com sucesso');
                break;
            case 'cadastrado':
                return MensagemAdmin::msgSucesso('Fornecedor Cadastrado com sucesso');
                break;
            case 'push-s2':
                return MensagemAdmin::msgSucesso('Dados do fornecedor alterado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Dados do fornecedor alterado com sucesso');
                break;
            case 'apagado':
                return MensagemAdmin::msgSucesso('Fornecedor Apagado com sucesso');
                break;
            case 'confirma':
                return MensagemAdmin::msgAlerta('Clica em Confirmar antes de apagar');
                break;
        } // fim do switch
    }

    // Método para apresenatar os registos do exames cadastrados
    private static function getFornecedor($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_fornecedor LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela exames
        $quantidadetotal = FornecedorDao::listarFornecedor($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 8);

        $resultado = FornecedorDao::listarFornecedor($where, 'nome_fornecedor ', $obPagination->getLimit());

        while ($obFornecedors = $resultado->fetchObject(FornecedorDao::class)) {

            $item .= View::render('configuracao/fornecedor/listarFornecedor', [
                'id_fornecedor' => $obFornecedors->id_fornecedor,
                'nomeFornecedor' => $obFornecedors->nome_fornecedor,
                'nif' => $obFornecedors->nif_fornecedor,
                'contacto' => $obFornecedors->contacto_fornecedor,
                'email' => $obFornecedors->email_fornecedor,
                'endereco' => $obFornecedors->endereco_fornecedor,
                'dataRegistro' => date('d-m-Y', strtotime($obFornecedors->criado_fornecedor)),
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
                                                    Base de dados sem registos de fornecedor.
                                                    </td>
                                                </tr>';
    }

    // Método que apresenta a tela do Funcionario
    public static function telaFornecedor($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/fornecedor/fornecedor', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getFornecedor($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination),

            'nomeFornecedor' => "",
            'nif' => "",
            'email' => "",
            'contacto' => "",
            'descrisaoF' => "",
        ]);
        return parent::getPage('Painel Fornecedor', $content);
    }

    // Metodo que cadastrar novo Fornecedor
    public static function cadastrarMedicamentoPainel($request)
    {
        // Instancia o Model Exame
        $obFornecedor = new FornecedorDao;

        $obFornecedor->nome_fornecedor = $_POST['nomeFornecedor'];
        $obFornecedor->contacto_fornecedor = $_POST['contacto'];
        $obFornecedor->email_fornecedor = $_POST['email'];
        $obFornecedor->endereco_fornecedor = $_POST['descrisaoF'];
        $obFornecedor->nif_fornecedor = $_POST['nif'];
        $obFornecedor->cadastrarFornecedor();

        $request->getRouter()->redirect('/fornecedor?msg=sucesso');
        exit;
    }

    // Metodo que cadastrar novo Fornecedor
    public static function setCadastrarFornecedor($request)
    {
        // Instancia o Model Exame
        $obFornecedor = new FornecedorDao;

        $obFornecedor->nome_fornecedor = $_POST['nomeFornecedor'];
        $obFornecedor->contacto_fornecedor = $_POST['contacto'];
        $obFornecedor->email_fornecedor = $_POST['email'];
        $obFornecedor->endereco_fornecedor = $_POST['descrisaoF'];
        $obFornecedor->nif_fornecedor = $_POST['nif'];
        $obFornecedor->cadastrarFornecedor();

        $request->getRouter()->redirect('/fornecedor?msg=sucesso');
        exit;
    }

    // Metodo para editar os daos do fornecedor
    public static function setAtualizarFornecedor($request, $id_fornecedor)
    {
        if (isset($_POST['salvar'])) {

            // Busca o exame por id
            $obFornecedor = FornecedorDao::getFornecedorId($id_fornecedor);

            $obFornecedor->nome_fornecedor = $_POST['nomeFornecedor'] ?? $obFornecedor->nome_fornecedor;
            $obFornecedor->nif_fornecedor = $_POST['nif'] ?? $obFornecedor->nif_fornecedor;
            $obFornecedor->contacto_fornecedor = $_POST['contacto'] ?? $obFornecedor->contacto_fornecedor;
            $obFornecedor->email_fornecedor = $_POST['email'] ?? $obFornecedor->email_fornecedor;
            $obFornecedor->endereco_fornecedor = $_POST['endereco'] ?? $obFornecedor->endereco_fornecedor;

            $obFornecedor->atualizarFornecedor();

            $request->getRouter()->redirect('/fornecedor?msg=alterado');
            exit;
        }

        $request->getRouter()->redirect('/fornecedor?msg=selec');
    }

    // Metodo para apagar Funcionario
    public static function setApagarFornecedor($request, $id_fornecedor)
    {
        if (isset($_POST['Salvar'], $_POST['confirmo'])) {
            // Busca o exame por id
            $obFornecedor = FornecedorDao::getFornecedorId($id_fornecedor);
            $obFornecedor->apagarFornecedor();
            $request->getRouter()->redirect('/fornecedor?msg=apagado');
        } else {
            $request->getRouter()->redirect('/fornecedor?msg=confirma');
        }
    }
}
