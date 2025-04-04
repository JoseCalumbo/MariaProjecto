<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class TaxaDao{

    public $id_taxa;
    public $taxa;
    public $valor;
    public $criado_taxa;
    public $id_us;


    // Metodo para colocar Taxa
    public function cadastrar(){

        $this->criado_taxa = date('y-m-d H:i:s');

        $obDatabase = new Database('taxa');

        $this->id = $obDatabase->insert([
            'taxa' => $this->taxa,
            'valor' => $this->valor,
            'criado_taxa' => $this->criado_taxa,
            'id_us' => $this->id_us,
        ]);
            return true;
    }
    
    // faz um update na tabela usuario
    public function atualizar(){
        return (new Database('usuario'))->update('id_us = '.$this->id_us,[
                'nome_us' => $this->nome_us,
                'genero_us' => $this->genero_us,
                'nascimento_us' => $this->nascimento_us,
                'bilhete_us' => $this->bilhete_us,
                'email_us' => $this->email_us,
                'telefone_us' => $this->telefone_us,
                'nivel_us' => $this->nivel_us,
                'imagem_us' => $this->imagem_us,
        ]);
    }

    /**
    * Metodo que apresenta todas as taxas
    * @param string $where
     */
    public static function listarTaxa($where = null, $order = null, $limit = null, $fields = '*'){
         return (new Database('taxa'))->select($where,$order,$limit,$fields); 
    }

    //Metodo para  buscar id da Taxa
    public static function getTaxaId($id_taxa){
        return (new Database('taxa'))->select('id_taxa = '.$id_taxa)->fetchObject(self::class);
     }
    
}
    