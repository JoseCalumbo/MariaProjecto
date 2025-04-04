<?php

namespace App\Utils;

use \App\Model\Database;
use \App\Utils\Session;
use \App\Model\Entity\AddNegocioDao;
use App\Model\Entity\MensalidadeDao;
use \App\Model\Entity\NegocioDao;
use PDO;

  class GerarMensalidade {

    public $meses;

    public $data_vencimento;

     public $taxa;

     public $criado;
    

    public function __construct(){

        $this->data_vencimento = Date('Y-m-d', strtotime('+'. 30 .' days'));

        $this->criado = Date('Y-m-d', strtotime('-'. 30 .' days'));

        $this->dataActual = Date('Y-m-d');
        
        $this->meses = Date('M',strtotime('+'. 30 .' days'));
        
        $this->gerar();
    }

    // metodo que gera uma nova mensalidade no sistema
    private function gerar(){

        $hoje = $this->dataActual;

        //Obtem o mes actual 
        $obmensal =  MensalidadeDao::getMensal($hoje);

        $status = $obmensal->status_mensalidade ?? '';

        if($status == 's'){

            // Altera o statu mensal
            $obmensal->atualizarStatusMensal();

            // Instancia uma nova class mensal 
            $obMensalNew = new MensalidadeDao();
            
            $obMensalNew->id_taxa = 1;
            $obMensalNew->vencimento = $this->data_vencimento;
            $obMensalNew->mes = $this->meses;
            
            $obMensalNew->cadastrarMesalidade();
        }

        echo '<pre>';
        print_r('passou...', $hoje);
        echo '</pre>';
    }
        
}