<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Http\Request;
use \App\Model\Entity\FuncionarioDao;
use \App\Model\Entity\NivelDao;
use \App\Utils\Pagination;

class Page
{

    //pega os dados do usuario logado no momento
    public static function getFuncionarioLogado($obFuncionario)
    {
        $dados = '';
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];
        $nome = $funcionarioLogado['nome'];
        $nivel = $funcionarioLogado['nivel'];

        //Busca o Funcionario por id
        $obFuncionario = FuncionarioDao::getFuncionarioId($id);

        $dados .= View::render('Layouts/dadoslogado', [
            'nome' => $nome,
            'imagem' => $obFuncionario->imagem_funcionario,

        ]);

        return View::render('Layouts/itemdados', [
            'links' => $dados,
        ]);
    }

    //metodo para buscar header principal
    public static function setVerificarPermissao($obFuncionario)
    {
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];
        $resultado = NivelDao::VerificarNivel1($id);
        $permissoes = array_column($resultado, "codigo_permisao");

        print_r($permissoes);

        $mensagem = in_array("TRIAGEM_UPDATE", $permissoes)
            ? "Usuário pode editar triagem"
            : "Sem permissão";

        echo '<pre>';
        print_r($mensagem);
        echo '</pre>';
        exit;
    }

    /** Função para mostrar a paginacao 
     *@param Request $request
     *@param Pagination $obPagination
     *@return string
     */
    public static function getPaginacao($request, &$obPagination)
    {
        // get actual
        $queryParam = $request->getQueryParams();

        //remove o get de mensagem
        unset($queryParam['msg']);

        $pages = $obPagination->getPages();

        if (count($pages) <= 1) return '';

        $links = '';

        // URL atual completa
        $url = $request->getRouter()->getCurrentUrl();

        //Renderiza os links
        foreach ($pages as $page) {

            $queryParam['page'] = $page['page'];

            //links 
            $link = $url . '?' . http_build_query($queryParam);

            // rederiz os links na pagina user
            $links .= View::render('Paginacao/link', [
                'pagina' => $page['page'],
                'link' => $link,
                'activo' => $page['current'] ? 'active' : ''
            ]);
        }
        return View::render('Paginacao/box', [
            'links' => $links
        ]);
    }

    //metodo para buscar header principal
    public static function getHeader($obFuncionario)
    {
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];
        $resultado = NivelDao::VerificarNivel1($id);
        $permissoes = array_column($resultado, "codigo_permisao");

        // busca o usuario po id
        $obUsuario = FuncionarioDao::getFuncionarioId($id);

        return View::render('Layouts/header', [
            'info' => self::getFuncionarioLogado($obFuncionario),
            'nome1' => $obUsuario->nome_funcionario,

            'acessoConsulta' => in_array("TRIAGEM_UPDATE", $permissoes) ? "Com permissão" : "disabled-link",
            'acessoTriagem' => in_array("TRIAGEM_UPDATE", $permissoes) ? "Com permissão" : "disabled-link",
            'acessoCadastrameto' => in_array("TRIAGEM_UPDATE", $permissoes) ? "Com permissão" : "disabled-link",
            'acessoRelatorio' => in_array("TRIAGEM_UPDATE", $permissoes) ? "Com permissão" : "disabled-link",
            'acessoLaboratorio' => in_array("TRIAGEM_UPDATE", $permissoes) ? "Com permissão" : "disabled-link",
            'acessoRelatorio' => in_array("TRIAGEM_UPDATE", $permissoes) ? "Com permissão" : "disabled-link",
            'acessoTesouraria' => in_array("TRIAGEM_UPDATE", $permissoes) ? "Com permissão " : "disabled-link",
            'acessoFarmacia' => in_array("FARMACIA_VIEW", $permissoes) ? "Com permissão" : "disabled-link",

            'DATABASE_VIEW'        => in_array("DATABASE_VIEW", $permissoes) ? "Com permissão " : "disabled-link",
            'REGISTROS_DELETE'        => in_array("REGISTROS_DELETE", $permissoes) ? "Com permissão " : "disabled-link",
            'IMPORT_DATABASE_VIEW' => in_array("IMPORT_DATABASE_VIEW", $permissoes) ? "Com permissão " : "disabled-link",

            'LABORATORIO_ACESS'    => in_array("LABORATORIO_ACESS", $permissoes) ? "com permissao" : "disabled-link",
            'EXAME_ACESS'          => in_array("EXAME_ACESS", $permissoes) ? "Com permissão" : "disabled-link",
            'EXAME_CREATE'         => in_array("EXAME_CREATE", $permissoes) ? "Com permissão " : "disabled-link",
            'EXAME_RESULT'         => in_array("EXAME_RESULT", $permissoes) ? "Com permissão" : "disabled-link",
            'EXAME_SOLICITACAO'    => in_array("EXAME_SOLICITACAO", $permissoes) ? "Com permissão" : "disabled-link",
            'EXAME_AGENDAR'        => in_array("EXAME_AGENDAR", $permissoes) ? "Com permissão " : "disabled-link",

            'USER_VIEW'            => in_array("USER_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'USER_PERFIL_VIEW'     => in_array("USER_PERFIL_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'CREATE_SERVICE'       => in_array("CREATE_SERVICE", $permissoes) ? "Com permissão" : "disabled-link",
            'PERSONALIZAR'         => in_array("PERSONALIZAR", $permissoes) ? "Com permissão" : "disabled-link",
            'AGENDAR'              => in_array("AGENDAR", $permissoes) ? "Com permissão" : "disabled-link",

            'FARMACIA_ACESS'       => in_array("FARMACIA_ACESS", $permissoes) ? "Com permissão" : "disabled-link",
            'MEDICAMENTO_CREATE'   => in_array("MEDICAMENTO_CREATE", $permissoes) ? "Com permissão" : "disabled-link",
            'FORNECEDOR_VIEW'      => in_array("FORNECEDOR_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'GERIR_ESTOQUE_VIEW'   => in_array("GERIR_ESTOQUE_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'RECEPÇAO'             => in_array("RECEPÇAO", $permissoes) ? "Com permissão" : "disabled-link",

            'TESORARIA_ACESS'      => in_array("TESORARIA_ACESS", $permissoes) ? "Com permissão" : "disabled-link",
            'CAIXA_VIEW'           => in_array("CAIXA_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'PAGAMENTO_VIEW'       => in_array("PAGAMENTO_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'SALFT'                => in_array("SALFT", $permissoes) ? "Com permissão" : "disabled-link",

            'PACIENTE_CREATE'      => in_array("PACIENTE_CREATE", $permissoes) ? "Com permissão" : "disabled-link",
            'INTERNAMENTO_VIEW'    => in_array("INTERNAMENTO_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'TRANSFERIR_VIEW'      => in_array("TRANSFERIR_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'CONSULTA_VIEW'        => in_array("CONSULTA_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'MARCAR_CONSULTA_VIEW' => in_array("MARCAR_CONSULTA_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'EXAME_VIEW'           => in_array("EXAME_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
            'ATENDIMENTO_VIEW'     => in_array("ATENDIMENTO_VIEW", $permissoes) ? "Com permissão" : "disabled-link",
        ]);
    }


    //metodo busca footer
    public static function getFooter()
    {
        $funcionarioLogado = Session::getUsuarioLogado();
        $id = $funcionarioLogado['id'];
        // busca o usuario po id
        $obUsuario = FuncionarioDao::getFuncionarioId($id);

        return View::render('Layouts/footer', [
            'nome' => $obUsuario->nome_funcionario,
        ]);
    }

    /** 
     * PAGE para header e Home para Home
     * Metodo busca header da Pagina Home usuario ADIMIM
     * 
     * */
    public static function getHeaderAdmin($obFuncionario)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        return View::render('Layouts/headerMedico', [
            'info' => self::getFuncionarioLogado($obFuncionario),
            'pesquisar' => $buscar,
        ]);
    }

    //metodo busca header do balcao
    public static function headerMedico($obFuncionario)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        return View::render('Layouts/headerMedico', [
            'info' => self::getFuncionarioLogado($obFuncionario),
            'pesquisar' => $buscar,
        ]);
    }

    //metodo busca header dados
    public static function headerDados($obUsuario)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        return View::render('Layouts/headerDados', [
            'info' => self::getFuncionarioLogado($obUsuario),
            'pesquisar' => $buscar,
        ]);
    }


    //metodo que renderiza layouts da pagina
    public static function getPage($title, $content)
    {
        return View::render('Layouts/pagina', [
            'title' => $title,
            'header' => Self::getHeader(null),
            'content' => $content,
            'footer' => Self::getFooter()
        ]);
    }

    //metodo que renderiza layouts pagina home adim
    public static function getPageHome($title, $content)
    {
        return View::render('Layouts/pagina', [
            'title' => $title,
            'header' => Self::getHeaderAdmin(null),
            'content' => $content,
            'footer' => Self::getFooter()
        ]);
    }

    //metodo que renderiza layouts pagina home balcao
    public static function getHeaderMedico($title, $content)
    {
        return View::render('Layouts/pagina', [
            'title' => $title,
            'header' => Self::headerMedico(null),
            'content' => $content,
            'footer' => Self::getFooter()
        ]);
    }

    //metodo que renderiza layouts pagina home dados
    public static function getHeaderDados($title, $content)
    {
        return View::render('Layouts/pagina', [
            'title' => $title,
            'header' => Self::headerDados(null),
            'content' => $content,
            'footer' => Self::getFooter()
        ]);
    }

    // metodo para rederizar a pagina de login
    public static function getPageLogin($title, $content, $red)
    {
        return View::render('login/pagina', [
            'title' => $title,
            'content' => $content,
            'red' => $red,
        ]);
    }

    // Método para rederizar a página Site
    public static function getPageSite($title, $content)
    {
        return View::render('site/index', [
            'title' => $title,
            'content' => $content
        ]);
    }
}
