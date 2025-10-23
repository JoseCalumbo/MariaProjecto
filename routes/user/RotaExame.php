<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de Exame
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento de exame  e sua listagem GET
$obRouter->get('/exame', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Exame::telaExame($request));
    }
]);

// Apresenta a tela de exames e sua listagem POST
$obRouter->post('/exame', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Exame::telaExame($request));
    }
]);


// Rota para cadastrar exames
$obRouter->get('/exame/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Exame::cadastrarExame($request));
    }
]);

// Rota para cadastrar exames
$obRouter->post('/exame/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Exame::cadastrarExame($request));
    }
]);

// rota para alterar um registro POST 
$obRouter->get('/exame/editar/{id_exame}', [
    function ($request, $id_exame) {
        return new Response(200, Pages\Exame::getAtualizarExame($request, $id_exame));
    }
]);

// rota para alterar um registro POST 
$obRouter->post('/exame/editar/{id_exame}', [
    function ($request, $id_exame) {
        return new Response(200, Pages\Exame::setAtualizarExame($request, $id_exame));
    }
]);

// Rota para apagar utilizadores
$obRouter->post('/exame/apagar/{id_exame}', [
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function ($request, $id_exame) {
        return new Response(200, Pages\Exame::setApagarExame($request, $id_exame));
    }
]);


