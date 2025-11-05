<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da tesoraria
 *  foi incluido em routas.php
 */

// Apresenta a tela de utilitario e sua listagem POST
$obRouter->get('/utilitario', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Utilitario::telaUtilitario($request));
    }
]);
// Apresenta a tela de utilitario e sua listagem POST
$obRouter->post('/utilitario', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Utilitario::telaUtilitario($request));
    }
]);

