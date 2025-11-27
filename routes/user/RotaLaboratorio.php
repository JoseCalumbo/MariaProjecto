<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas do Laboratório
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento do laboratório get
$obRouter->get('/laboratorio', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Laboratorio::telaLaboratorio($request));
    }
]);

// Apresenta a tela de gereciamento do laboratório post
$obRouter->post('/laboratorio', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Laboratorio::telaLaboratorio 
        ($request));
    }
]);


// rota para lançar resultado do exame POST 
$obRouter->get('/exame/resultado/{id_exameSolicitado}', [
    function ($request, $id_exameSolicitado) {
        return new Response(200, Pages\Laboratorio::getLancarResultado($request, $id_exameSolicitado));
    }
]);

// rota para lançar resultado do exame POST 
$obRouter->post('/exame/resultado/{id_exameSolicitado}', [
    function ($request, $id_exameSolicitado) {
        return new Response(200, Pages\Laboratorio::setLancarResultado($request, $id_exameSolicitado));
    }
]);



