<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de consulta do sistema
 *  foi incluido em routas.php
 */

 // rota painel consultorio GET
$obRouter->get('/consulta',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consultorio::telaConsulta($request));}
]);

// rota painel zona POST
$obRouter->post('/consulta',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consultorio::telaConsulta($request));}
]);

// rota para atender consulta GET
$obRouter->get('/consulta/atender/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Consultorio::getcadastrarConsulta($request,$id_triagem)); }
]);

// rota para atender consulta POST
$obRouter->post('/consulta/atender/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Consultorio::getcadastrarConsulta($request,$id_triagem)); }
]);

// rota para validar consulta GET
$obRouter->get('/consulta/atender/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\Consultorio::getcadastrarConsulta($request,$id_triagem)); }
]);


// rota para validar consulta GET
$obRouter->get('/consulta/validar/{id_consulta}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_consulta){ return new Response(200,Pages\Consultorio::getValidarConsulta($request,$id_consulta)); }
]);

// rota para validar consulta POST
$obRouter->post('/consulta/validar/{id_consulta}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_consulta){ return new Response(200,Pages\Consultorio::setValidarConsulta($request,$id_consulta)); }
]);

// rota para finalizar consulta GET
$obRouter->post('/consulta/finalizar/{id_consulta}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_consulta){ return new Response(200,Pages\Consultorio::getFinalizarConsulta($request,$id_consulta)); }
]);

// rota para finalizar consulta POST
// $obRouter->post('/consulta/finalizar/{id_consulta}',[
//     'middlewares'=>[
//         'requer-login',
//         'nivel-acesso'
//     ],
//     function($request,$id_consulta){ return new Response(200,Pages\Consultorio::setFinalizarConsulta($request,$id_consulta)); }
// ]);
































































// rota para marcar consulta
$obRouter->get('/consulta/marcar',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
   // function($request,$id_paciente){ return new Response(200,Pages\Consultorio::getMarcarConsulta($request,$id_paciente)); }
]);

// rota para marcar consulta
$obRouter->post('/consulta/marcar',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
   // function($request,$id_paciente){ return new Response(200,Pages\Consultorio::setMarcarConsulta($request,$id_paciente)); }
]);