<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class ExameDao{

    // id do exame
    public $id_exame;

    //Nome do exame
    public $nome_exame;

    // tipo de exame
    public $tipo_exame;

    // tipo de exame
    public $parametro_exame;

    // valor do exame
    public $valor_exame;

    // estado exame
    public $estado_exame;

    // Data de cadastramento do exame
    public $criado_exame;


    // faz um insert na tabela exame
    public function cadastrarExame(){

        // salva a data de cadastramento do exame 
       // $this->criado_exame = date('d-m-Y H:i:s');

        // Instancia da Database
        $obDatabase = new Database('tb_exame');

        $this->id_exame = $obDatabase->insert([
            'id_exame' => $this->id_exame,
            'nome_exame' => $this->nome_exame,
            'tipo_exame' => $this->tipo_exame,
            'parametro_exame' => $this->parametro_exame,
            'estado_exame' => $this->estado_exame,
            'valor_exame' => $this->valor_exame,
            'criado_exame' => $this->criado_exame,

        ]);
            return true;
    }
    
    // faz um update na tabela da exame
    public function AtualizarExame(){

        return (new Database('tb_exame'))->update('id_exame = '.$this->id_exame,[
            'id_exame' => $this->id_exame,
            'nome_exame' => $this->nome_exame,
            'tipo_exame' => $this->tipo_exame,
            'parametro_exame' => $this->parametro_exame,
            'valor_exame' => $this->valor_exame,
            'criado_exame' => $this->criado_exame,
        ]);
    }

    // faz um delete na tabela exame
    public function apagarZona(){
        return (new Database('tb_exame'))->delete('id_exame = '.$this->id_exame,[ ]);
    }
    
    /**
    * Apresenta os resultado da tabela exame
    * @param string $where
     */
    public static function listarExame($where = null, $order = null, $limit = null, $fields = '*'){
         return (new Database('tb_exame'))->select($where,$order,$limit,$fields); 
    }

    //Metodo para  selecionar um registro da tabela exame
    public static function getExame($id_zona){
        return (new Database('tb_exame'))->select('id_exame = '.$id_zona)->fetchObject(PDO::FETCH_CLASS.self::class);
     }
    
}
    