<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class ZonaDao{

    // id da zona
    public $id_zona;

    //Nome da zona
    public $zona;

    // hora inicial de 
    public $inicio_venda;

    // hora final de venda
    public $fim_venda;

    // descrição do local da zona
    public $mercado;

    // Data de cadastramento da zona
    public $criado;



    // faz um insert na tabela zona
    public function cadastrarZona(){

        // salva a data de cadastramento da zona
        $this->criado = date('d-m-Y H:i:s');

        // Instancia da Database
        $obDatabase = new Database('zona');

        $this->id_zona = $obDatabase->insert([
            'id_zona' => $this->id_zona,
            'zona' => $this->zona,
            'inicio_venda' => $this->inicio_venda,
            'fim_venda' => $this->fim_venda,
            'mercado' => $this->mercado,
            'criado' => $this->criado,

        ]);
            return true;
    }
    
    // faz um update na tabela usuario
    public function AtualizarZona(){

        return (new Database('zona'))->update('id_zona = '.$this->id_zona,[
            'id_zona' => $this->id_zona,
            'zona' => $this->zona,
            'inicio_venda' => $this->inicio_venda,
            'fim_venda' => $this->fim_venda,
            'mercado' => $this->mercado,
        ]);
    }

    // faz um delete na tabela zona
    public function apagarZona(){
        return (new Database('zona'))->delete('id_zona = '.$this->id_zona,[ ]);
    }
    
    /**
    * Apresenta os resultado da tabela zoma
    * @param string $where
     */
    public static function listarZona($where = null, $order = null, $limit = null, $fields = '*'){
         return (new Database('tb_paciente'))->select($where,$order,$limit,$fields); 
    }

    //Metodo para  selecionar um registro da tabela Zona por ID
    public static function getZona($id_zona){
        return (new Database('zona'))->select('id_zona = '.$id_zona)->fetchObject(self::class);
     }
    
}
    