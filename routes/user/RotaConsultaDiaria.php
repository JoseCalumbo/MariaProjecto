<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
*  Arquivo php de Rotas de consultas Diarias do sistema
*  Este arquivo foi incluido em routas.php
*/

 // Rota Painel Consulta Diaria GET
$obRouter->get('/consulta-diaria',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consulta::telaPacienteEspera($request));}
]);

// rota painel Consulta diaria POST
$obRouter->post('/consulta-diaria',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Consulta::telaPacienteEspera($request));}
]);

 // Rota Painel Consulta Marcada 
$obRouter->get('/consulta/marcada',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,){ return new Response(200,Pages\Consulta::consultaMarcadas($request));}
]);

 // Rota Painel Consulta Diaria GET
$obRouter->get('/marcar/consulta/{id_paciente}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_paciente){ return new Response(200,Pages\Consulta::getMarcarConsulta($request,$id_paciente));}
]);

// // rota painel Consulta diaria POST
// $obRouter->post('/marcar/consulta',[
//     'middlewares'=>[
//         'requer-login'
//     ],
//     function($request){ return new Response(200,Pages\Consulta::marcarConsulta($request));}
// ]);


