<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \PDO;

class FuncionarioNivelDao
{
    // id  e funcionario nivel
    public $id_funcionario_nivel;

    // dados de permissao
    public $id_nivel;

    // dados de funcionario
    public $id_funcionario;

    // metodo para add nivel de Acesso ao usuario
    public function addNivelAcesso()
    {
        $obDatabase = new Database('tb_funcionario_nivel');
        $obDatabase->insert([
            'id_usuario' => $this->id_funcionario,
            'id_nivel' => $this->id_nivel,
        ]);
        return true;
    }

    //atulizar os dados do Funcionario quanto seu nivel de acesso
    public function atualizarNivelAcesso()
    {
        return (new Database('tb_funcionario_nivel'))->update('id_funcionario_nivel = ' . $this->id_funcionario_nivel, [
            'id_funcionario_nivel' => $this->id_funcionario_nivel,
            'id_usuario' => $this->id_funcionario,
            'id_nivel' => $this->id_nivel,
        ]);
    }

    /** Listar todas as permissoes nivel possivel
     * @param string $where
     */
    public static function listarPermissao($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_permissoes'))->select($where, $order, $limit, $fields);
    }

    // Método para pegar o id dos nivel
    public static function getFuncionarioNivelId($id_funcionario)
    {
        return (new Database('tb_funcionario_nivel '))->select('id_usuario = ' . $id_funcionario);
    }

    // Método para pegar o id dos nivel
    public static function getNivelPermissaoID($id_nivel)
    {
        return (new Database('tb_nivel_permissoes'))->select('id_nivel = ' . $id_nivel);
    }
}
