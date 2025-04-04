<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \App\Model\Entity\AddNegocioDao;
use \App\Model\Entity\NegocioDao;
use \PDO;

class PagamentoDao{

    public $id_vendedor;
    public $id_pagamento;
    public $id_mensalidade;
    public $valor_pagamento;
    public $id_us;
    public $troco;
    public $status;
    public $data_pagamento;

    // campos mensalidade 
    public $id_mensal;
    public $id_conta;
    public $id_taxa;
    public $criado;

    // metodo para inserir um novo vendedor na tabela
    public function realizarPagamento(){

        // Pegar o id  do Usuario
        $usuarioLogado = Session::getUsuarioLogado();

        // Pega a data actual do cadastro
        $this->data_pagamento = date('y-m-d H:i:s');

        //Pega o id do usuario logado
        $this->id_us = $usuarioLogado['id_us'];

        $mesActual = MensalidadeDao::getMesActual('s')->fetchObject();

        // o estado actual do vendedor
        $this->id_mensalidade = $mesActual->id_mensal;

        $obDatabase = new Database('pagamento');

        $this->id_pagamento = $obDatabase->insert([
            'id_pagamento' => $this->id_pagamento,
            'valor_pagamento' => $this->valor_pagamento,
            'troco'=> $this->troco,
            'status' => $this->status='Liquidado',
            'data_pagamento' => $this->data_pagamento,
            'id_vendedor' => $this->id_vendedor,
            'id_mensalidade' => $this->id_mensalidade,
            'id_us' => $this->id_us,
            ]);
        return true;
    }

    /**
     * lista todos os pagamento
     * @param string $where
     */
    public static function listarPagamentoID($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('pagamento'))->select($where,$order,$limit,$fields);
    }

    // * Apresenta dados de pagamento
    // * @param string $where
    // *
    public static function listarPagamento($id){
        return (new Database('pagamento JOIN vendedor ON 
        pagamento.id_vendedor = vendedor.id 
        '))->select('id = '.$id)->fetchAll(PDO::FETCH_CLASS,self::class); 
   }

    // * Apresenta dados zonas vendedor
    // * @param string $where
    // *
    public static function getpagamento($id){
        return (new Database('pagamento JOIN vendedor ON 
        pagamento.id_vendedor = vendedor.id 
        '))->select('id = '.$id)->fetchAll(PDO::FETCH_CLASS,self::class); 
   }

    // * Apresenta dados zonas vendedor
    // * @param string $where
    // *
    public static function listarFactura($id_conta){
        return (new Database('vendedor JOIN pagamento ON vendedor.id = pagamento.id_vendedor
                            JOIN mensalidade ON pagamento.id_mensalidade = mensalidade.id_mensal
                            JOIN taxa ON mensalidade.id_taxa = taxa.id_taxa
                            JOIN conta ON conta.id_vendedor = vendedor.id
                            JOIN usuario ON usuario.id_us = pagamento.id_us
        '))->select('id_conta = '.$id_conta)->fetchObject(self::class); 
   }


    public static function contaListagen($id){
        return (new Database('vendedor JOIN pagamento ON vendedor.id = pagamento.id_vendedor
                            JOIN mensalidade ON pagamento.id_mensalidade = mensalidade.id_mensal
        '))->select('id = '.$id); 
   }

}