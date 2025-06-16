<?php

use \App\Http\Response;
use \App\Controller\Pages;

/**
 *  Arquivo php de Rotas da Zona do sistema
 *  foi incluido em routas.php
 */

 // rota painel taxa  GET
$obRouter->get('/tesouraria',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Tesouraria::telaTaxa($request));}
]);

// rota formulario taxa valor GET
$obRouter->get('/editar/taxa/{id_taxa}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_taxa){ return new Response(200,Pages\Tesouraria::editarTaxa($request,$id_taxa));}
]);

// rota formulario Zona POST
$obRouter->get('/caixa',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Tesouraria::telaCaixa($request));}
]);
