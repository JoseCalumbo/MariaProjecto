<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Zona do sistema
 *  foi incluido em routas.php
 */

 // rota painel zona GET
$obRouter->get('/zona',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Zona::telaZona($request));}
]);

// rota painel zona POST
$obRouter->post('/zona',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Zona::telaZona($request));}
]);

// rota formulario Zona GET
$obRouter->get('/zona/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Zona::cadastrarZona($request));}
]);

// rota formulario Zona POST
$obRouter->post('/zona/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Zona::cadastrarZona($request));}
]);

// rota para alterar um registro GET
$obRouter->get('/zona/editar/{id_zona}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_zona){ return new Response(200,Pages\Zona::editarZona($request,$id_zona)); }
]);

// rota para alterar um registro POST
$obRouter->post('/zona/editar/{id_zona}',[
    function($request,$id_zona){ return new Response(200,Pages\Zona::editarZona($request,$id_zona)); }
]);

// rota para apagarZonas GET
$obRouter->get('/zona/apagar/{id_zona}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_zona){ return new Response(200,Pages\Zona::apagarZona($request,$id_zona)); }
]);

// rota para apagar Zonas POST
$obRouter->post('/zona/apagar/{id_zona}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_zona){ return new Response(200,Pages\Zona::apagarZona($request,$id_zona)); }
]);

