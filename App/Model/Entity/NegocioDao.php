<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class NegocioDao{

    // id da negocio
    public $id_negocio;

    //Nome da negocio
    public $negocio;

    // Data de cadastramento do negocio
    public $data_criacao;



    // faz um insert na tabela Negocio
    public function cadastrarNegocio(){

        // salva a data de cadastramento da Negocio
        $this->criado = date('d-m-Y H:i:s');

        // Instancia da Database
        $obDatabase = new Database('negocio');

        $this->id_zona = $obDatabase->insert([
            'id_negocio' => $this->id_negocio,
            'negocio' => $this->negocio,
            'data_criacao' => $this->data_criacao,
        ]);
            return true;
    }
    
    // faz um update na tabela Negocio
    public function atualizarNegocio(){

        return (new Database('negocio'))->update('id_negocio = '.$this->id_negocio,[
            'negocio' => $this->negocio,
            'data_criacao' => $this->data_criacao,
        ]);
    }

    // faz um delete na tabela zona
    public function apagarZona(){
        return (new Database('negocio'))->delete('id_negocio = '.$this->id_negocio,[
        ]);
    }
    
    /**
    * Apresenta os resultado da tabela Negocio
    * @param string $where
     */
    public static function listarNegocio($where = null, $order = null, $limit = null, $fields = '*'){
         return (new Database('negocio'))->select($where,$order,$limit,$fields); 
    }

    //Metodo para  selecionar um registro da tabela Negocio por ID
    public static function getNegocio($id_negocio){
        return (new Database('negocio'))->select('id_negocio = '.$id_negocio)->fetchObject(self::class);
    }

    /**
    * Apresenta a quantidade total de negocio
    * @param string $where
     */
    public static function getQuantidadeNegocio($where = null, $order = null, $limit = null, $fields = 'COUNT(*) as quantidade'){
        return (new Database('negocio'))->select($where,$order,$limit,$fields); 
   }
    
}
    