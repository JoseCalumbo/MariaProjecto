<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Negocio do sistema
 *  foi incluido em routas.php
 */

 // rota painel Negocio

$obRouter->get('/negocio',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Negocio::pagNegocio($request)); }
]);


// rota formulario negocio GET
$obRouter->get('/negocio/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Negocio::cadastrar($request));}
]);

// rota formulario negocio POST
$obRouter->post('/negocio/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Negocio::cadastrar($request));}
]);

// rota para alterar um registro GET
$obRouter->get('/negocio/editar/{id_negocio}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_negocio){ return new Response(200,Pages\negocio::editarNegocio($request,$id_negocio)); }
]);

// rota para alterar um registro POST
$obRouter->post('/negocio/editar/{id_negocio}',[
    function($request,$id_negocio){ return new Response(200,Pages\Negocio::editarNegocio($request,$id_negocio)); }
]);

// rota para apagar  Negocio GET
$obRouter->get('/negocio/apagar/{id_negocio}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_negocio){ return new Response(200,Pages\Negocio::apagaNegocio($request,$id_negocio)); }
]);

// rota para apagar Negocio POST
$obRouter->post('/negocio/apagar/{id_negocio}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_negocio){ return new Response(200,Pages\Negocio::apagaNegocio($request,$id_negocio)); }
]);

