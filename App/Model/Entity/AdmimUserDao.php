<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \PDO;

class AdmimUserDao {
    public $id; // guarda o numero ID unico do usuario Adimim
    public $nome;  // guarda o nome de identificação do usuario Adimim
    public $nascimento; // guarda a data de nscimento do usuario Adimim
    public $email;
    public $telefone;
    public $nivel;
    public $imagem;
    public $senha;
    public $criado;


    // fMetodo responsavel por fazer insert na tabela usuario
    public function cadastrar(){

        $this->criado = date('y-m-d H:i:s');
        $obDatabase = new Database('tb_usuario');
        $this->id = $obDatabase->insert([
                'id' => $this->id,
                'nome' => $this->nome,
                'nascimento' => $this->nascimento,
                'email' => $this->email,
                'telefone' => $this->telefone,
                'nivel' => $this->nivel,
                'imagem' => $this->imagem,
                'senha' => $this->senha,
                'criado' => $this->criado,
        ]);
            return true;
    }
    
    // faz um update na tabela usuario
    public function atualizar(){
        return (new Database('usuario'))->update('id_us = '.$this->id,[
                'nome' => $this->nome,
                'nascimento' => $this->nascimento,
                'email' => $this->email,
                'telefone' => $this->telefone,
                'nivel' => $this->nivel,
                'imagem' => $this->imagem,
                'senha' => $this->senha,
                'criado' => $this->criado,
        ]);
    }

      // faz um delete na tabela usuario
    public function apagar(){
        return (new Database('usuario'))->delete('id_us = '.$this->id,[]);
    }

    // responsavel para alterar senha 
    public function atualizarSenha(){
            return (new Database('usuario'))->update('id_us = '.$this->id,[
                    'senha_us' => $this->senha,
        ]);
    }

    // responsavel para alterar imagem do usuario
    public function atualizarImagem(){
            return (new Database('usuario'))->update('id_us = '.$this->id,[
                 'imagem_us' => $this->imagem,
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
     * @return $email
     */
    public static function getUsuarioEmail($email){
            return (new Database('usuario'))->select('email_us = "'.$email.'"')->fetchObject(self::class);
    }

    //para pegar o user id
    public static function getUsuarioId($id_us){
        return (new Database('usuario'))->select('id_us = '.$id_us)->fetchObject(self::class);
     }
    
}
    