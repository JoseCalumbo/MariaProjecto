<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Contabilidade
 *  foi incluido em routas.php
 */

// Apresenta a tela de Contabilidade e sua listagem POST
$obRouter->get('/contabilidade', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Contabilidade::telaContabilidade($request));
    }
]);
// Apresenta a tela de Contabilidade e sua listagem POST
$obRouter->post('/contabilidade', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Contabilidade::telaContabilidade($request));
    }
]);

