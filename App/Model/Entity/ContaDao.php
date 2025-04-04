<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \PDO;

class ContaDao{

    public $id_conta;
    public $id_vendedor;
    public $status_conta;
    public $id_mensal;
    public $data_conta;
    public $id;

    // faz um insert na tabela usuario
    public function addConta(){

        // $this->data_conta = date('y-m-d H:i:s');

        // $obDatabase = new Database('conta');
        // $this->id = $obDatabase->insert([
        //         'id_us' => $this->id_us,
        //         'nome_us' => $this->nome_us,
        //         'genero_us' => $this->genero_us,
        //         'nascimento_us' => $this->nascimento_us,
        //         'bilhete_us' => $this->bilhete_us,
        //         'email_us' => $this->email_us,
        //         'telefone_us' => $this->telefone_us,
        //         'nivel_us' => $this->nivel_us,
        //         'imagem_us' => $this->imagem_us,
        //         'senha_us' => $this->senha_us,
        //         'id_posto' => $this->posto_us,
        //         'data_conta' => $this->create_us,
        // ]);
        //     return true;
    }
    
    // Actualiza o status da conta do vendedor
    public function atualizarStatus(){
        
        return (new Database('conta'))->update('id_conta = '.$this->id_conta,[
                'status_conta' => $this->status_conta,
        ]);
    }

    //Metodo para  buscar id da Taxa
    public static function getTaxaId($id_conta){
        return (new Database('conta'))->select('id_conta = '.$id_conta)->fetchObject(self::class);
    }


          // faz um delete na tabela usuario
          public function apagarConta($id){
            return (new Database('conta'))->delete('id_vendedor = '.$id,[
    
            ]);
        }
}
    