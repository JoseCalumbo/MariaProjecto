<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de consulta do sistema
 *  foi incluido em routas.php
 */

 // rota painel zona GET
$obRouter->get('/consulta',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consulta::telaConsulta($request));}
]);

// rota painel zona POST
$obRouter->post('/consulta',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consulta::telaConsulta($request));}
]);

// rota formulario Zona GET
$obRouter->get('/consulta/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consulta::cadastrarConsulta($request));}
]);

// rota formulario Zona POST
$obRouter->post('/consulta/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consulta::cadastrarConsulta($request));}
]);

// rota para alterar um registro GET
$obRouter->get('/consulta/editar/{id_zona}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_zona){ return new Response(200,Pages\Zona::editarZona($request,$id_zona)); }
]);

// rota para alterar um registro POST
$obRouter->post('/consulta/editar/{id_zona}',[
    function($request,$id_zona){ return new Response(200,Pages\Zona::editarZona($request,$id_zona)); }
]);

// rota para apagarZonas GET
$obRouter->get('/consulta/apagar/{id_zona}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_zona){ return new Response(200,Pages\Zona::apagarZona($request,$id_zona)); }
]);

// rota para apagar Zonas POST
$obRouter->post('/consulta/apagar/{id_zona}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_zona){ return new Response(200,Pages\Zona::apagarZona($request,$id_zona)); }
]);

