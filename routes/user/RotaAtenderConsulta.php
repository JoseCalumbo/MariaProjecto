<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de para Atender as Consultas do sistema
 *  foi incluido em routas.php
 */


// rota para alterar um registro GET
$obRouter->get('/consulta/atender/{id_paciente}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Consulta::iniciarConsulta($request,$id_paciente)); }
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

