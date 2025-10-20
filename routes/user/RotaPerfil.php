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
$obRouter->post('/cadastrar/perfil', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Pages\Perfil::setCadastrarPerfil($request));
    }
]);

// Rota para cadastrar perfil de acesso
$obRouter->get('/cadastrar/permissao/{id_Nivel}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_Nivel) {
        return new Response(200, Pages\Perfil::cadastrarPermissao($request,$id_Nivel));
    }
]);

// Rota para cadastrar perfil de acesso
$obRouter->post('/cadastrar/permissao/{id_Nivel}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_Nivel) {
        return new Response(200, Pages\Perfil::setCadastrarPermissao($request,$id_Nivel));
    }
]);


// Rota para editar perfil de acesso
$obRouter->get('/editar/perfil/{id_Nivel}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_Nivel) {
        return new Response(200, Pages\Perfil::editarPermissao($request,$id_Nivel));
    }
]);

// Rota para apagar perfil de acesso
$obRouter->get('/apagar/perfil/{id_nivel}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_Nivel) {
        return new Response(200, Pages\Perfil::apagarPerfil($request,$id_Nivel));
    }
]);

// Rota para apagar perfil de acesso
$obRouter->get('/apagar/permissaoa/{id_nivel}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id_Nivel) {
        return new Response(200, Pages\Perfil::apagarPermissao($request,$id_Nivel));
    }
]);













