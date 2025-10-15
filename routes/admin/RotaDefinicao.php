<?php

use \App\Http\Response;
use \App\Controller\Admin;

/**
 *  Arquivo php de Rotas dos Definiçao do sistema
 *  foi incluido em routas.php
 */

//Apresenta a tela de Definição e sua listagem GET
$obRouter->get('/admin/definicao', [
    'middlewares' => [
        'requer-loginAdmin'
    ],
    function ($request) {
        return new Response(200, Admin\Configuracao::getTelaDefinicao($request));
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

