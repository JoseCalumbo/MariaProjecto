<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas dos Funccionarios do sistema
 *  foi incluido em routas.php
*/

//Apresenta a tela de Funcionario e sua listagem GET
$obRouter->get('/funcionario',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Funcionario::telaFuncionario($request)); }
]);

//Apresenta a tela de Funcionario e sua listagem POST
$obRouter->post('/funcionario',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Usuario::TelaUsuario($request)); }
]);

// Rota para cadastrar funcionario get
$obRouter->get('/funcionario/cadastrar',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Funcionario::cadastrarFuncionario($request)); }
]);
// Rota para cadastrar funcionario get
$obRouter->post('/funcionario/cadastrar',[

    function($request){
        return new Response(200,Pages\Funcionario::cadastrarFuncionario($request)); }
]);

// rota para alterar um registro GET
$obRouter->get('/funcionario/editar/{id_funcionario}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_funcionario){ return new Response(200,Pages\Funcionario::getAtualizarFuncionario($request,$id_funcionario)); }
]);
// rota para alterar um registro POST 
$obRouter->post('/funcionario/editar/{id_funcionario}',[
    function($request,$id_funcionario){ return new Response(200,Pages\Funcionario::setAtualizarFuncionario($request,$id_funcionario)); }
]);

// rota para apagar um registro
$obRouter->get('/funcionario/apagar/{id_funcionario}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_funcionario){ return new Response(200,Pages\Usuario::apagarUser($request,$id_funcionario)); }
]);

// Rota para apagar funcionario
$obRouter->post('/funcionario/apagar/{id_funcionario}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_funcionario){ return new Response(200,Pages\Funcionario::setApagarFuncionario($request,$id_funcionario)); }
]);

