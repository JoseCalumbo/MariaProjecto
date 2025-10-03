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

/** __________________________________Utilizador _______________________________
 * inclui as rotas dos utilizador
*/
include __DIR__.'/RotaUtilizador.php';

/** __________________________________Perfil utiliador _______________________________
 * inclui as rotas de perfil do utilizador
*/
include __DIR__.'/RotaPerfil.php';


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

//________________________ rota configuração___________________________

/**
 * inclui as rotas da zona  
*/
include __DIR__.'/RotaConfiguracao.php';

//________________________ rota Zona___________________________

/**
 * inclui as rotas da zona  
*/
include __DIR__.'/RotaZona.php';

//________________________ rota Consulta___________________________

/**
 * inclui as rotas da zona  
*/
include __DIR__.'/RotaConsulta.php';


//________________________ Rota Consulta Diaria___________________________
/**
 * inclui as rotas da zona  
*/
include __DIR__.'/RotaConsultaDiaria.php';









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
 * __________________________________Triagem_______________________________
 * inclui as rotas de negocio
*/
include __DIR__.'/RotaTriagem.php';
 

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
 * __________________________________Paciente _______________________________
 * inclui as rotas de RotaTesouraria
*/
include __DIR__.'/RotaPaciente.php';


