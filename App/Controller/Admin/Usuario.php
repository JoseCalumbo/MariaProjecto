<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\SessionAdmin;
use \App\Utils\Upload;
use \App\Http\Request;
use \App\Model\Entity\AdmimUserDao;
use \App\Controller\Mensagem\MensagemAdmin;



class Usuario extends PageAdmin
{

    /** Metodo para exibir  a mensagem 
     *@param Request $request
     *@return string
     */
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg']))
            return '';
        switch ($queryParam['msg']) {
            case 'cadastrado':
                return MensagemAdmin::msgSucesso('Usuario Cadastrado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Usuario Alterado com sucesso');
                break;
            case 'apagado':
                return MensagemAdmin::msgSucesso('Usuario Apagdo com sucesso');
                break;
            case 'nivel':
                return MensagemAdmin::msgAlerta('Imponssivel Apagar o tua conta deste modo');
                break;
            case 'confirma':
                return MensagemAdmin::msgAlerta('Confirma a tua ação antes de Apagar');
                break;
        }// fim do switch
        return true;
    }

    // Metodo para apresenatar os registos dos dados 
    private static function getUsuario($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = AdmimUserDao::listarUsuario($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        $resultado = AdmimUserDao::listarUsuario($where, 'nome', $obPagination->getLimit());

        while ($obUsuario = $resultado->fetchObject(AdmimUserDao::class)) {

            $item .= View::renderAdmin('usuario/listarUsuario', [
                'id' => $obUsuario->id,
                'imagem' => $obUsuario->imagem,
                'nome' => $obUsuario->nome,
                'email' => $obUsuario->email,
                'telefone' => $obUsuario->telefone,
                'cargo' => $obUsuario->nivel,
                'Registro' => $obUsuario->criado
            ]);
        }

        // Verifica se foi realizada uma pesquisa
        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::renderAdmin('pesquisar/box_resultado', [
                'pesquisa' => $buscar,
                'item' => $item,
                'numResultado' => $quantidadetotal,
            ]);
        }

        return $item;
    }

    // Metodo que apresenta a tela de usuario
    public static function getTelaUsuario($request)
    {

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $content = View::renderAdmin('usuario/usuario', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getUsuario($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);

        return parent::getPageAdmin('Admin - Painel Usuario', $content);
    }

    // Metodo que cadastra usuario 
    public static function CadastrarUsuario($request)
    {

        $obUsuario = new AdmimUserDao;

        if (isset($_POST['nome'], $_POST['telefone'], $_POST['genero'], $_POST['email'], $_POST['nivel'], $_POST['morada'], $_FILES['imagem'])) {


            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obUsuario->nome = $_POST['nome'];
                $obUsuario->genero = $_POST['genero'];
                $obUsuario->email = $_POST['email'];
                $obUsuario->telefone = $_POST['telefone'];
                $obUsuario->nivel = $_POST['nivel'];
                $obUsuario->morada = $_POST['morada'];
                $obUsuario->senha = password_hash($_POST['nome'], PASSWORD_DEFAULT);
                $obUsuario->imagem = 'anonimo.png';
                $obUsuario->cadastrar();

                $request->getRouter()->redirect('/usuario?msg=cadastrado');
                exit;
            }

            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obUsuario->nome = $_POST['nome'];
            $obUsuario->genero = $_POST['genero'];
            $obUsuario->email = $_POST['email'];
            $obUsuario->telefone = $_POST['telefone'];
            $obUsuario->nivel = $_POST['nivel'];
            $obUsuario->morada = $_POST['morada'];
            $obUsuario->senha = password_hash($_POST['nome'], PASSWORD_DEFAULT);
            $obUsuario->imagem = $obUpload->getBaseName();

            $obUsuario->cadastrar();

            if ($sucess) {
                $request->getRouter()->redirect('/usuario?msg=cadastrado');
                exit;
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        $content = View::renderAdmin('usuario/formUsuario', [
            'titulo' => 'Cadastrar Novo Usuario',
            'button' => 'Cadastrar',
            'msg' => '',
            'nome' => '',
            'genero' => '',
            'morada' => '',
            'email' => '',
            'telefone' => '',
            'nivel' => '',
            'imagem' => 'anonimo.png'

        ]);

        return parent::getPageAdmin('Admin- Cadastrar Usuario', $content);
    }

    // metodo para ir na pagina editar usuario
    public static function getAtualizarUsuario($request, $id)
    {
        $obUsuario = AdmimUserDao::getAdminUserId($id);
        $content = View::renderAdmin('usuario/formUsuario', [
            'titulo' => ' Actualizar dados de  Usuario',
            'button' => 'Actulizar',
            'msg' => '',
            'nome' => $obUsuario->nome,
            'morada' => $obUsuario->morada,
            'email' => $obUsuario->email,
            'telefone' => $obUsuario->telefone,
            'masculino' => $obUsuario->genero == 'Masculino' ? 'selected' : '',
            'feminino' => $obUsuario->genero == 'Feminino' ? 'selected' : '',
            'nivelAdmin' => $obUsuario->nivel == 'Administrador' ? 'selected' : '',
            'nivelNormal' => $obUsuario->nivel == 'Normal' ? 'selected' : '',
            'nivelVisitante' => $obUsuario->nivel == 'Visitante' ? 'selected' : '',
            'imagem' => $obUsuario->imagem,
        ]);

        return parent::getPageAdmin('Admin Usuario', $content);
    }

    // Metodo para editar usuario
    public static function setAtualizarUsuario($request, $id)
    {
        $obUsuario = AdmimUserDao::getAdminUserId($id);

        if (isset($_POST['nome'], $_POST['telefone'], $_POST['genero'], $_POST['email'], $_POST['nivel'], $_POST['morada'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {

                $obUsuario->nome = $_POST['nome'] ?? $obUsuario->nome;
                $obUsuario->genero = $_POST['genero'] ?? $obUsuario->genero;
                $obUsuario->email = $_POST['email'] ?? $obUsuario->email;
                $obUsuario->telefone = $_POST['telefone'] ?? $obUsuario->telefone;
                $obUsuario->nivel = $_POST['nivel'] ?? $obUsuario->nivel;
                $obUsuario->morada = $_POST['morada'] ?? $obUsuario->morada;
                $obUsuario->imagem = 'anonimo.png' != null ? $obUsuario->imagem : 'anonimo.png';

                $obUsuario->atualizar();

                $request->getRouter()->redirect('/usuario?msg=alterado');
                exit;
            }
            $sucess = $obUpload->upload(LOCAL_URL . '/Files/Imagem/user', false);

            $obUsuario->nome = $_POST['nome'] ?? $obUsuario->nome;
            $obUsuario->genero = $_POST['genero'] ?? $obUsuario->genero;
            $obUsuario->email = $_POST['email'] ?? $obUsuario->email;
            $obUsuario->telefone = $_POST['telefone'] ?? $obUsuario->telefone;
            $obUsuario->nivel = $_POST['nivel'] ?? $obUsuario->nivel;
            $obUsuario->morada = $_POST['morada'] ?? $obUsuario->morada;
            $obUsuario->imagem = $obUpload->getBaseName() ?? $obUsuario->imagem;

            $obUsuario->atualizar();

            $request->getRouter()->redirect('/usuario?msg=alterado');


            if ($sucess) {
                $request->getRouter()->redirect('/usuario?msg=alterado');

            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        $content = View::renderAdmin('usuario/formUsuario', []);

        return parent::getPageAdmin('Cadastrar Usuario', $content);
    }

    // Metodo para apagar usuario
    public static function setapagarUser($request, $id)
    {
        // Busca o usuario logado no sistema
        $usuarioLogado = SessionAdmin::getAdminUserLogado();
        $idLogado = $usuarioLogado['id'];
        $nivel = $usuarioLogado['nivel'];

        if ($nivel == "Administrador") {

            $confirmo = $_POST['confirmo'] ?? "";
            $cancelar = $_POST['cancelar'] ?? "";

            // Verifica se o usuario clicou em cancelar
            if ($cancelar == "cancelar") {
                $request->getRouter()->redirect('/usuario');
                exit;
            }

            // Verifica qual é o id do usuario logado
            if ($idLogado == $id) {
                $request->getRouter()->redirect('/usuario?msg=nivel');
                exit;
            }

            // Verifica se o usuario confirmou o operaçao
            if (!$confirmo == "on") {
                $request->getRouter()->redirect('/usuario?msg=confirma');
                exit;
            }

            $obUsuario = AdmimUserDao::getAdminUserId($id);
            $obUsuario->apagar();
            $request->getRouter()->redirect('/usuario?msg=apagado');

        } else {
            $request->getRouter()->redirect('/usuario?msg=confirma');
            exit;
        }
    }

}



