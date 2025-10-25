<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas de Configuração do sistema
 *  foi incluido em routas.php
 */

//Apresenta a tela para definir permisao
$obRouter->get('/configuracao', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Configuracao::telaConfiguracao($request));
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





//Apresenta a tela de cadastrametros de servicos
$obRouter->get('/configuracao-cadastros', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Configuracao::cadastrosBasico($request));
    }
]);

//Apresenta a tela de gestao pacientes
$obRouter->get('/configuracao-pacientes', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\Configuracao::configuracaoPaciente($request));
    }
]);











//Apresenta a tela de gestao pacientes
$obRouter->get('/config-paciente', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200,Pages\PacienteAdmin::getAdminPaciente($request));
    }
]);


