<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da tesoraria
 *  foi incluido em routas.php
 */

// Apresenta a tela de tesoraria e sua listagem POST
$obRouter->get('/tesouraria', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Tesoraria::telaTesoraria($request));
    }
]);
// Apresenta a tela de tesoraria e sua listagem POST
$obRouter->post('/tesouraria', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Tesoraria::telaTesoraria($request));
    }
]);

