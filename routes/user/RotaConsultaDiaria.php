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



