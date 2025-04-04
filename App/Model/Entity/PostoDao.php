<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \PDO;

class PostoDao{

    public $id_posto;
    public $nome_posto;
    public $enderoco;
    public $data;
  


    // faz um insert na tabela usuario
    public function cadastrar(){

        $this->create = date('y-m-d H:i:s');
        $obDatabase = new Database('usuario');
        $this->id = $obDatabase->insert([
                'id_us' => $this->id_us,
                'nome_us' => $this->nome_us,
                'genero_us' => $this->genero_us,
                'nascimento_us' => $this->nascimento_us,
                'bilhete_us' => $this->bilhete_us,
                'email_us' => $this->email_us,
                'telefone_us' => $this->telefone_us,
                'nivel_us' => $this->nivel_us,
                'imagem_us' => $this->imagem_us,
                'senha_us' => $this->senha_us,
                'id_posto' => $this->posto_us,
                'create_us' => $this->create_us,
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

      // faz um delete na tabela usuario
    public function apagar(){
        return (new Database('usuario'))->delete('id_us = '.$this->id_us,[

        ]);
    }
    
    /**
    * Apresenta os resultado da tb posto
    * @param string $where
    */
        public static function listarPosto($where = null, $order = null, $limit = null, $fields = '*'){
            return (new Database('posto'))->select($where,$order,$limit,$fields); 
    }
   

    //para pegar o user id
    public static function getUsuarioId($id_us){
        return (new Database('usuario'))->select('id_us = '.$id_us)->fetchObject(self::class);
     }
    
}
    