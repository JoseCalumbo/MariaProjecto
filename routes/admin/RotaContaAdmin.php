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

// rota para ir seguranca
$obRouter->get('/admin/seguranca',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$erroMsg){ return new Response(200,Admin\ContaAdmin::getTelaSeguranca($request,$erroMsg));}
]);

// rota para ir controle conta get
$obRouter->get('/admin/controle',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$erroMsg){ return new Response(200,Admin\ContaAdmin::getControleConta($request,$erroMsg));}
]);

// rota para ir no perfil
$obRouter->get('/conta/perfil',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$id_us){ return new Response(200,Admin\ContaAdmin::getEditarConta($request,$id_us));}
]);
// rota para ir no registros admin
$obRouter->get('/admin/registros',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$id_us){ return new Response(200,Admin\ContaAdmin::getRegistrosConta($request,$id_us));}
]);
















// rota para editat senga post
$obRouter->post('/admin/editsenha',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$id_us){ return new Response(200,Admin\ContaAdmin::setAlterarSenha($request,$id_us));}
]);




// rota para ir alterar senha post
$obRouter->post('/admin/apagar',[
    'middlewares'=>[
        'requer-loginAdmin'
    ],
    function($request,$erroMsg){ return new Response(200,Admin\ContaAdmin::setApagarConta($request,$erroMsg));}
]);



