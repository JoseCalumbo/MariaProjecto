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


