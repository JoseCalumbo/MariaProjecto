<?php

use \App\Http\Response;
use \App\Controller\Admin;

/**
 *  Arquivo php de Rotas dos Conta admin do sistema
 *  foi incluido em routas.php
*/


//________________________ rota para ir na pagina conta___________________________
$obRouter->get('/admin/conta',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request){ return new Response(200,Admin\ContaAdmin::telaConta($request));}
]);

// rota para ir na pagina conta
$obRouter->post('/admin/conta',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request){ return new Response(200,Admin\ContaAdmin::alterarImagem($request));}
]);

// rota para ir alterar conta
$obRouter->get('/admin/editsenha',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$erroMsg){ return new Response(200,Admin\ContaAdmin::getTelaAlterarSenha($request,$erroMsg));}
]);

// rota para ir na conta
$obRouter->post('/admin/editsenha',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$id_us){ return new Response(200,Admin\ContaAdmin::setAlterarSenha($request,$id_us));}
]);

// rota para ir na conta
$obRouter->get('/conta/editar',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$id_us){ return new Response(200,Admin\ContaAdmin::editarConta($request,$id_us));}
]);