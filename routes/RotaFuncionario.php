<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas dos Funccionarios do sistema
 *  foi incluido em routas.php
 */

 
//usuario painel e listagem
$obRouter->get('/funcionario',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Funcionario::telaFuncionario($request)); }
]);

//usuario painel e listagem
$obRouter->post('/usuario',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Usuario::TelaUsuario($request)); }
]);

$obRouter->get('/cadastraruser',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Usuario::cadastrarUser($request)); }
]);

$obRouter->post('/cadastraruser',[

    function($request){
        return new Response(200,Pages\Usuario::cadastrarUser($request)); }
]);

// rota para alterar um registro
$obRouter->get('/usuario/editar/{id_us}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_us){ return new Response(200,Pages\Usuario::getAtualizarUser($request,$id_us)); }
]);

$obRouter->post('/usuario/editar/{id_us}',[
    function($request,$id_us){ return new Response(200,Pages\Usuario::setAtualizarUser($request,$id_us)); }
]);

// rota para apagar um registro
$obRouter->get('/usuario/apagar/{id_us}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_us){ return new Response(200,Pages\Usuario::apagarUser($request,$id_us)); }
]);
$obRouter->post('/usuario/apagar/{id_us}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_us){ return new Response(200,Pages\Usuario::setapagarUser($request,$id_us)); }
]);

