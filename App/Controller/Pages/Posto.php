<?php

namespace App\Controller\Pages;

use \App\Model\Database;
use \App\Model\Entity\PostoDao;
use \App\Utils\View;

class Posto{

    public static function getPosto(){
        
        $posto = '';
        $posto = PostoDao::listarPosto();
        while( $obposto = $posto->fetchObject(PostoDao::class)){
           return $posto .= View::render('item/posto', [
                'posto'=>$obposto->nome_posto,
            ]);
        }
      //  return $posto;
    }
}