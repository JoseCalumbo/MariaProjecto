<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \PDO;

class UsuarioDao{

    public $id_us;
    public $nome_us;
    public $genero_us;
    public $nascimento_us;
    public $bilhete_us;
    public $email_us;
    public $telefone_us;
    public $nivel_us;
    public $senha_us;
    public $imagem_us;
    public $posto_us;
    public $create_us;


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
                'id_posto' => $this->posto_us,
        ]);
    }

      // faz um delete na tabela usuario
    public function apagar(){
        return (new Database('usuario'))->delete('id_us = '.$this->id_us,[

        ]);
    }

    // responsavel para alterar senha 
    public function atualizarSenha(){
            return (new Database('usuario'))->update('id_us = '.$this->id_us,[
                    'senha_us' => $this->senha_us,
        ]);
    }

    // responsavel para alterar imagem do usuario
    public function atualizarImagem(){
            return (new Database('usuario'))->update('id_us = '.$this->id_us,[
                 'imagem_us' => $this->imagem_us,
        ]);
    }
    
    /**
    * apresenta os resultado
    * @param string $where
     */
    public static function listarUsuario($where = null, $order = null, $limit = null, $fields = '*'){
         return (new Database('usuario'))->select($where,$order,$limit,$fields); 
    }
   
    /**
     * Busca  o user po email
     * @param string $email_us
     * @return user
     */
    public static function getUsuarioEmail($email_us){
            return (new Database('usuario'))->select('email_us = "'.$email_us.'"')->fetchObject(self::class);
    }

    //para pegar o user id
    public static function getUsuarioId($id_us){
        return (new Database('usuario'))->select('id_us = '.$id_us)->fetchObject(self::class);
     }
    
}
    