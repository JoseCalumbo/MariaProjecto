<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\FuncionarioDao;
use \App\Utils\Pagination;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\NivelPermissaoDao;
use App\Model\Entity\PermissaoDao;
use App\Model\Entity\NivelDao;

class Perfil extends Page
{

    // exibe a messagem de operacao
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Nivel salvo com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Nivel e Permissão  Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Nivel Apagdo com sucesso');
                break;
            case 'confirma':
                return Mensagem::msgAlerta('Clica em confirmar antes de apagar o perfil');
                break;
        } // fim do switch
    }

    // Método para apresenatar os perfil
    private static function getPerfil($request, &$obPagination)
    {

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_nivel LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = NivelDao::listarNivelForm($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 11);

        $resultado = NivelDao::listarNivelForm($where, 'nome_nivel ', $obPagination->getLimit());


        while ($obFuncionario = $resultado->fetchObject(NivelDao::class)) {
            $item .= View::render('configuracao/perfil/listarPerfil', [
                'id_nivel' => $obFuncionario->id_nivel,
                'nome' => $obFuncionario->nome_nivel,
                'descrisao' => $obFuncionario->descricao_nivel,
                'data' => $obFuncionario->criado_nivel,

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

    // Método que apresentar a tela de perfil de acesso
    public static function getPerfilAcesso($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('configuracao/perfil/perfilUtilizador', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'nome' => "",
            'msg' => self::exibeMensagem($request),
            'msg' => self::exibeMensagem($request),
            'item' => self::getPerfil($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Perfil de Acesso e permissão', $content);
    }

    // Método que apresenta cadastrar o perfil de acesso
    public static function setCadastrarPerfil($request)
    {
        $postVars = $request->getPostVars();

        $obNivel = new NivelDao;

        $obNivel->nome_nivel = $postVars['nome'];
        $obNivel->serie_nivel = $postVars['serie'];
        $obNivel->descricao_nivel = $postVars['descrisao'];

        $id_Nivel = $obNivel->cadastrarNivelAcesso();

        $request->getRouter()->redirect('/cadastrar/permissao/' . $id_Nivel . '');
    }

    // Método que apresenta cadastrar o perfil de acesso
    public static function cadastrarPermissao($request, $id_Nivel)
    {
        $codigos = [];
        $nomes = [];
        $IdPermissao = [];

        $alert = "<script>
                         alert('Perfil cadastrado com sucesso. Atribui as permissão de acesso!');
                </script>";

        $resultado = PermissaoDao::listarPermissao();

        while ($obPermisao = $resultado->fetchObject(PermissaoDao::class)) {
            $IdPermissao[] = $obPermisao->id_permissao;
            $codigos[] = $obPermisao->codigo_permisao;
            $nomes[] = $obPermisao->nome_permissao;
        }

        $content = View::render('configuracao/perfil/formPerfil', [
            'titulo' => 'Atribuir Acesso e Permissões',
            'button' => 'Salvar',
            'msg1' => $alert,


            'DATABASE_VIEW' => $IdPermissao[7],
            'REGISTROS_DELETE' => $IdPermissao[1],
            'IMPORT_DATABASE_VIEW' => $IdPermissao[8],

            'LABORATORIO_ACESS' => $IdPermissao[9],
            'EXAME_ACESS' => $IdPermissao[10],
            'EXAME_CREATE' => $IdPermissao[11],
            'EXAME_RESULT' => $IdPermissao[12],
            'EXAME_SOLICITACAO' => $IdPermissao[13],
            'EXAME_AGENDAR' => $IdPermissao[14],

            'USER_VIEW' => $IdPermissao[15],
            'USER_PERFIL_VIEW' => $IdPermissao[16],
            'CREATE_SERVICE' => $IdPermissao[17],
            'PERSONALIZAR' => $IdPermissao[18],
            'AGENDAR' => $IdPermissao[19],

            'FARMACIA_ACESS' => $IdPermissao[20],
            'MEDICAMENTO_CREATE' => $IdPermissao[21],
            'FORNECEDOR_VIEW' => $IdPermissao[22],
            'GERIR_ESTOQUE_VIEW' => $IdPermissao[23],
            'RECEPÇAO' => $IdPermissao[24],

            'TESORARIA_ACESS' => $IdPermissao[25],
            'CAIXA_VIEW' => $IdPermissao[26],
            'PAGAMENTO_VIEW' => $IdPermissao[27],
            'SALFT' => $IdPermissao[28],

            'PACIENTE_CREATE' => $IdPermissao[29],
            'INTERNAMENTO_VIEW' => $IdPermissao[30],
            'TRANSFERIR_VIEW' => $IdPermissao[31],
            'CONSULTA_VIEW' => $IdPermissao[32],
            'MARCAR_CONSULTA_VIEW' => $IdPermissao[33],
            'EXAME_VIEW' => $IdPermissao[34],
            'ATENDIMENTO_VIEW' => $IdPermissao[35],

            //_________________________________________________________________________________

            'database_view1' => '',
            'registros_delete1' => '',
            'import_database_view1' => '',

            'laboratorio_acess1' => '',
            'exame_acess1' => '',
            'exame_create1' => '',
            'exame_result1' => '',
            'exame_solicitacao1' => '',
            'exame_agendar1' => '',

            'user_view1' => '',
            'user_perfil_view1' => '',
            'create_service1' => '',
            'personalizar1' => '',
            'agendar1' => '',

            'farmacia_acess1' =>  '',
            'medicamento_create1' =>  '',
            'fornecedor_view1' =>  '',
            'gerir_estoque_view1' => '',
            'recepcao1' =>  '',

            'tesoraria_acess1' =>  '',
            'caixa_view1' => '',
            'pagamento_view1' => '',
            'salft1' => '',

            'paciente_create1' => '',
            'internamento_view1' => '',
            'transferir_view1' =>  '',
            'consulta_view1' => '',
            'marcar_consulta_view1' => '',
            'exame_view1' => '',
            'atendimento_view1' => '',


        ]);
        return parent::getPage('Adicionar Acesso e Permissao', $content);
    }

    // Método que cadastrar o perfil de acesso
    public static function setCadastrarPermissao($request, $id_Nivel)
    {
        $obPermisaoNivel = new NivelPermissaoDao;

        //Verifica se existem checkboxes marcados
        if (!empty($_POST['codigo_permisao'])) {

            foreach ($_POST['codigo_permisao'] as $valor) {
                $obPermisaoNivel->id_nivel = $id_Nivel;
                $obPermisaoNivel->id_permissoes = $valor;
                $obPermisaoNivel->addPermissao();
            }

            $request->getRouter()->redirect('/perfil?msg=cadastrado');
        } else {

            $alert = "<script>
                         alert('Nenhuma opção foi selecionada! Tenta novamente');
                     </script>";
        }

        $content = View::render('configuracao/perfil/formPerfil', [
            'titulo' => 'Cadastrar Perfil de Acesso e Permissão',
            'button' => 'Salvar',
            'msg1' => $alert,
            'msg' => self::exibeMensagem($request),
            'item' => self::getPerfil($request, $obPagination),

        ]);
        return parent::getPage('Atribuir Acesso e Permissões', $content);
    }


    // Método que apresenta edita o perfil de acesso
    public static function editarPermissao($request, $id_Nivel)
    {
        $postVars = $request->getPostVars();
        $codigos = []; // Guarda os codigo da permissao 
        $nomes = []; // Guarda os nomes da permissao S
        $IdPermissao = [];
        $IdPermissaoSelecionado = [];

        // Busca o nivel por  id 
        $obNivelSelecionado = NivelDao::getNivelId($id_Nivel);
        // Instancia os nivel e permissao feita
        $obPermisaoNivel = new NivelPermissaoDao;

        // faz a listagem do tabela permissão para o formulario
        $resultado = PermissaoDao::listarPermissao();
        while ($obPermisao = $resultado->fetchObject(PermissaoDao::class)) {
            $IdPermissao[] = $obPermisao->id_permissao;
            $codigos[] = $obPermisao->codigo_permisao;
            $nomes[] = $obPermisao->nome_permissao;
        }

        // Marca as permissoes correspondente ao nivel   
        $resultado1 = NivelPermissaoDao::getNivelPermissaoID($id_Nivel);
        while ($obnivelPermisao = $resultado1->fetchObject(NivelPermissaoDao::class)) {
            $IdPermissaoSelecionado[] = $obnivelPermisao->id_permissoes;
        }

        // Verifica se os inputs foi Repreenchido e atualiza o nivel 
        if (isset($_POST['nome'], $_POST['descrisao'])) {
            $obNivelSelecionado->nome_nivel = $postVars['nome'] ?? $obNivelSelecionado->nome_nivel;
            $obNivelSelecionado->serie_nivel = $postVars['serie'];
            $obNivelSelecionado->descricao_nivel = $postVars['descrisao'] ?? $obNivelSelecionado->descricao_nivel;
            $obNivelSelecionado->atualizarNivel();
        }

        // Verifica se foi salvo as alteraçoes e apaga as permissoes antiga
        if (isset($_POST['cadastrar'])) {
            $obPermisaoNivelId =  NivelPermissaoDao::getNivelPermissaoID($id_Nivel)->fetchObject(NivelPermissaoDao::class);
            $obPermisaoNivelId->apagarNivelPermissao($id_Nivel);
            echo '<pre>';
            print_r("aqui");
            echo '</pre>';
        }

        //Verifica se existem checkboxes marcados
        if (!empty($_POST['codigo_permisao'])) {
            foreach ($_POST['codigo_permisao'] as $valor) {
                $obPermisaoNivel->id_nivel = $id_Nivel;
                $obPermisaoNivel->id_permissoes = $valor;
                $obPermisaoNivel->addPermissao();
            }
            $request->getRouter()->redirect('/perfil?msg=alterado  ');
        }

        $content = View::render('configuracao/perfil/formPerfilEditar', [

            'titulo' => 'Atualizar Acesso e Permissões',
            'button' => 'Salvar',

            'nome' => $obNivelSelecionado->nome_nivel,
            'serie' => '*****',
            'descrisao' => $obNivelSelecionado->descricao_nivel,

            'DATABASE_VIEW' => $IdPermissao[7],
            'REGISTROS_DELETE' => $IdPermissao[1],
            'IMPORT_DATABASE_VIEW' => $IdPermissao[8],

            'LABORATORIO_ACESS' => $IdPermissao[9],
            'EXAME_ACESS' => $IdPermissao[10],
            'EXAME_CREATE' => $IdPermissao[11],
            'EXAME_RESULT' => $IdPermissao[12],
            'EXAME_SOLICITACAO' => $IdPermissao[13],
            'EXAME_AGENDAR' => $IdPermissao[14],

            'USER_VIEW' => $IdPermissao[15],
            'USER_PERFIL_VIEW' => $IdPermissao[16],
            'CREATE_SERVICE' => $IdPermissao[17],
            'PERSONALIZAR' => $IdPermissao[18],
            'AGENDAR' => $IdPermissao[19],

            'FARMACIA_ACESS' => $IdPermissao[20],
            'MEDICAMENTO_CREATE' => $IdPermissao[21],
            'FORNECEDOR_VIEW' => $IdPermissao[22],
            'GERIR_ESTOQUE_VIEW' => $IdPermissao[23],
            'RECEPÇAO' => $IdPermissao[24],

            'TESORARIA_ACESS' => $IdPermissao[25],
            'CAIXA_VIEW' => $IdPermissao[26],
            'PAGAMENTO_VIEW' => $IdPermissao[27],
            'SALFT' => $IdPermissao[28],

            'PACIENTE_CREATE' => $IdPermissao[29],
            'INTERNAMENTO_VIEW' => $IdPermissao[30],
            'TRANSFERIR_VIEW' => $IdPermissao[31],
            'CONSULTA_VIEW' => $IdPermissao[32],
            'MARCAR_CONSULTA_VIEW' => $IdPermissao[33],
            'EXAME_VIEW' => $IdPermissao[34],
            'ATENDIMENTO_VIEW' => $IdPermissao[35],

            //_________________________________________________________________________________

            'database_view1' => in_array($IdPermissao[7], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'registros_delete1' => in_array($IdPermissao[1], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'import_database_view1' => in_array($IdPermissao[8], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',

            'laboratorio_acess1' => in_array($IdPermissao[9], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'exame_acess1' => in_array($IdPermissao[10], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'exame_create1' => in_array($IdPermissao[11], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'exame_result1' => in_array($IdPermissao[12], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'exame_solicitacao1' => in_array($IdPermissao[13], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'exame_agendar1' => in_array($IdPermissao[14], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',

            'user_view1' => in_array($IdPermissao[15], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'user_perfil_view1' => in_array($IdPermissao[16], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'create_service1' => in_array($IdPermissao[17], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'personalizar1' => in_array($IdPermissao[18], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'agendar1' => in_array($IdPermissao[19], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',

            'farmacia_acess1' => in_array($IdPermissao[20], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'medicamento_create1' => in_array($IdPermissao[21], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'fornecedor_view1' => in_array($IdPermissao[22], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'gerir_estoque_view1' => in_array($IdPermissao[23], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'recepcao1' => in_array($IdPermissao[24], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',

            'tesoraria_acess1' => in_array($IdPermissao[25], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'caixa_view1' => in_array($IdPermissao[26], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'pagamento_view1' => in_array($IdPermissao[27], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'salft1' => in_array($IdPermissao[28], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',

            'paciente_create1' => in_array($IdPermissao[29], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'internamento_view1' => in_array($IdPermissao[30], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'transferir_view1' => in_array($IdPermissao[31], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'consulta_view1' => in_array($IdPermissao[32], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'marcar_consulta_view1' => in_array($IdPermissao[33], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'exame_view1' => in_array($IdPermissao[34], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',
            'atendimento_view1' => in_array($IdPermissao[35], $IdPermissaoSelecionado, true)  ? ' checked="" ' : '',

        ]);

        return parent::getPage('Editar Acesso e Permissao', $content);
    }

    // Método para apagar perfil de acesso
    public static function apagarPerfil($request, $id_nivel)
    {
        $postVars = $request->getPostVars();
        // Busca o nivel por  id 
        $obNivelSelecionado = NivelDao::getNivelId($id_nivel);

        if (isset($_POST['Salvar'], $_POST['confirmo'])) {
            // Apaga o nivel
            $obNivelSelecionado->apagarNivel();
            $request->getRouter()->redirect('/perfil?msg=apagado');
        } else {
            $request->getRouter()->redirect('/perfil?msg=confirma');
        }
    }

}
