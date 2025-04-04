<?php

use \App\Http\Response;
use \App\Controller\Pages;

//Pagina inicial
$obRouter->get('/',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Home::getHome($request)); }
]);

$obRouter->get('/home',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Home::getHomeBalcao($request)); }
]);
$obRouter->get('/dados',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Home::getHomeDados($request)); }
]);
$obRouter->get('/fina',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Home::getHomeFinanca($request)); }
]);

//usuario painel e listagem
$obRouter->get('/funcionario',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Usuario::TelaUsuario($request)); }
]);

//usuario painel e listagem
$obRouter->post('/usuario',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Usuario::TelaUsuario($request)); }
]);

$obRouter->get('/cadastraruser',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Usuario::cadastrarUser($request)); }
]);

$obRouter->post('/cadastraruser',[

    function($request){
        return new Response(200,Pages\Usuario::cadastrarUser($request)); }
]);

// rota para alterar um registro
$obRouter->get('/usuario/editar/{id_us}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_us){ return new Response(200,Pages\Usuario::getAtualizarUser($request,$id_us)); }
]);

$obRouter->post('/usuario/editar/{id_us}',[
    function($request,$id_us){ return new Response(200,Pages\Usuario::setAtualizarUser($request,$id_us)); }
]);

// rota para apagar um registro
$obRouter->get('/usuario/apagar/{id_us}',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request,$id_us){ return new Response(200,Pages\Usuario::apagarUser($request,$id_us)); }
]);
$obRouter->post('/usuario/apagar/{id_us}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_us){ return new Response(200,Pages\Usuario::setapagarUser($request,$id_us)); }
]);


//_________________________________vendedor___________________________________
$obRouter->get('/vendedor',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\vendedor::telaVendedor($request));}
]);

$obRouter->post('/vendedor',[
    function($request){ return new Response(200,Pages\vendedor::telaVendedor($request));}
]);

// rota para cadastrar um vendedor
$obRouter->get('/cadastrarvendedor',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\vendedor::cadastrarVendedor($request,$id));}
]);

// rota para post cadastrar um vendedor
$obRouter->post('/cadastrarvendedor',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\vendedor::cadastrarVendedor($request,$id));}
]);

// rota para editar um vendedor
$obRouter->get('/vendedor/editar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\vendedor::atualizarVendedor($request,$id));}
]);

// rota para editar um vendedor
$obRouter->post('/vendedor/editar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\vendedor::atualizarVendedor($request,$id));}
]);

$obRouter->get('/vendedor/apagar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\vendedor::apagarVendedor($request,$id));}
]);

// rota para apagar um vendedor
$obRouter->post('/vendedor/apagar/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\vendedor::apagarVendedor($request,$id));}
]);

//________________________________relatorio__________________________
$obRouter->get('/relatorio',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function(){ return new Response(200,Pages\Relatorio::telaRelatorio());}
]);
//relatorio
$obRouter->get('/relatorio/finaceiro',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Relatorio::RelatorioFinaceiro($request));}
]);
//relatorio
$obRouter->get('/relatorio/dados',[
    'middlewares'=>[
        'requer-login',
        'nivel-acesso'
    ],
    function($request){ return new Response(200,Pages\Relatorio::RelatorioDados($request));}
]);

/**
 * inclui as rotas da zona  
*/
include __DIR__.'/RotaZona.php';

//________________________ rota para ir na pagina conta___________________________
$obRouter->get('/conta',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Conta::telaConta($request));}
]);

// rota para ir na pagina conta
$obRouter->post('/conta',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request){ return new Response(200,Pages\Conta::alterarImagem($request));}
]);

// rota para ir alterar conta
$obRouter->get('/conta/alterarsenha',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$erroMsg){ return new Response(200,Pages\Conta::telaAlterarSenha($request,$erroMsg));}
]);

// rota para ir na conta
$obRouter->post('/conta/alterarsenha',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_us){ return new Response(200,Pages\Conta::setAlterarSenha($request,$id_us));}
]);

// rota para ir na conta
$obRouter->get('/conta/editar',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id_us){ return new Response(200,Pages\Conta::editarConta($request,$id_us));}
]);

/**
 * __________________________________login_______________________________
 * inclui as rotas de login 
*/
include __DIR__.'/RotaLogin.php';



/**
 * __________________________________Negocio_______________________________
 * inclui as rotas de negocio
*/
include __DIR__.'/RotaNegocio.php';
 

//__________________________________ serviços de tarefas_______________________Aqui
$obRouter->get('/vendedor/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Operacao::getOperacao($request,$id)); }
]);


/**
 * __________________________________Pagamento_______________________________
 * inclui as rotas de Pagamento de taxa dos vendedores 
*/
include __DIR__.'/RotaPagamento.php';



//__________________________________ Notificacao_______________________
$obRouter->get('/acesso/negado',[
    'middlewares'=>[
        'requer-login'
    ],
    function($request,$id){ return new Response(200,Pages\Notificacao::acessNegado($request,$id)); }
]);

/**
 * __________________________________Tesouraria_______________________________
 * inclui as rotas de RotaTesouraria
*/
include __DIR__.'/RotaTesouraria.php';
