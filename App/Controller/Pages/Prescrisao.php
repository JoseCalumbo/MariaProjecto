<?php 

namespace App\Controller\Pages;
use \App\Utils\Pagination;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\ZonaDao;
use \App\Model\Entity\VendedorDao;
use \App\Utils\View;


Class Prescrisao extends Page{

    // Metodo para gerar a pescrisao
    public static function getTelaGeradorReceita($request, $id_consulta){

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);
        $content = View::render('consulta/consulta',[
             'pesquisar'=>$buscar,
            // 'listarZona'=>self::getBusca($request,$obPagination),
           //  'paginacao'=>parent::getPaginacao($request,$obPagination)
        ]);
        return parent::getPage('Painel Consulta', $content);
    }

}