<?php

use \App\Http\Response;
use \App\Controller\Admin;
use \App\Controller\Pages;


// Rota de login no sistema para ADMIN
$obRouter->get('/admin/login', [
    'middlewares'=>[
       'requer-logoutAdmin'
    ],
    function ($request, $erroMsg) {
        return new Response(200, Admin\LoginAdmin::getTelaLoginAdmin($request));
    }
]);

$obRouter->post('/admin/login', [
    'middlewares'=>[
        'requer-logoutAdmin'
    ],
    function ($request) {
       // echo password_hash('12345', PASSWORD_DEFAULT);
       // exit;
        return new Response(200, Admin\LoginAdmin::setLoginAdmin($request));
    }
]);

//criar conta no sistema GET
$obRouter->get('/admin/sigin', [
    'middlewares' => [
        'requer-logout'
    ],
    function ($request, $erroMsg) {
        return new Response(200, Admin\SiginAdmin::telaSigin($request, $erroMsg));
    }
]);

$obRouter->post('/admin/sigin', [
    'middlewares' => [
        'requer-logout'
    ],
    function ($request) {
        return new Response(200, Admin\SiginAdmin::criarConta($request));
    }
]);

//criar conta no sistema GET
$obRouter->get('/admin/confirmado', [
    'middlewares' => [
        'requer-logout'
    ],
    function ($request) {

        return new Response(200, Pages\Sigin::telaSiginConfirma($request));
    }
]);


// rota para deslogar o usuario
$obRouter->get('/admin/logout', [
    'middlewares' => [
        'requer-loginAdmin'
    ],
    function ($request) {
        return new Response(200,Admin\LoginAdmin::setDeslogarAdmin($request));
    }
]);

// rota para recuperar a senha do usuario admin
$obRouter->get('/admin/recuperar-senha', [
    function ($request, $erroMsg) {
        return new Response(200, Admin\LoginAdmin::getRecuperarSenha($request, $erroMsg));
    }
]);

// rota POST recuperar a senha do usuario admin
$obRouter->post('/recuperar/senha', [
    function ($request, $erroMsg) {
        return new Response(200, Admin\LoginAdmin::setRecuperarSenha($request, $erroMsg));
    }
]);

// rota de email enviado
$obRouter->get('/recuperar/enviado', [
    function ($request, $erroMsg) {
        return new Response(200, Pages\login::emailEnviado($request, $erroMsg));
    }
]);

