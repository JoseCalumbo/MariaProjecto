<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas Prescricao
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento de Prescricao  e sua listagem GET
$obRouter->get('/atestado', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Atestado::telaAtestado($request));
    }
]);

// Apresenta a tela de Prescricao e sua listagem POST
$obRouter->post('/atestado', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Atestado::telaAtestado($request));
    }
]);
