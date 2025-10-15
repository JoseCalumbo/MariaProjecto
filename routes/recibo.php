
<?php
/**
 * Todas as rotas aqui serve para impresao de relatorio
 */

use \App\Http\Response;
use \App\Controller\Imprimir;

//Imprimi a ficha de um vendedores 
$obRouter->get('/factura/{id_conta}/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($id_conta,$id){ return new Response(200,Imprimir\FacturaPDF::imprimirFactura($id_conta,$id)); }
]);

//Imprimi a ficha de um vendedores 
$obRouter->get('/listagem/{id}',[
    'middlewares'=>[
        'requer-login'
    ],
    function($id){ return new Response(200,Imprimir\FacturaPDF::imprimirListagem($id)); }
]);

