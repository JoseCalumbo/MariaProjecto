<?php

namespace App\Model\Entity;
use \App\Model\Database;

use \PDO;

class MedicamentoPrescritoDao
{
    // id Medicamento Prescrito
    public $id;

    // id receita 
    public $id_receita;
    //id medicamento 
    public $id_medicamento;
    // posologia
    public $posologia_medicamento;
    // via
    public $via_administracao;
    // quantidade
    public $quantidade;
    //  duração do tratamento
    public $duracao_dias;
    //  data inicio
    public $data_inicio;
    //  data fim
    public $data_fim;
    //  observação
    public $observacoes;

    // faz um insert na tabela exame
    public function cadastrarMedicamentosPrescrito()
    {
        // Instancia da Database
        $obDatabase = new Database('tb_medicamento_prescrito');

        $this->id = $obDatabase->insert([
            'id_receita'              => $this->id_receita,
            'id_medicamento'          => $this->id_medicamento,
            'posologia_medicamento'   => $this->posologia_medicamento,
            'via_administracao'       => $this->via_administracao,

            'quantidade'              => $this->quantidade,
            'duracao_dias '           => $this->duracao_dias,
            'data_inicio'             => $this->data_inicio,
            'data_fim'                => $this->data_inicio,
            'observacoes'             => $this->observacoes,
        ]);
        return $this->id;
    }

      //Metodo para  selecionar um registro da tabela medicamento prescrito
    public static function getMedicamentoPrescritoID($id_receita)
    {
        return (new Database('tb_medicamento_prescrito'))->select('id_receita = ' . $id_receita)->fetchObject(self::class);
    }

    // Apresenta os medicamentos Prescrito na receita
    public static function listarMedicamentoPresecrito($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_medicamento_prescrito mp
                             JOIN tb_receita r ON mp.id_receita = r.id_receita
                             JOIN tb_medicamento m ON m.id_medicamento = mp.id_medicamento'))->select($where, $order, $limit, $fields);
    }


}
