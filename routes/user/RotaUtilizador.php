<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas dos Utilizadores do sistema
 *  foi incluido em routas.php
 */

//Apresenta a tela de Utilizador e sua listagem GET
$obRouter->get('/utilizadores', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Funcionario::telaFuncionario($request));
    }
]);

//Apresenta a tela de utilizadores e sua listagem POST
$obRouter->post('/utilizadores', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Funcionario::telaFuncionario($request));
    }
]);

// Rota para cadastrar funcionario get
$obRouter->get('/utilizadores/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Funcionario::cadastrarFuncionario($request));
    }
]);
// Rota para cadastrar funcionario get
$obRouter->post('/utilizadores/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Funcionario::cadastrarFuncionario($request));
    }
]);


// rota para alterar um registro GET
$obRouter->get('/funcionario/editar/{id_funcionario}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::getAtualizarFuncionario($request, $id_funcionario));
    }
]);
// rota para alterar um registro POST 
$obRouter->post('/funcionario/editar/{id_funcionario}', [
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::setAtualizarFuncionario($request, $id_funcionario));
    }
]);


// Rota para cadastrar funcionario get
$obRouter->get('/utilizadores/{id_funcionario}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::getFuncionarioConta($request, $id_funcionario));
    }
]);

// Rota para alterar perfil de acesso get
$obRouter->get('/utilizadores-perfil/{id_funcionario}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::editarPerfilU($request, $id_funcionario));
    }
]);

// Rota para alterar perfil de acesso post
$obRouter->post('/utilizadores-perfil/{id_funcionario}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::setEditarPerfilU($request, $id_funcionario));
    }
]);



// Rota para apagar utilizadores
$obRouter->get('/apagar/{id_funcionario}', [
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::setApagarFuncionario($request, $id_funcionario));
    }
]);

// Rota para apagar utilizadores
$obRouter->post('/apagar/{id_funcionario}', [
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::setApagarFuncionario($request, $id_funcionario));
    }
]);

