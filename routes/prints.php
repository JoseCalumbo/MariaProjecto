
<?php
/**
 * Todas as rotas aqui serve para impresao 
*/

use \App\Http\Response;
use \App\Controller\Imprimir;

//ver a listagem de Usuario 
$obRouter->get('/relatorio/listaUser', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Imprimir\TriagemPDF::ListaUserPDF($request));
    }
]);

//imprimir a listagem de Usuario
$obRouter->get('/triagem/ficha/diaria', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Imprimir\TriagemPDF::imprimirTriagem($request));
    }
]);


/**
 * 
 * ROTA PARA OBTER OS RELATORIO DOS VENDEDORES 
 * 
 */

//imprimir vendedor  listagem
$obRouter->get('/relatorio/listaVendedor', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Imprimir\VendedorPDF::ListaVendedorPDF($request));
    }
]);

//imprimir vendedor  listagem
$obRouter->get('/relatorio/imprimilistaVendedor', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request) {
        return new Response(200, Imprimir\VendedorPDF::imprimiVendedorPDF($request));
    }
]);


//Imprimi a ficha de um vendedores 
$obRouter->get('/vendedorFicha/{id}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id) {
        return new Response(200, Imprimir\VendedorPDF::imprimiFicha($request, $id));
    }
]);

//Imprimi a cartao de um vendedores 
$obRouter->get('/cartao/{id}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id) {
        return new Response(200, Imprimir\VendedorPDF::cartaoVendedor($request, $id));
    }
]);

//Imprimi a ficha de um vendedores 
$obRouter->get('/declaracao/{id}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request, $id) {
        return new Response(200, Imprimir\VendedorPDF::declaracaoVendedor($request, $id));
    }
]);

// pagina generica 
$obRouter->get('/page/{idPagina}', [
    function ($idPagina, $acao) {
        return new Response(200, 'Pagina' . $idPagina . '-' . $acao);
    }
]);



/**
 * __________________________________Negocio_______________________________
 * inclui as rotas de negocio
 */
include __DIR__ . '/recibo.php';
