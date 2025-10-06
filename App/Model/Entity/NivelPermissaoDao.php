<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \PDO;

class NivelPermissaoDao
{
    // dados do paciente pessoal
    public $id_nivel;
    public $id_permissao;

    // metodo para inserir um novo funcionario na tabela
    public function addPermissao()
    {
        $obDatabase = new Database('tb_nivel_permissoes');
        $this->id_nivel = $obDatabase->insert([
            'id_nivel' => $this->id_nivel=2,
            'id_permissoes' => $this->id_permissao,
        ]);

        return true;
    }
    

    /**
     * Listar todas as permissoes nivel possivel
     * @param string $where
     */
    public static function listarPermissao($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_permissoes'))->select($where, $order, $limit, $fields);
    }

    // Método para pegar o id dos nivel
    public static function getNiveld($id_paciente)
    {
        return (new Database('tb_paciente'))->select('id_paciente = ' . $id_paciente)->fetchObject(self::class);
    }
}
