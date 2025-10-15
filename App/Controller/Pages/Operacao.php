<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\UsuarioDao;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\AddNegocioDao;
use App\Model\Entity\VendedorDao;
use PDO;

Class Operacao extends Page {

    public static function getRelacaoNegocio(){

        $obAddNegocio = AddNegocioDao::checkedNegocio();
    }

    public static function getOperacao($request,$id){

        $obVendedor = VendedorDao::getVendedorId($id);

        $obAddNegocio = AddNegocioDao::checkedNegocio("id_vendedor = $id",'negocio');

        // obtem a zona de venda do vendedor
        $obZona = VendedorDao::negocioZona($id);

        $zona = '';

        $checkNegocios = '';

        foreach($obAddNegocio as $negocios){

            $checkNegocios .= '<p> '.$negocios->negocio.'</p>';
        }

        foreach($obZona as $zonas){
            $zona .=''.$zonas->mercado.'';
        }

        $content = View::render('servicos/tarefas', [
            'id'=>$obVendedor->id,
            'nome'=>$obVendedor->nome,
            'genero'=>$obVendedor->genero,
            'nascimento'=>date('d-m-Y',strtotime($obVendedor->nascimento)),
            'pai'=>$obVendedor->pai,
            'mae'=>$obVendedor->mae,
            'bi'=>$obVendedor->bilhete,
            'telefone1'=>$obVendedor->telefone1,
            'telefone2'=>$obVendedor->telefone2,
            'email'=>$obVendedor->email,
            'nivel'=>$obVendedor->nivelAcademico,
            'imagem'=>$obVendedor->imagem,
            'morada'=>$obVendedor->morada,
            'negocios'=>$checkNegocios,
            'zona'=>$zona,
            'criado'=>date('d-m-Y',strtotime( $obVendedor->create_vs)),
        ]);

        return parent::getPage('vendedor', $content);
    }

    public static function listarPagamentos(){
        
    }
}


