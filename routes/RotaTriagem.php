<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Negocio do sistema
 *  foi incluido em routas.php
 */

 // rota painel Negocio

$obRouter->get('/triagem',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Triagem::pagNegocio($request)); }
]);


// rota formulario negocio GET
$obRouter->get('/triagem/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Triagem::cadastrar($request));}
]);

// rota formulario negocio POST
$obRouter->post('/triagem/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Triagem::cadastrar($request));}
]);

// rota para alterar um registro GET
$obRouter->get('/negocio/editar/{id_negocio}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_negocio){ return new Response(200,Pages\Triagem::editarNegocio($request,$id_negocio)); }
]);

// rota para alterar um registro POST
$obRouter->post('/negocio/editar/{id_negocio}',[
    function($request,$id_negocio){ return new Response(200,Pages\Triagem::editarNegocio($request,$id_negocio)); }
]);

// rota para apagar  Negocio GET
$obRouter->get('/negocio/apagar/{id_negocio}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_negocio){ return new Response(200,Pages\Triagem::apagaNegocio($request,$id_negocio)); }
]);

// rota para apagar Negocio POST
$obRouter->post('/negocio/apagar/{id_negocio}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_negocio){ return new Response(200,Pages\Triagem::apagaNegocio($request,$id_negocio)); }
]);

