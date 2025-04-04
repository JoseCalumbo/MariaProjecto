<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class MensalidadeDao{

    // id mensal
    public $id_mensal;

    //mes
    public $mes;

    // venvimeto 
    public $status_mensalidade;

    // taxa
    public $id_taxa ;

    // venvimeto 
    public $vencimento;

    // Data de alteracao 
    public $data_mensalidade;

    // Data de alteracao 
    public $criado;


    // faz um insert Mensalidade
    public function cadastrarMesalidade(){

        // salva a data de cadastramento da zona
        $this->data_mesalidade = date('d-m-Y H:i:s');

        $this->criado = date('Y-m-d');

        // Instancia da Database
        $obDatabase = new Database('mensalidade');

        $this->id_mensal = $obDatabase->insert([
            'id_mensal' => $this->id_mensal,
            'status_mensalidade' => $this->status_mensalidade ='s',
            'id_taxa' => $this->id_taxa,
            'vencimento' => $this->vencimento,
            'data_mensalidade' => $this->data_mensalidade,
            'mes' => $this->mes,
            'criado' => $this->criado,
        ]);
            return true;
    }

    // responsavel para alterar imagem do usuario
    public function atualizarStatusMensal(){
        return (new Database('mensalidade'))->update('id_mensal = '.$this->id_mensal,[
            'status_mensalidade' => $this->status_mensalidade = 'n',
        ]);
    }

    /**
     * Obtem o mes a vencer 
     * @param string $where
     */
    public static function getMensal($vencimento){
        return (new Database('mensalidade'))->select('vencimento = '."'$vencimento'")->fetchObject(MensalidadeDao::class);
    }

    /**
     * Obtem os dados mensal da conta
     * @param string $where
     */
    public static function listarContaMensal1($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('mensalidade'))->select($where,$order,$limit,$fields);
    }
    
    /**
     * Obtem os dados mensal da conta
     * @param string $where
     */
    public static function listarContaMensal($id, $order = null, $limit = null, $fields = '*'){
        return (new Database('mensalidade JOIN conta ON 
        mensalidade.id_mensal = conta.id_mensal JOIN taxa ON
        mensalidade.id_taxa = taxa.id_taxa'))->select('id_vendedor = '.$id);
    }
    /**
     * Obtem os dados mensal da conta
     * @param string $where
     */
    public static function verificarMesActual($id){
        return (new Database('mensalidade JOIN conta ON 
                             mensalidade.id_mensal = conta.id_mensal'))->select('id_vendedor = '.$id)->fetchObject(self::class);
    }

    /**
     * Obtem os dados do mes actual mensalidadede
     * @param string $where
     */
    public static function getMesActual($status_mensalidade){
        return (new Database('mensalidade '))->select('status_mensalidade= '."'$status_mensalidade'");
    }

}