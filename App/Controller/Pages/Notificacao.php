<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\UsuarioDao;
use \App\Utils\Session;
use \App\Controller\Mensagem\Mensagem;
use \App\Utils\Upload;

Class Notificacao extends Page{


    // metodo que apresenta a notificacao 
    public static function acessNegado($request){

        $usuarioLogado = Session::getUsuarioLogado();
        $nivel=$usuarioLogado['nivel_us'];

         $content = View::render('notificacao/acessoNegado',[
            'nivel'=>$nivel,
        ]);
        return parent::getPage('Painel Usuario', $content);
    }
}