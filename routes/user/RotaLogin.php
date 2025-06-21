<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
*  Arquivo php de Rotas de login do sistema
*  foi incluido em routas.php
*/

//Rota de login de sistema GET
$obRouter->get('/login',[
    'middlewares'=>[
        'requer-logout'
    ],
    function($request,$erroMsg){
        return new Response(200,Pages\Login::telaLogin($request,$erroMsg)); }
]);

//Rota de login de sistema POST
$obRouter->post('/login',[
    'middlewares'=>[
        'requer-logout'
    ],
    function($request){ 
        //  echo password_hash('12345', PASSWORD_DEFAULT);
        //  exit;
        return new Response(200,Pages\login::setLogin($request)); }
]);

// rota para deslogar o usuario
$obRouter->get('/logout',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){

         return new Response(200,Pages\Login::setDeslogar($request)); }
]);

//criar conta no sistema GET
$obRouter->get('/sigin', [
    'middlewares' => [
        'requer-logout'
    ],
    function ($request, $erroMsg) {
        return new Response(200, Pages\Sigin::telaSigin($request, $erroMsg));
    }
]);

$obRouter->post('/sigin', [
    'middlewares' => [
        'requer-logout'
    ],
    function ($request) {
        return new Response(200, Pages\Sigin::criarConta($request));
    }
]);

$obRouter->get('/sigin/confirmado/{email}', [
    'middlewares' => [
        'requer-logout'
    ],
    function ($request,$email) {
        return new Response(200, Pages\Sigin::getContaCadastrada($request,$email));
    }
]);




// rota para recuperar a senha do usuario
$obRouter->get('/recuperar/senha',[
    function($request,$erroMsg){ return new Response(200,Pages\login::recuperarSenha($request, $erroMsg)); }
]);

// rota POST recuperar a senha do usuario
$obRouter->post('/recuperar/senha',[
    function($request,$erroMsg){ return new Response(200,Pages\login::setRecuperarSenha($request,$erroMsg)); }
]);

// rota de email enviado
$obRouter->get('/recuperar/enviado',[
    function($request,$erroMsg){ return new Response(200,Pages\login::emailEnviado($request,$erroMsg)); }
]);






// rota para contactos 
$obRouter->get('/site',[
    function($request){ return new Response(200,Pages\PaginaSite::getPagina($request)); }
]);

// rota para contactos 
$obRouter->get('/contactos',[
    function($request){
         return new Response(200,Pages\PaginaSite::getPaginaContactos($request)); }
]);
