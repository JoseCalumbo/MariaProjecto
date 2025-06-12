<?php

use \App\Http\Response;
use \App\Controller\Pages;
use \App\Controller\Admin;


//Pagina inicial
$obRouter->get('/',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Home::getHome($request)); }
]);

$obRouter->get('/home',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Home::getHomeBalcao($request)); }
]);


/**
 * __________________________________login_______________________________
 * inclui as rotas de login 
*/
include __DIR__.'/RotaLoginAdmin.php';
