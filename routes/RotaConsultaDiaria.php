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
    function($request){ return new Response(200,Pages\ConsultaDiaria::telaConsultaDiaria($request));}
]);

// rota painel Consulta diaria POST
$obRouter->post('/consulta-diaria',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\ConsultaDiaria::telaConsultaDiaria($request));}
]);

 // Rota Painel Consulta Diaria POS
 $obRouter->get('/consulta/atender/{id_pac}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\ConsultaDiaria::AtenderConsulta($request, $id_zona));}
]);

// rota formulario consulta diaria POST
$obRouter->post('/consulta/cadastrar/{id_zona}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\ConsultaDiaria::cadastrarNovaConsulta($request));}
]);

// rota para alterar um registro GET
$obRouter->get('/consulta-diaria/editar/{id_zona}',[
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