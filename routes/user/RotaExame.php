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

