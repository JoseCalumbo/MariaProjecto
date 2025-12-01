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

$obRouter->get('/paciente-apagar/{id_paciente}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\PacienteAdmin::apagarPaciente($request,$id_paciente));}
]);

$obRouter->post('/paciente-apagar/{id_paciente}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\PacienteAdmin::apagarPaciente($request,$id_paciente));}
]);

// rota para apagar Triagem GET
$obRouter->get('/pacient/apagar/{id_triagem}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\PacienteAdmin::apagarPaciente($request,$id_triagem)); }
]);

// rota para apagar Triagem POST
$obRouter->post('/pacient/apagar/{id_triagem}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_triagem){ return new Response(200,Pages\PacienteAdmin::apagarPaciente($request,$id_triagem)); }
]);