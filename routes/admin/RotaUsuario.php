<?php

use \App\Http\Response;
use \App\Controller\Admin;

/**
 *  Arquivo php de Rotas dos Funccionarios do sistema
 *  foi incluido em routas.php
 */

//Apresenta a tela de Funcionario e sua listagem GET
$obRouter->get('/usuario', [
    'middlewares' => [
        'requer-loginAdmin'
    ],
    function ($request) {
        return new Response(200, Admin\Usuario::getTelaUsuario($request));
    }
]);

//Apresenta a tela de Funcionario e sua listagem POST
$obRouter->post('/usuario', [
    'middlewares' => [
        'requer-loginAdmin'
    ],
    function ($request) {
        return new Response(200, Admin\Usuario::getTelaUsuario($request));
    }
]);

// Rota para cadastrar funcionario get
$obRouter->get('/usuario/cadastrar', [
    'middlewares' => [
        'requer-loginAdmin'
    ],
    function ($request) {
        return new Response(200, Admin\Usuario::CadastrarUsuario($request));
    }
]);
// Rota para cadastrar Usuario post
$obRouter->post('/usuario/cadastrar', [
        'middlewares' => [
        'requer-loginAdmin'
    ],

    function ($request) {
        return new Response(200, Admin\Usuario::CadastrarUsuario($request));
    }
]);

// rota para alterar um registro GET
$obRouter->get('/usuario/editar/{id}', [
    'middlewares' => [
        'nivel-acessoAdmin',
        'requer-loginAdmin'
    ],
    function ($request, $id) {
        return new Response(200, Admin\Usuario::getAtualizarUsuario($request, $id));
    }
]);
// rota para alterar um registro POST 
$obRouter->post('/usuario/editar/{id}', [
        'middlewares' => [
        'nivel-acessoAdmin',
        'requer-loginAdmin'
    ],
    function ($request, $id) {
        return new Response(200, Admin\Usuario::setAtualizarUsuario($request, $id));
    }
]);

// rota para apagar um registro
$obRouter->get('/usuario/apagar/{id}', [
    'middlewares' => [
        'nivel-acessoAdmin',
        'requer-loginAdmin'
    ],
    function ($request, $id) {
        return new Response(200,Admin\Usuario::apagarUser($request, $id));
    }
]);

// Rota para apagar funcionario
$obRouter->post('/usuario/apagar/{id}', [
    'middlewares' => [
        'nivel-acessoAdmin',
    ],
    function ($request, $id) {
        return new Response(200, Admin\Usuario::setapagarUser($request, $id));
    }
]);

