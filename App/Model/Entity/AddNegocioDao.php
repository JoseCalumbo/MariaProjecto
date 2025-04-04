<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class AddNegocioDao{

    //id vendedor
    public $id_vendedor;

    // id vendedor
    public $id_negocio;

    // id vendedor
    public $negocio;

    // Data de cadastramento
    public $criado;

    // faz um delete na tabela relacao venda e negocio
    public  function deleteAddNegocio($id){
        return (new Database('negocio_vendedor'))->delete('id_vendedor = '.$id,[
        ]);
    }
    
    /**
    * Apresenta os resultado 
    * @param string $where
     */
    public static function listarNegocioVendedor($where = null, $order = null, $limit = null, $fields = '*'){
         return (new Database('negocio_vendedor'))->select($where,$order,$limit,$fields); 
    }

//     // * Apresenta dados de Negocio_Vendedor
//     // * @param string $where
//     // *
//     public static function checkedNegocio($where = null, $order = null, $limit = null, $fields = '*'){
//          return (new Database('negocio_vendedor JOIN negocio ON 
//          negocio.id_negocio = negocio_vendedor.id_negocio 
//          '))->select($where,$order,$limit,$fields)->fetchObject(); 
//     }

    // * Apresenta dados de Negocio_Vendedor
    // * @param string $where
    // *
    public static function checkedNegocio($where = null, $order = null, $limit = null, $fields = '*'){
         return (new Database('negocio_vendedor JOIN negocio ON 
         negocio.id_negocio = negocio_vendedor.id_negocio 
         '))->select($where,$order,$limit,$fields)->fetchAll(PDO::FETCH_CLASS,self::class); 
    }

    //Metodo para  selecionar um registro da tabela por ID
    public static function getAddNegocioID($id_zona){
        return (new Database('negocio_vendedor'))->select('id_vend_neg = '.$id_zona)->fetchObject(self::class);
     }
     
     //Metodo para  selecionar um registro da tabela por ID
     public static function getIDaddNegocio($idVendedorNeg){
         return (new Database('negocio_vendedor'))->select('id_vend_neg = '.$idVendedorNeg)->fetchObject(self::class);
      }
}

    