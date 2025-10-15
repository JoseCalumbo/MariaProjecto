<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Zona do sistema
 *  foi incluido em routas.php
 */

 // rota painel zona GET
$obRouter->get('/pagamento/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Pagamento::telaPagamento($request,$id));}
]);
 // rota painel zona GET
$obRouter->post('/pagamento/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Pagamento::telaPagamento($request,$id));}
]);
 // rota painel de pagamento
$obRouter->post('/{id_conta}/conta/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_conta,$id){ return new Response(200,Pages\Pagamento::pagamento($request,$id_conta,$id));}
]);


