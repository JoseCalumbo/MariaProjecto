<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Utils\SessionAdmin;
use \App\Http\Request;
use \App\Model\Entity\AdmimUserDao;
use \App\Utils\Pagination;
use Sabberworm\CSS\Value\URL;

Class PageAdmin{

    //pega os dados do usuario logado no momento
    public static function getAdminUserLogado($obAdminUser){
        $dados = '';
        $AdminLogado = SessionAdmin::getAdminUserLogado();
        $id=$AdminLogado['id'];
        $nome=$AdminLogado['nome'];
        $nivel=$AdminLogado['nivel'];

        //Busca o Funcionario por id
        $obAdminUser = AdmimUserDao::getAdminUserId($id);

        $dados .= View::renderAdmin('Layouts/dadoslogado',[
            'nome'=>$nome,
            'imagem'=>$obAdminUser->imagem,
            'nivel'=>$nivel,
        ]);
        return View::renderAdmin('Layouts/itemdados',[
            'links'=>$dados,
       ]);
    }

    /**
       * Função para mostrar a paginacao 
       *@param Request $request
       *@param Pagination $obPagination
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

    //metodo para buscar header principal
    public static function getHeader($obFuncionario){
        return View::renderAdmin('Layouts/header',[
            'info'=> self::getAdminUserLogado($obFuncionario)
        ]);
    }

    //metodo busca footer
    public static function getFooter(){
        return View::render('Layouts/footer');
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

    // metodo para rederizar a pagina de login
    public static function getPageAdminLogin($title,$content,$red){
        return View::renderAdmin('login/pagina',[
            'title' => $title,
            'content'=> $content,
            'red'=>$red,
            'css'=>LOCAL_URL_ICON
        ]);
    }
}