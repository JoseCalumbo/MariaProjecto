<?php

namespace App\Model\Entity;

use \App\Model\Database;

use \PDO;

class FornecedorDao
{

    // id do fornecedor
    public $id_fornecedor;

    //Nome do fornecedor
    public $nome_fornecedor;

    // tipo de fornecedor
    public $email_fornecedor;

    // tipo de fornecedor
    public $contacto_fornecedor;

    // valor do fornecedor
    public $endereco_fornecedor;

    // valor do fornecedor
    public $nif_fornecedor;

    // Data de cadastramento do fornecedor
    public $criado_fornecedor;

    // faz um insert na tabela fornecedor
    public function cadastrarFornecedor()
    {
        // Instancia da Database
        $obDatabase = new Database('tb_fornecedor');

        $this->id_fornecedor = $obDatabase->insert([
            'id_fornecedor' => $this->id_fornecedor,
            'nome_fornecedor' => $this->nome_fornecedor,
            'contacto_fornecedor' => $this->contacto_fornecedor,
            'email_fornecedor' => $this->email_fornecedor,
            'endereco_fornecedor' => $this->endereco_fornecedor,
            'nif_fornecedor' => $this->nif_fornecedor,
            'criado_fornecedor' => $this->criado_fornecedor,
        ]);
        return true;
    }


    // faz um update na tabela da fornecedor
    public function AtualizarFornecedor()
    {
        return (new Database('tb_fornecedor'))->update('id_fornecedor = ' . $this->id_fornecedor, [
            'id_fornecedor' => $this->id_fornecedor,
            'nome_fornecedor' => $this->nome_fornecedor,
            'contacto_fornecedor' => $this->contacto_fornecedor,
            'email_fornecedor' => $this->email_fornecedor,
            'endereco_fornecedor' => $this->endereco_fornecedor,
            'nif_fornecedor' => $this->nif_fornecedor,
            'criado_fornecedor' => $this->criado_fornecedor,
        ]);
    }

    // faz um delete na tabela fornecedor
    public function apagarFornecedor()
    {
        return (new Database('tb_fornecedor'))->delete('id_fornecedor = ' . $this->id_fornecedor);
    }

    /**
     * Apresenta os resultado da tabela fornecedor
     * @param string $where
     */
    public static function listarFornecedor($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_fornecedor'))->select($where, $order, $limit, $fields);
    }

    //Metodo para  selecionar um registro da tabela fornecedor
    public static function getFornecedorId($id_fornecedor)
    {
        return (new Database('tb_fornecedor'))->select('id_fornecedor = ' . $id_fornecedor)->fetchObject(self::class);
    }
}
