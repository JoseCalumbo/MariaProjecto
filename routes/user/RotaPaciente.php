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


// rota para editar um paciente
$obRouter->get('/paciente/editar/{id_paciente}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Paciente::editarPaciente($request,$id_paciente));}
]);

// rota para editar um paciente
$obRouter->post('/paciente/editar/{id_paciente}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Paciente::editarPaciente($request,$id_paciente));}
]);

// rota para conta do paciente
$obRouter->get('/paciente/{id_paciente}',[
    'middlewares'=>[
        'requer-login'
    ],
        function($request,$id_paciente){ return new Response(200,Pages\Paciente::contaPaciente($request,$id_paciente));}
]);

// rota para conta do paciente
$obRouter->get('/triagem/paciente/{id_paciente}',[
    'middlewares'=>[
        'requer-login'
    ],
    
    function($request,$id_paciente){ return new Response(200,Pages\Paciente::addTriagem($request,$id_paciente));}
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