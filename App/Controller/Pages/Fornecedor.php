<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;

use \App\Model\Entity\ExameDao;
use \App\Controller\Mensagem\MensagemAdmin;
use App\Model\Entity\FornecedorDao;
use FontLib\Font;

class Fornecedor extends Page
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
            case 'sucesso':
                return MensagemAdmin::msgSucesso('Fornecedor Cadastrado com sucesso');
                break;
            case 'cadastrado':
                return MensagemAdmin::msgSucesso('Fornecedor Cadastrado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Fornecedor Alterado com sucesso');
                break;
            case 'alteradonivel':
                return MensagemAdmin::msgSucesso('Fornecedor Alterado com sucesso');
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
                'nome' => $obFornecedors->nome_fornecedor,
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
        return parent::getPage('Painel Exames', $content);
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

    // Método que edita dados do Funcionario
    public static function getAtualizarFornecedor($request, $id_exame)
    {
        // Busca o exame por id
        $obFornecedors = ExameDao::getExameId($id_exame);

        $content = View::render('configuracao/fornecedor/formEditarFornecedor', [
            'titulo' => 'Edita Dados Fornecedor',
            'button' => 'salvar',

            'nome' => $obFornecedors->nome_exame,
            'tipo' => $obFornecedors->tipo_exame,
            'parametros' => $obFornecedors->parametro_exame,
            'valor' => $obFornecedors->valor_exame,
            'descrisao' => $obFornecedors->descrisao_exame,
            'dataRegistro' => date('d-m-Y', strtotime($obFornecedors->criado_exame)),
            'estadoExame' => $obFornecedors->estado_exame,

            'activo' => $obFornecedors->estado_exame == 'Activo' ? 'selected' : '',
            'desativado' => $obFornecedors->estado_exame == 'Desativado' ? 'selected' : '',

            'Imagem' => $obFornecedors->tipo_exame == 'Imagem' ? 'selected' : '',
            'Sorológicos' => $obFornecedors->tipo_exame == 'Sorológicos' ? 'selected' : '',
            'Bioquímicos' => $obFornecedors->tipo_exame == 'Bioquímicos' ? 'selected' : '',
            'Urina' => $obFornecedors->tipo_exame == 'Urina' ? 'selected' : '',
            'Microbiológicos' => $obFornecedors->tipo_exame == 'Microbiológicos' ? 'selected' : '',


        ]);

        return parent::getPage('Editar dados Fornecedor', $content);
    }

    // Metodo para editar Funcionario
    public static function setAtualizarFornecedor($request, $id_exame)
    {
        if (isset($_POST['Salvar'])) {

            // Busca o exame por id
            $obFornecedor = ExameDao::getExameId($id_exame);

            $obFornecedor->nome_exame = $_POST['nome'] ?? $obFornecedor->nome_exame;
            $obFornecedor->valor_exame = $_POST['valor'] ?? $obFornecedor->valor_exame;
            $obFornecedor->parametro_exame = $_POST['parametros'] ?? $obFornecedor->parametro_exame;
            $obFornecedor->descrisao_exame = $_POST['descrisao'] ?? $obFornecedor->descrisao_exame;
            $obFornecedor->tipo_exame = $_POST['categoria'] ?? $obFornecedor->tipo_exame;
            $obFornecedor->estado_exame = $_POST['estado'] ?? $obFornecedor->estado_exame;

            // faz o cadastramento e obtem o id registrado do exame
            $obFornecedor->AtualizarExame();

            $request->getRouter()->redirect('/exame');
            exit;
        }

        $request->getRouter()->redirect('/exame?msg=seleciona');
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
