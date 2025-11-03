<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class MedicamentoDao
{
    // id do medicamento
    public $id_medicamento;

    //Nome do medicamento
    public $nome_medicamento;

    // descrição de medicamento
    public $descricao_medicamento;

    // dosagem de medicamento
    public $dosagem_medicamento;

    // forma do medicamento
    public $forma_medicamento;

    // validade do medicamento
    public $validade_medicamento;

    // estoque medicamento
    public $estoque_medicamento;

    // preço medicamento
    public $preco_medicamento;

    // fornecedor medicamento
    public $fornecedor_medicamento;

    // Data de cadastramento do medicamento
    public $criado_medicamento;


    // faz um insert na tabela medicamento
    public function cadastrarMedicamento()
    {
        // Instancia da Database
        $obDatabase = new Database('tb_medicamento');

        $this->id_medicamento = $obDatabase->insert([

            'id_medicamento' => $this->id_medicamento,
            'nome_me' => $this->nome_medicamento,
            'descricao_medicamento' => $this->descricao_medicamento,
            'dosagem_medicamento' => $this->dosagem_medicamento,
            'forma_medicamento' => $this->forma_medicamento,
            'validade_medicamento' => $this->validade_medicamento,
            'estoque_medicamento' => $this->estoque_medicamento,
            'preco_medicamento' => $this->preco_medicamento,
            'fornecedor_medicamento' => $this->fornecedor_medicamento,
            'criado_medicamento' => $this->criado_medicamento,

        ]);
        return true;
    }

    // faz um update na tabela da Medicamento
    public function atualizarMedicamento()
    {
        return (new Database('tb_medicamento'))->update('id_medicamento = ' . $this->id_medicamento, [
            'id_medicamento' => $this->id_medicamento,
            'nome_me' => $this->nome_medicamento,
            'descricao_medicamento' => $this->descricao_medicamento,
            'dosagem_medicamento' => $this->dosagem_medicamento,
            'forma_medicamento' => $this->forma_medicamento,
            'validade_medicamento' => $this->validade_medicamento,
            'estoque_medicamento' => $this->estoque_medicamento,
            'preco_medicamento' => $this->preco_medicamento,
            'fornecedor_medicamento' => $this->fornecedor_medicamento,
            'criado_medicamento' => $this->criado_medicamento,
        ]);
    }

    // Faz um delete na tabela medicamento
    public function apagarMedicamento()
    {
        return (new Database('tb_medicamento'))->delete('id_medicamento = ' . $this->id_medicamento);
    }

    /**
     * Apresenta os resultados da tabela medicamentos
     * @param string $where
     */
    public static function listarMedicamento($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_medicamento'))->select($where, $order, $limit, $fields);
    }

    // Metodo para  selecionar um registro da tabela medicamento
    public static function getMedicamentoId($id_medicamento)
    {
        return (new Database('tb_medicamento'))->select('id_medicamento = ' . $id_medicamento)->fetchObject(self::class);
    }

    //Metodo para  selecionar um registro da tabela medicamento
    public static function getExameId1($id_medicamento)
    {
        return (new Database('tb_medicamento'))->select('id_medicamento = ' . $id_medicamento)->fetchObject(PDO::FETCH_CLASS . self::class);
    }
}
