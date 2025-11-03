<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Medicamentos
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento de medicamentos GET
$obRouter->get('/medicamento', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Medicamento::telaMedicamento($request));
    }
]);

// Apresenta a tela de medicamento e sua listagem POST
$obRouter->post('/medicamento', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Medicamento::telaMedicamento($request));
    }
]);


// Rota para cadastrar medicamento
$obRouter->get('/medicamento/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Medicamento::getCadastrarMedicamento($request));
    }
]);

// Rota para cadastrar medicamentos
$obRouter->post('/medicamento/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Medicamento::setCadastrarMedicamento($request));
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
$obRouter->post('/medicamento/apagar/{id_medicamento}', [
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function ($request, $id_medicamento) {
        return new Response(200, Pages\Medicamento::setApagarMedicamento($request, $id_medicamento));
    }
]);


