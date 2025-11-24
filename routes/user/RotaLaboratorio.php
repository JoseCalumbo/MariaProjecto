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


