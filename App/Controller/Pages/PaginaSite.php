<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\VendedorDao;
use \App\Model\Entity\UsuarioDao;
use App\Model\Entity\ZonaDao;

class PaginaSite extends Page
{
    // tela pagina site 
    public static function getPagina($request)
    {
        $content = View::render('site/main', [
            'pesquisar' => ""
        ]);
        // Retorna o metedo que renderiza a (Layouts) pagina 
        return parent::getPageSite('Mp Site  ', $content);
    }

    // tela pagina site contactos
    public static function getPaginaContactos($request)
    {
        $content = View::render('site/contactoss', [
            'pesquisar' => ""
        ]);
        // Retorna o metedo que renderiza a (Layouts) pagina 
        return parent::getPageSite('Mp Site  Contactos', $content);
    }

}
