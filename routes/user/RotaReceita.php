<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas Prescricao
 *  foi incluido em routas.php
 */

// Apresenta a tela de gereciamento de Prescricao  e sua listagem GET
$obRouter->get('/receita', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Atestado::telaAtestado($request));
    }
]);

// Apresenta a tela de Prescricao e sua listagem POST
$obRouter->post('/receita', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Atestado::telaAtestado($request));
    }
]);

//_____________________________________________________________________________________________

// Apresenta a tela de gereciamento de Prescricao  e sua listagem GET
$obRouter->get('/consulta/prescrever/{id_consulta}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_consulta) {
        return new Response(200,Pages\Prescrisao::getTelaGeradorReceita($request, $id_consulta));
    }
]);

// Apresenta a tela de gereciamento de Prescricao  e sua listagem GET
$obRouter->post('/consulta/prescrever/{id_consulta}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_consulta) {
        return new Response(200,Pages\Prescrisao::setRegistrarReceita($request, $id_consulta));
    }
]);


// rota para finalizar receita GET
$obRouter->get('/receita/validar/{id_receita}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_receita){ return new Response(200,Pages\Prescrisao::getReceitaFinalizada($request,$id_receita)); }
]);

// rota para finalizar receita POST
$obRouter->post('/receita/validar/{id_receita}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_receita){ return new Response(200,Pages\Prescrisao::setReceitaFinalizada($request,$id_receita)); }
]);




// Apresenta a tela de gereciamento de Prescricao  e sua listagem GET
$obRouter->get('/receita/imprimi/{id_consulta}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_consulta) {
        return new Response(200,Pages\Prescrisao::getImprimir($request, $id_consulta));
    }
]);