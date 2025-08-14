<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de Configuração do sistema
 *  foi incluido em routas.php
 */

//Apresenta a tela de Funcionario e sua listagem GET
$obRouter->get('/permissao', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Configuracao::Permissao($request));
    }
]);

//Apresenta a tela de Funcionario e sua listagem POST
$obRouter->post('/funcionario', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Funcionario::telaFuncionario($request));
    }
]);

// Rota para cadastrar funcionario get
$obRouter->get('/funcionario/cadastrar', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Funcionario::cadastrarFuncionario($request));
    }
]);
// Rota para cadastrar funcionario get
$obRouter->post('/funcionario/cadastrar', [
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



// Rota para apagar funcionario
$obRouter->post('/funcionario/apagar/{id_funcionario}', [
    'middlewares' => [
        'requer-loginAdmin'
    ],
    function ($request, $id_funcionario) {
        return new Response(200, Pages\Funcionario::setApagarFuncionario($request, $id_funcionario));
    }
]);

