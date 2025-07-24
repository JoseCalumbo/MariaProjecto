<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Negocio do sistema
 *  foi incluido em routas.php
 */

 // rota painel Triagem get
$obRouter->get('/triagem',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Triagem::pagTriagem($request)); }
]);


// rota formulario Triagem GET
$obRouter->get('/triagem/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Triagem::cadastrarTriagem($request));}
]);

// rota formulario Triagem POST
$obRouter->post('/triagem/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Triagem::cadastrarTriagem($request));}
]);

// Rota Confirma o registro da triagem 
$obRouter->get('/triagem/confirmar/{id_triagem}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Triagem::getTriagemRegistrada($request,$id_triagem));}
]);


// rota para alterar um registro GET
$obRouter->get('/triagem/editar/{id_negocio}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_negocio){ return new Response(200,Pages\Triagem::editarTriagem($request,$id_negocio)); }
]);

// rota para alterar um registro POST
$obRouter->post('/triagem/editar/{id_negocio}',[
    function($request,$id_negocio){ return new Response(200,Pages\Triagem::editarTriagem($request,$id_negocio)); }
]);






// rota para apagar Triagem GET
$obRouter->get('/triagem/apagar/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Triagem::apagaTriagem($request,$id_triagem)); }
]);

// rota para apagar Triagem POST
$obRouter->post('/triagem/apagar/{id_triagem}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Triagem::apagaTriagem($request,$id_triagem)); }
]);

