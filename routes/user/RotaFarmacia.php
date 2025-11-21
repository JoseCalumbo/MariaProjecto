<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Farmacia
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento de exame  e sua listagem GET
$obRouter->get('/farmacia', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Farmacia::telaFarmacia($request));
    }
]);

// Apresenta a tela de exames e sua listagem POST
$obRouter->post('/farmacia', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Farmacia::telaFarmacia($request));
    }
]);
