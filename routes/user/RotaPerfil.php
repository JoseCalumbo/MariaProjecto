<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de Configuração de perfil
 *  foi incluido em routas.php
 */

//Apresenta a tela para definir perfil de acesso
$obRouter->get('/perfil', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Perfil::getPerfilAcesso($request));
    }
]);

//Apresenta a tela para definir perfil de acesso
$obRouter->post('/perfil', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Perfil::getPerfilAcesso($request));
    }
]);

// Rota para cadastrar perfil de acesso
$obRouter->get('/cadastrar/perfil', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Perfil::cadastrarPerfil($request));
    }
]);

// Rota para cadastrar perfil de acesso
$obRouter->post('/cadastrar/perfil', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Perfil::setCadastrarPerfil($request));
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

