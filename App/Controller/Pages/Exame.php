<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;

use \App\Model\Entity\ExameDao;

use \App\Model\Entity\FuncionarioDao;
use \App\Model\Entity\FuncionarioNivelDao;
use \App\Model\Entity\NivelDao;
use \App\Controller\Mensagem\MensagemAdmin;


class Exame extends Page
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
                return MensagemAdmin::msgSucesso('Exame Cadastrado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Exame Alterado com sucesso');
                break;
            case 'alteradonivel':
                return MensagemAdmin::msgSucesso('Exame Alterado com sucesso');
                break;
            case 'seleciona':
                return MensagemAdmin::msgAlerta('Ação não realizada');
                break;
            case 'apagado':
                return MensagemAdmin::msgSucesso('Exame Apagado com sucesso');
                break;
            case 'confirma':
                return MensagemAdmin::msgAlerta('Clica em Confirmar antes de apagar');
                break;
        } // fim do switch
    }

    //Método para buscar todos exames cadastrado
    public static function getExame()
    {

        $resultadoExame = '';

        $listarExame = ExameDao::listarExame(null, 'nome_nivel');

        while ($obExame = $listarExame->fetchObject(NivelDao::class)) {

            $resultadoExame .= View::render('funcionario/itemFuncionario/perfil', [
                'value' => $obExame->id_nivel,
                'perfil' => $obExame->nome_nivel,
                //'checado'=>$obNegocio->nome,
            ]);
        }
        return $resultadoExame = strlen($resultadoExame) ? $resultadoExame : '<tr>
                                                                                <td colspan="5">
                                                                                    Nenhum Exame encontado
                                                                                </td>
                                                                            </tr>';
    }

    // Método para apresenatar os registos do exames cadastrados
    private static function getExames($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_exame LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela exames
        $quantidadetotal = ExameDao::listarExame($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 8);

        $resultado = ExameDao::listarExame($where, 'nome_exame ', $obPagination->getLimit());

        while ($obExames = $resultado->fetchObject(ExameDao::class)) {

            $item .= View::render('configuracao/exame/listarExames', [
                'id_exame' => $obExames->id_exame,
                'nome' => $obExames->nome_exame,
                'tipo' => $obExames->tipo_exame,
                'parametros' => $obExames->parametro_exame,
                'valor' => $obExames->valor_exame,
                'descrisao' => $obExames->descrisao_exame,
                'dataRegistro' => date('d-m-Y', strtotime($obExames->criado_exame)),
                'estadoExame' => $obExames->estado_exame,

                'activo' => $obExames->estado_exame == 'Activo' ? 'selected' : '',
                'desativado' => $obExames->estado_exame == 'Desativado' ? 'selected' : '',

                'Imagem' => $obExames->tipo_exame == 'Imagem' ? 'selected' : '',
                'Sorológicos' => $obExames->tipo_exame == 'Sorológicos' ? 'selected' : '',
                'Bioquímicos' => $obExames->tipo_exame == 'Bioquímicos' ? 'selected' : '',
                'Urina' => $obExames->tipo_exame == 'Urina' ? 'selected' : '',
                'Microbiológicos' => $obExames->tipo_exame == 'Microbiológicos' ? 'selected' : '',
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
                                                    Base de dados sem registos de exame.
                                                    </td>
                                                </tr>';
    }

    // Método que apresenta a tela do Funcionario
    public static function telaExame($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/exame/exame', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getExames($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination),

            'nome' => "",
            'valor' => "",
            'descrisao' => "",
            'parametros' => "",

        ]);
        return parent::getPage('Painel Exames', $content);
    }


    // Metodo que cadastrar novo Exame
    public static function cadastrarExame($request)
    {
        // Instancia o Model Exame
        $obExame = new ExameDao;

        $obExame->nome_exame = $_POST['nome'];
        $obExame->tipo_exame = $_POST['categoria'];
        $obExame->descrisao_exame = $_POST['descrisao'];
        $obExame->parametro_exame = $_POST['parametros'];
        $obExame->valor_exame = $_POST['valor'];
        $obExame->estado_exame = $_POST['estado'];

        // faz o cadastramento e obtem o id registrado do exame
        $idExame = $obExame->cadastrarExame();

        $request->getRouter()->redirect('/exame?msg=alterado');
        exit;


        return true;
    }

    // Método que edita dados do Funcionario
    public static function getAtualizarExame($request, $id_exame)
    {
        // Busca o exame por id
        $obExames = ExameDao::getExameId($id_exame);

        $content = View::render('configuracao/exame/formEditarExame', [
            'titulo' => 'Edita Dados Exame',
            'button' => 'salvar',

            'nome' => $obExames->nome_exame,
            'tipo' => $obExames->tipo_exame,
            'parametros' => $obExames->parametro_exame,
            'valor' => $obExames->valor_exame,
            'descrisao' => $obExames->descrisao_exame,
            'dataRegistro' => date('d-m-Y', strtotime($obExames->criado_exame)),
            'estadoExame' => $obExames->estado_exame,

            'activo' => $obExames->estado_exame == 'Activo' ? 'selected' : '',
            'desativado' => $obExames->estado_exame == 'Desativado' ? 'selected' : '',

            'Imagem' => $obExames->tipo_exame == 'Imagem' ? 'selected' : '',
            'Sorológicos' => $obExames->tipo_exame == 'Sorológicos' ? 'selected' : '',
            'Bioquímicos' => $obExames->tipo_exame == 'Bioquímicos' ? 'selected' : '',
            'Urina' => $obExames->tipo_exame == 'Urina' ? 'selected' : '',
            'Microbiológicos' => $obExames->tipo_exame == 'Microbiológicos' ? 'selected' : '',


        ]);

        return parent::getPage('Eidtar dados Exame', $content);
    }

    // Metodo para editar Funcionario
    public static function setAtualizarExame($request, $id_exame)
    {
        if (isset($_POST['Salvar'])) {

            // Busca o exame por id
            $obExame = ExameDao::getExameId($id_exame);

            $obExame->nome_exame = $_POST['nome'] ?? $obExame->nome_exame;
            $obExame->valor_exame = $_POST['valor'] ?? $obExame->valor_exame;
            $obExame->parametro_exame = $_POST['parametros'] ?? $obExame->parametro_exame;
            $obExame->descrisao_exame = $_POST['descrisao'] ?? $obExame->descrisao_exame;
            $obExame->tipo_exame = $_POST['categoria'] ?? $obExame->tipo_exame;
            $obExame->estado_exame = $_POST['estado'] ?? $obExame->estado_exame;

            // faz o cadastramento e obtem o id registrado do exame
            $obExame->AtualizarExame();

            $request->getRouter()->redirect('/exame');
            exit;
        }

        $request->getRouter()->redirect('/exame?msg=seleciona');
    }


    // Metodo para apagar Funcionario
    public static function setApagarExame($request, $id_exame)
    {
        if (isset($_POST['Salvar'], $_POST['confirmo'])) {
            // Busca o exame por id
            $obExame = ExameDao::getExameId($id_exame);
            $obExame->apagarExame();
            $request->getRouter()->redirect('/exame?msg=apagado');
        } else {
            $request->getRouter()->redirect('/exame?msg=confirma');
        }
    }
}
