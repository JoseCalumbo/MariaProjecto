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

// rota para atender consulta GET
$obRouter->get('/consulta/atender/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Consulta::getcadastrarConsulta($request,$id_triagem)); }
]);

// rota para atender consulta POST
$obRouter->post('/consulta/atender/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Consulta::getcadastrarConsulta($request,$id_triagem)); }
]);

// rota para validar consulta GET
$obRouter->get('/consulta/atender/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Consulta::getcadastrarConsulta($request,$id_triagem)); }
]);

// rota para finalizar consulta GET
$obRouter->get('/consulta/validar/{id_consulta}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_consulta){ return new Response(200,Pages\Consulta::getValidarConsulta($request,$id_consulta)); }
]);

// rota para finalizar consulta GET
$obRouter->post('/consulta/validar/{id_consulta}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_consulta){ return new Response(200,Pages\Consulta::setValidarConsulta($request,$id_consulta)); }
]);
































































// rota para marcar consulta
$obRouter->get('/consulta/marcar',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
   // function($request,$id_paciente){ return new Response(200,Pages\Consulta::getMarcarConsulta($request,$id_paciente)); }
]);

// rota para marcar consulta
$obRouter->post('/consulta/marcar',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
   // function($request,$id_paciente){ return new Response(200,Pages\Consulta::setMarcarConsulta($request,$id_paciente)); }
]);