
<?php
/**
 * Todas as rotas aqui serve para impresao 
*/

use \App\Http\Response;
use \App\Controller\Imprimir;


//imprimir a listagem de Usuario
$obRouter->get('/triagem/gerar-ficha/{id_triagem}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_triagem) {
        return new Response(200, Imprimir\TriagemPDF::gerarFichaTriagem($request, $id_triagem));
    }
]);

//imprimir a listagem de Usuario
$obRouter->get('/triagem/imprimir-ficha/{id_triagem}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_triagem) {
        return new Response(200, Imprimir\TriagemPDF::imprimirFichaTriagem($request,$id_triagem));
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
