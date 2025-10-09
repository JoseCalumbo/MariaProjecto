<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \PDO;

class NivelPermissaoDao
{
    public $id; // id nivel e permissao

    // dados de permissao
    public $id_nivel;

    // dados de permissao
    public $id_permissoes;


    // metodo para inserir um novas permissão na tabela
    public function addPermissao()
    {
        $obDatabase = new Database('tb_nivel_permissoes');
        $obDatabase->insert([
            'id_nivel' => $this->id_nivel,
            'id_permissoes' => $this->id_permissoes,
        ]);
        return true;
    }

    /** Listar todas as permissoes nivel possivel
     * @param string $where
     */
    public static function listarPermissao($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_permissoes'))->select($where, $order, $limit, $fields);
    }

    // Método para pegar o id dos nivel
    public static function getNivelPermissaoID($id_nivel)
    {
        return (new Database('tb_nivel_permissoes'))->select('id_nivel = ' . $id_nivel);
    }
}
