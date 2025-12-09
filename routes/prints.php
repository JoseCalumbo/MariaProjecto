
<?php
/**
 * ROTA DE IMPRESSÃO E DOWNLOAD DE FICHA E LISTA DE RELATÓRIO
 * Todas as rotas aqui servem excluíosivamente para relátorios de todo o sistema 
*/

use \App\Http\Response;
use \App\Controller\Imprimir;

#_________________________________________ rotas da triagem____________________________________________

//Rota de download da ficha de triagem
$obRouter->get('/triagem/gerar-ficha/{id_triagem}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_triagem) {
        return new Response(200, Imprimir\TriagemPDF::baixarFichaTriagem($request, $id_triagem));
    }
]);

//Rota para imprimir a ficha de triagem
$obRouter->get('/triagem/imprimir-ficha/{id_triagem}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_triagem) {
        return new Response(200, Imprimir\TriagemPDF::ImprimirFichaTriagem($request,$id_triagem));
    }
]);


#_________________________________________ rotas da consulta____________________________________________

//Rota de download da ficha dos exames solicitados
$obRouter->get('/exame/gerar-ficha/{id_exame_solicitado}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_exame_solicitado) {
        return new Response(200, Imprimir\ExameSolicitadaPDF::baixarExameSolicitado($request, $id_exame_solicitado));
    }
]);

//Rota para imprimir a ficha dos  exames solicitados
$obRouter->get('/exame/imprimir-ficha/{id_exame_solicitado}', [
    'middlewares' => [
        'requer-login'
    ],
    function ($request,$id_exame_solicitado) {
        return new Response(200, Imprimir\ExameSolicitadaPDF::imprimirExameSolicitado($request,$id_exame_solicitado));
    }
]);













