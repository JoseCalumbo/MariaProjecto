<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \PDO;

class PermissaoDao
{
    // dados de permissao
    public $id_permissao;
    public $nome_permissao;
    public $codigo_permisao;

    /**
     * Listar todas as permissoes nivel possivel
     * @param string $where
     */
    public static function listarPermissao($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_permissoes'))->select($where, $order, $limit, $fields);
    }

    // Método para pegar o id dos nivel
    public static function getPermissaoID($id_paciente)
    {
        return (new Database('tb_nivel_permissoes'))->select('id_nivel = ' . $id_paciente)->fetchObject(self::class);
    }

}
