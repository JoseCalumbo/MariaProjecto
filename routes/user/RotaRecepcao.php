<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de Recepção
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento de exame  e sua listagem GET
$obRouter->get('/recepcao', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Recepçao::telaRecepçao($request));
    }
]);

// Apresenta a tela de exames e sua listagem POST
$obRouter->post('/recepcao', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Recepçao::telaRecepçao($request));
    }
]);

