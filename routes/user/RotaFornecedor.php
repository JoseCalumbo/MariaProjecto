<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da fornecedor
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento de fornecedors GET
$obRouter->get('/fornecedor', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Fornecedor::telaFornecedor($request));
    }
]);

// Apresenta a tela de fornecedor e sua listagem POST
$obRouter->post('/fornecedor', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Fornecedor::telaFornecedor($request));
    }
]);

// Rota para cadastrar fornecedor
$obRouter->post('/fornecedor/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Fornecedor::cadastrarMedicamentoPainel($request));
    }
]);

// Rota para cadastrar fornecedors
$obRouter->post('/fornecedor-cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Fornecedor::setCadastrarFornecedor($request));
    }
]);

// rota para alterar um registro POST 
$obRouter->post('/fornecedor/editar/{id_fornecedor}', [
    function ($request, $id_fornecedor) {
        return new Response(200, Pages\Fornecedor::setAtualizarFornecedor($request, $id_fornecedor));
    }
]);

// Rota para apagar fornecedor
$obRouter->post('/fornecedor/apagar/{id_fornecedor}', [
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function ($request, $id_fornecedor) {
        return new Response(200, Pages\Fornecedor::setApagarFornecedor($request, $id_fornecedor));
    }
]);


