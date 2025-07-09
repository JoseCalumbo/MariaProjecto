<?php 

namespace App\Controller\Pages;

use \App\Utils\View;

use \App\Model\Entity\VendedorDao;

use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\NegocioDao;
use App\Model\Entity\AddNegocioDao;

Class VendedorNegocio extends Page {

    // exibe a messagem de operacao
    public static function exibeMensagem($request){

        $queryParam = $request->getQueryParams();
        
        if(!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Vendedor Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Vendedor Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Vendedor Apagdo com sucesso');
                break;
        }// fim do switch
    }

    //Metodo para adcionar negocio os vendedores
    public static function addNegocioVendedor($id){

        $obnegocioVendedor = new addNegocioDao;
        $idVendedor = new VendedorDao;
    }

}