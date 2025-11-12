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






// rota para alterar um registro GET
$obRouter->get('/consulta/atender/{id_paciente}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Consulta::getcadastrarConsulta($request,$id_paciente)); }
]);

// rota para alterar um registro GET
$obRouter->post('/consulta/atender/{id_paciente}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Consulta::getcadastrarConsulta($request,$id_paciente)); }
]);







// rota para marcar consulta
$obRouter->get('/consulta/marcar',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Consulta::getMarcarConsulta($request,$id_paciente)); }
]);

// rota para marcar consulta
$obRouter->post('/consulta/marcar',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Consulta::setMarcarConsulta($request,$id_paciente)); }
]);