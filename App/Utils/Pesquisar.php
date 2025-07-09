<?php

namespace App\Utils;

use \App\Utils\View;
use \App\Model\Entity\Organization;
use \App\Model\Entity\UsuarioDao;

class Pesquisar{

    public static function buscar(){

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);

            // $condicoes = [
            //     $_SESSION['usuario']['id_us']
            // ];
            // $where = implode(' AND ',$condicoes);

        $condicoes = [
            strlen($buscar) ? 'nome_us LIKE "%'.$buscar.'%"': null,
        ];

        $where = implode(' AND ',$condicoes);
    }
}