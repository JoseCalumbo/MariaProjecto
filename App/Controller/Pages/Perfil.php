<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\FuncionarioDao;
use \App\Utils\Pagination;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\NivelPermissaoDao;
use App\Model\Entity\PermissaoDao;

class Perfil extends Page
{

    // exibe a messagem de operacao
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Vendedor Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Vendedor Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Vendedor Apagdo com sucesso');
                break;
        } // fim do switch
    }

    // Método para apresenatar os registos dos Funcionario
    private static function getPerfil($request, &$obPagination)
    {

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_funcionario LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = FuncionarioDao::listarFuncionario($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 11);

        $resultado = FuncionarioDao::listarFuncionario($where, 'nome_funcionario ', $obPagination->getLimit());


        while ($obFuncionario = $resultado->fetchObject(FuncionarioDao::class)) {
            $item .= View::render('configuracao/user/listarPerfil', [
                'id_funcionario' => $obFuncionario->id_funcionario,
                'imagem' => $obFuncionario->imagem_funcionario,
                'nome' => $obFuncionario->nome_funcionario,
                'genero' => $obFuncionario->genero_funcionario,
                'telefone' => $obFuncionario->telefone1_funcionario,
                'email' => $obFuncionario->email_funcionario,
                'cargo' => $obFuncionario->cargo_funcionario,
                'numero' => $obFuncionario->numeroordem_funcionario,
                'dataRegistro' => $obFuncionario->registrado
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
        $content = View::render('configuracao/user/perfilUtilizador', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getPerfil($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Perfil de Acesso', $content);
    }

    // Método que apresenta cadastrar o perfil de acesso
    public static function getFormPermisao($request)
    {
        $item = '';
        $codigos = [];
        $IDcodigos = [];

        $resultado = PermissaoDao::listarPermissao();

        while ($obPermisao = $resultado->fetchObject(PermissaoDao::class)) {
            $codigos[] = $obPermisao->codigo_permisao;
        }
        return $codigos;
    }


    // Método que apresenta cadastrar o perfil de acesso
    public static function cadastrarPerfil($request)
    {

        $codigos = [];
        $nomes = [];
        $IdPermissao = [];

        $resultado = PermissaoDao::listarPermissao();

        while ($obPermisao = $resultado->fetchObject(PermissaoDao::class)) {
            $codigos[] = $obPermisao->codigo_permisao;
            $nomes[] = $obPermisao->nome_permissao;
            $IdPermissao[] = $obPermisao->id_permissao;
        }

        /*   echo '<pre>';
        print_r($codigos);
        print_r($IdPermissao);
        print_r($nomes[8]);
        echo '</pre>';*/


        $resultado = PermissaoDao::listarPermissao()->fetchObject(PermissaoDao::class);

        $content = View::render('configuracao/user/formPerfil', [
            'titulo' => 'Cadastrar Perfil de Acesso e Permissão',
            'button' => 'Salvar',
            'msg' => self::exibeMensagem($request),


            'DATABASE_VIEW' => $IdPermissao[0],
            'IMPORT_DATABASE_VIEW' => $IdPermissao[1],

            'LABORATORIO_ACESS' => $IdPermissao[2],
            'EXAME_ACESS' => $IdPermissao[2],
            'EXAME_CREATE' => $IdPermissao[2],
            'EXAME_RESULT' => $IdPermissao[2],
            'EXAME_SOLICITACAO' => $IdPermissao[2],
            'EXAME_AGENDAR' => $IdPermissao[2],

            'USER_VIEW' => $IdPermissao[2],
            'USER_PERFIL_VIEW' => $IdPermissao[2],
            'CREATE_SERVICE' => $IdPermissao[2],
            'PERSONALIZAR' => $IdPermissao[2],
            'AGENDAR' => $IdPermissao[2],

            'FARMACIA_ACESS' => $IdPermissao[2],
            'MEDICAMENTO_CREATE' => $IdPermissao[2],
            'FORNECEDOR_VIEW' => $IdPermissao[2],
            'GERIR_ESTOQUE_VIEW' => $IdPermissao[2],
            'RECEPÇAO' => $IdPermissao[2],

            'TESORARIA_ACESS' => $IdPermissao[2],
            'CAIXA_VIEW' => $IdPermissao[2],
            'PAGAMENTO_VIEW' => $IdPermissao[2],
            'SALFT' => $IdPermissao[2],

            'PACIENTE_CREATE' => $IdPermissao[2],
            'INTERNAMENTO_VIEW' => $IdPermissao[2],
            'TRANSFERIR_VIEW' => $IdPermissao[2],
            'CONSULTA_VIEW' => $IdPermissao[2],
            'MARCAR_CONSULTA_VIEW' => $IdPermissao[2],
            'EXAME_VIEW' => $IdPermissao[2],
            'ATENDIMENTO_VIEW' => $IdPermissao[2],

            /*
            'FARMACIA_VIEW' => $nomes[1],
            'FARMACIA_VIEW' => $nomes[2],
            'FARMACIA_VIEW' => $nomes[3],
            'FARMACIA_VIEW' => $nomes[3],
            'FARMACIA_VIEW' => $nomes[4],
            'FARMACIA_VIEW' => $nomes[5],
            'FARMACIA_VIEW' => $nomes[6],
            'FARMACIA_VIEW' => $nomes[7],
            'FARMACIA_VIEW' => $nomes[8],
            'FARMACIA_VIEW' => $nomes[9],
            'FARMACIA_VIEW' => $nomes[10],
            'FARMACIA_VIEW' => $nomes[11],
            'FARMACIA_VIEW' => $nomes[12],
            'FARMACIA_VIEW' => $nomes[13],
            'FARMACIA_VIEW' => $nomes[14],
            'FARMACIA_VIEW' => $nomes[15],
            'FARMACIA_VIEW' => $nomes[16],
            'FARMACIA_VIEW' => $nomes[16],
            'FARMACIA_VIEW' => $nomes[17],
            'FARMACIA_VIEW' => codigo[11],
            'FARMACIA_VIEW' => $nomes[19],
            'FARMACIA_VIEW' => $nomes[20],
            'FARMACIA_VIEW' => $nomes[20],
            'FARMACIA_VIEW' => $nomes[21],
            'FARMACIA_VIEW' => $nomes[22],
            'FARMACIA_VIEW' => $nomes[23],
            'FARMACIA_VIEW' => $nomes[24],
            'FARMACIA_VIEW' => $nomes[25],
            */

        ]);
        return parent::getPage('Cadastramento Perfil de Acesso', $content);
    }



    // Método que apresenta cadastrar o perfil de acesso
    public static function setCadastrarPerfil($request)
    {
        $postVars = $request->getPostVars();

        $obPermisao = new NivelPermissaoDao;

        /* 
        echo '<pre>';
        print_r($postVars);
        echo '</pre>';
        exit;
        */

        // Verifica se existem checkboxes marcados
        if (!empty($_POST['codigo_permisao'])) {
            // $stmt = $conn->prepare("INSERT INTO selecionados (opcao) VALUES (?)");

            foreach ($_POST['codigo_permisao'] as $valor) {
                //   $stmt->bind_param("s", $valor);
                // $stmt->execute();

                echo '<pre>';
                print_r($valor);
                echo '</pre>';

                $obPermisao->id_permissao = $valor;
                $obPermisao->addPermissao();
            }

            echo '<pre>';
            print_r($postVars);
            echo '</pre>';
            exit;

            echo "Opções selecionadas foram salvas!";
        } else {
            echo "Nenhuma opção foi selecionada!";
        }

        $content = View::render('configuracao/user/formPerfil', [
            'titulo' => 'Cadastrar Perfil de Acesso e Permissão',
            'button' => 'Salvar',
            'msg' => self::exibeMensagem($request),
            'item' => self::getPerfil($request, $obPagination),

        ]);
        return parent::getPage('Cadastramento Perfil de Acesso', $content);
    }
}
