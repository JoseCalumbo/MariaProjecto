<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Model\Entity\UsuarioDao;
use \App\Utils\Pagination;


Class Page{

    //pega os dados do usuario logado no momento
    public static function getUsuarioLogado($obUsuario){

        $dados = '';

        $usuarioLogado = Session::getUsuarioLogado();
        
        $id=$usuarioLogado['id_us'];
        $nome=$usuarioLogado['nome_us'];
        $nivel=$usuarioLogado['nivel_us'];

        $obUsuario = UsuarioDao::getUsuarioId($id);

        $dados .= View::render('Layouts/dadoslogado',[
            'nome'=>$nome,
            'imagem'=>$obUsuario->imagem_us,
            'nivel'=>$nivel,
        ]);

        return View::render('Layouts/itemdados',[
            'links'=>$dados,
       ]);
    }


    /**
       * Função para mostrar a paginacao 
       *@param Request $request
       *@param Paginacao $obPagination
       *@return string
    */
    public static function getPaginacao($request,$obPagination){
        // get actual
        $queryParam = $request->getQueryParams();

        //remove o get de mensagem
        unset($queryParam['msg']);

         $pages = $obPagination->getPages(); 

         if(count($pages) <= 1) return '';
         
         $links = '';

         // URL atual completa
         $url = $request->getRouter()->getCurrentUrl();

        //Renderiza os links
        foreach($pages as $page){

           $queryParam['page'] = $page['page'];

            //links 
            $link = $url.'?'.http_build_query($queryParam);

            // rederiz os links na pagina user
            $links .= View::render('Paginacao/link',[
                'pagina' => $page['page'],
                'link'=> $link,
                'activo'=>$page['current'] ? 'active' : ''
            ]);
        }
        return View::render('Paginacao/box',[
             'links'=>$links
        ]);
    }

    //metodo busca header
    public static function getHeader($obUsuario){
        return View::render('Layouts/header',[
            'info'=> self::getUsuarioLogado($obUsuario)
        ]);
    }

    //metodo busca footer
    public static function getFooter(){
        return View::render('Layouts/footer');
    }

    //metodo busca header da Pagina Home
    public static function getHeaderHome($obUsuario){
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        return View::render('Layouts/headerHome',[
            'info'=> self::getUsuarioLogado($obUsuario),
            'pesquisar' => $buscar,
        ]);
    }

    //metodo busca header do balcao
    public static function headerBalcao($obUsuario){
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        return View::render('Layouts/headerBalcao',[
            'info'=> self::getUsuarioLogado($obUsuario),
            'pesquisar' => $buscar,
        ]);
    }
    //metodo busca header dados
    public static function headerGestaoDados($obUsuario){
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        return View::render('Layouts/headerGestaoDados',[
            'info'=> self::getUsuarioLogado($obUsuario),
            'pesquisar' => $buscar,
        ]);
    }
    //metodo busca header do Finaceiro
    public static function headerGestaoFinaceiro($obUsuario){
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        return View::render('Layouts/headerGestaoFinaceiro',[
            'info'=> self::getUsuarioLogado($obUsuario),
            'pesquisar' => $buscar,
        ]);
    }

    //metodo que renderiza layouts da pagina
    public static function getPage($title,$content){
        return View::render('Layouts/pagina',[
            'title' => $title,
            'header'=>Self::getHeader(null),
            'content'=> $content,
            'footer'=>Self::getFooter()
        ]);
    }

    //metodo que renderiza layouts pagina home
    public static function getPageHome($title,$content){
        return View::render('Layouts/pagina',[
            'title' => $title,
            'header'=>Self::getHeaderHome(null),
            'content'=> $content,
            'footer'=>Self::getFooter()
        ]);
    }

    //metodo que renderiza layouts pagina home balcao
    public static function getHeaderBalcao($title,$content){
        return View::render('Layouts/pagina',[
            'title' => $title,
            'header'=>Self::headerBalcao(null),
            'content'=> $content,
            'footer'=>Self::getFooter()
        ]);
    }

    //metodo que renderiza layouts pagina home dados
    public static function getHeaderDados($title,$content){
        return View::render('Layouts/pagina',[
            'title' => $title,
            'header'=>Self::headerGestaoDados(null),
            'content'=> $content,
            'footer'=>Self::getFooter()
        ]);
    }
    //metodo que renderiza layouts pagina home finaceiro
    public static function getHeaderFinaceiro($title,$content){
        return View::render('Layouts/pagina',[
            'title' => $title,
            'header'=>Self::headerGestaoFinaceiro(null),
            'content'=> $content,
            'footer'=>Self::getFooter()
        ]);
    }

    // metodo para rederizar a pagina de login
    public static function getPageLogin($title,$content,$red){
        return View::render('login/pagina',[
            'title' => $title,
            'content'=> $content,
            'red'=>$red,
        ]);
    }
}