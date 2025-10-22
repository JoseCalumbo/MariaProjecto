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
                return MensagemAdmin::msgAlerta('Clica em selecionar antes de salvar');
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
                'parametro' => $obExames->parametro_exame,
                'valor' => $obExames->valor_exame,
                'dataRegistro' => $obExames->criado_exame
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
            $obExame->parametro_exame = $_POST['parametros'];
            $obExame->valor_exame = $_POST['valor'];
            $obExame->estado_exame = $_POST['estado'];

            // faz o cadastramento e obtem o id registrado do exame
            $idExame = $obExame->cadastrarExame();

            $request->getRouter()->redirect('/exame?msg=cadastrado');
            exit;
        

        return true;
    }

    // Metodo que cadastrar novo Exame
    public static function cadastrarExame1($request)
    {
        // Instancia o Model Exame
        $obExame = new ExameDao;

        if (isset($_POST['nome'], $_POST['tipo'],)) {

            $obExame->nome_exame = $_POST['nome'];
            $obExame->tipo_exame = $_POST['tipo'];
            $obExame->parametro_exame = $_POST['parametro'];
            $obExame->valor_exame = $_POST['valor'];
            $obExame->estado_exame = $_POST['estado'];

            // faz o cadastramento e obtem o id registrado do exame
            $idExame = $obExame->cadastrarExame();

            $request->getRouter()->redirect('/exame?msg=cadastrado');
            exit;
        }

        // Renderiza a tela de formulario do funcionario add
        $content = View::render('configuracao/exame/formExame', [
            'titulo' => 'Cadastrar Novo Exame',
            'button' => 'salvar',
            'msg' => '',
            'nome' => '',
            'ordem' => '',
            'nivel' => '',
        ]);

        return parent::getPage('Novo Exame', $content);
    }

    // Método que edita dados do Funcionario
    public static function getAtualizarFuncionario($request, $id_exame)
    {
        // Busca um Funcionario por id
        $obExame = FuncionarioDao::getFuncionarioId($id_exame);

        $content = View::render('funcionario/formFuncionarioEditar', [
            'perfilCadastrado' => self::getExame(),
            'titulo' => 'Edita Dados Utilizadores',
            'button' => 'salvar',
            'nome' => $obExame->nome_exame,
            'genero' => $obExame->genero_exame == 'Feminino' ? 'checked' : '',
            'data' => $obExame->nascimento_exame,
            'bilhete' => $obExame->bilhete_exame,
            'ordem' => $obExame->numeroordem_exame,
            'email' => $obExame->email_exame,
            'telefone1' => $obExame->telefone1_exame,
            'telefone2' => $obExame->telefone2_exame,
            'morada' => $obExame->morada_exame,
            'cargo-admin' => $obExame->cargo_exame == 'Administrador' ? 'selected' : '',
            'cargo-medico' => $obExame->cargo_exame == 'Médico' ? 'selected' : '',
            'cargo-enfermero' => $obExame->cargo_exame == 'Enfermeiro' ? 'selected' : '',
            'cargo-farmaceutico' => $obExame->cargo_exame == 'Farmacêuticos' ? 'selected' : '',
            'cargo-analista' => $obExame->cargo_exame == 'Analista Clínico' ? 'selected' : '',
            'cargo-tecnico' => $obExame->cargo_exame == 'Técnicos de Enfermagem' ? 'selected' : '',
            'imagem' => $obExame->imagem_exame,

            'senha' => '',
            'senhaConfirma' => '',
        ]);

        return parent::getPage('Eidtar dados Funcionario', $content);
    }

    // Metodo para editar Funcionario
    public static function setAtualizarFuncionario($request, $id_exame)
    {
        // Busca um Funcionario por id
        $obExame = FuncionarioDao::getFuncionarioId($id_exame);

        $postVars = $request->getPostVars();

        if (isset($_POST['nome'], $_POST['data'], $_POST['bilhete'], $_POST['email'], $_POST['telefone1'], $_POST['cargo'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obExame->nome_exame = $_POST['nome'];
                $obExame->genero_exame = $_POST['genero'];
                $obExame->nascimento_exame = $_POST['data'];
                $obExame->bilhete_exame = $_POST['bilhete'];
                $obExame->numeroordem_exame = $_POST['ordem'];
                $obExame->email_exame = $_POST['email'];
                $obExame->telefone1_exame = $_POST['telefone1'];
                $obExame->telefone2_exame = $_POST['telefone2'];
                $obExame->cargo_exame = $_POST['cargo'];
                $obExame->morada_exame = $_POST['morada'];
                $obExame->imagem_exame = 'anonimo.png' != null ? $obExame->imagem_exame : 'anonimo.png';;
                $obExame->atualizarFuncionario();

                $request->getRouter()->redirect('/utilizadores?msg=alterado');
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obExame->nome_exame = $_POST['nome'] ?? $obExame->nome_exame;
            $obExame->genero_exame = $_POST['genero'] ?? $obExame->genero_exame;
            $obExame->nascimento_exame = $_POST['data'];
            $obExame->bilhete_exame = $_POST['bilhete'];
            $obExame->numeroordem_exame = $_POST['ordem'];
            $obExame->email_exame = $_POST['email'];
            $obExame->telefone1_exame = $_POST['telefone1'];
            $obExame->telefone2_exame = $_POST['telefone2'];
            $obExame->cargo_exame = $_POST['cargo'];
            $obExame->morada_exame = $_POST['morada'];
            $obExame->imagem_exame = $obUpload->getBaseName()  ?? $obExame->imagem_exame;

            $obExame->atualizarFuncionario();

            if ($sucess) {
                $request->getRouter()->redirect('/utilizadores?msg=alterado');
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }
        $content = View::render('funcionario/formFuncionarioEditar', []);

        return parent::getPage('Actualizar utilizador', $content);
    }

    // Metodo para apagar Funcionario
    public static function setApagarFuncionario($request, $id_exame)
    {
        $cancelar = $_POST['cancelar'] ?? "";

        // Verifica se o usuario clicou em cancelar
        if ($cancelar == "cancelar") {
            $request->getRouter()->redirect('/utilizadores');
            exit;
        }

        if (isset($_POST['confirmo'])) {

            // Busca o funcionario por ID
            $obExame = FuncionarioDao::getFuncionarioId($id_exame);
            $obExame->apagarFuncionario();
            $request->getRouter()->redirect('/utilizadores?msg=apagado');
        }

        $request->getRouter()->redirect('/utilizadores?msg=confirma');
    }
}
