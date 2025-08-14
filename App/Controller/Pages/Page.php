<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Http\Request;
use \App\Model\Entity\FuncionarioDao;
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

    /** Função para mostrar a paginacao 
     *@param Request $request
     *@param Pagination $obPagination
     *@return string
     */
    public static function getPaginacao($request, $obPagination)
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
        //Buscar o Funcionario por id
        $obFuncionarioAgora = FuncionarioDao::getFuncionarioId($id);

        return View::render('Layouts/header', [
            'info' => self::getFuncionarioLogado($obFuncionario),
            'acessoTriagem' => $obFuncionarioAgora->cargo_funcionario == 'Médico' ? 'disabled-link' : '',
            'acessoConsuta' => $obFuncionarioAgora->cargo_funcionario != 'Administrador' ? 'disabled-link' : '',
            'acessoCadastrar' => $obFuncionarioAgora->cargo_funcionario != 'Administrador' ? 'disabled-link' : '',
            'acessoRelatorio' => $obFuncionarioAgora->cargo_funcionario != 'Administrador' ? 'disabled-link' : '',
            'acessoLaboratorio' => $obFuncionarioAgora->cargo_funcionario != 'Administrador' ? 'disabled-link' : '',
            'acessoFarmacia' => $obFuncionarioAgora->cargo_funcionario != 'Administrador' ? 'disabled-link' : '',
        ]);
    }

    //metodo busca footer
    public static function getFooter()
    {
        return View::render('Layouts/footer');
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
