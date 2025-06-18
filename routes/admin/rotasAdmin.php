<?php

use \App\Http\Response;
use \App\Controller\Admin;
use \App\Controller\Pages;


// Página inicial admin
$obRouter->get('/admin', [
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function ($request) {
        return new Response(200, Admin\HomeAdmin::getHomeAdmin($request));
    }
]);


/**
 * __________________________________Login e Sign Admin_______________________________
 * inclui as rotas de login e sign
*/
include __DIR__.'/RotaLoginAdmin.php';

/**
 * __________________________________Usuario_______________________________
 * inclui as rotas dos Usuario
 */
include __DIR__.'/RotaUsuario.php';

/**
 * __________________________________Funcionario_______________________________
 * inclui as rotas dos Funcionario
*/
include __DIR__.'/RotaFuncionario.php';

/**
 * __________________________________ Conta User_______________________________
 * inclui as rotas dos Conta user
*/
include __DIR__.'/RotaContaAdmin.php';
