<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas do  Paciente do sistema
 *  foi incluido em routas.php
 */


//
$obRouter->get('/paciente',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Paciente::getTelaPaciente($request));}
]);

$obRouter->post('/paciente',[
    function($request){ return new Response(200,Pages\Paciente::getTelaPaciente($request));}
]);

// rota para cadastrar um paciente
$obRouter->get('/paciente/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Paciente::cadastrarPaciente($request,$id));}
]);

// rota para cadastrar um paciente
$obRouter->post('/paciente/cadastrar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Paciente::cadastrarPaciente($request,$id));}
]);


// rota para editar um vendedor
$obRouter->get('/vendedor/editar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Paciente::atualizarVendedor($request,$id));}
]);

// rota para editar um vendedor
$obRouter->post('/vendedor/editar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Paciente::atualizarVendedor($request,$id));}
]);

$obRouter->get('/vendedor/apagar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Paciente::apagarVendedor($request,$id));}
]);

// rota para apagar um vendedor
$obRouter->post('/vendedor/apagar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Paciente::apagarVendedor($request,$id));}
]);