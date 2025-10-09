<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \PDO;

class NivelDao
{
    // dados do nivel pessoal
    public $id_nivel;
    public $nome_nivel;
    public $serie_nivel;
    public $descricao_nivel;
    public $criado_nivel;

    // metodo para inserir um novo vendedor na tabela
    public function cadastrarNivelAcesso()
    {
        // Pega a data actual do cadastro
        $this->criado_nivel = date('y-m-d H:i:s');

        $obDatabase = new Database('tb_nivel');

        $this->id_nivel = $obDatabase->insert([
            'id_nivel' => $this->id_nivel,
            'nome_nivel' => $this->nome_nivel,
            'descricao_nivel' => $this->descricao_nivel,
            'criado_nivel' => $this->criado_nivel,
        ]);

        return $this->id_nivel;
    }

 
    //atulizar campo de vendedor
    public function atualizar()
    {
        return (new Database('tb_nivel'))->update('id_nivel = ' . $this->id_nivel, [
            'id_nivel' => $this->id_nivel,
            'nome_nivel' => $this->nome_nivel,
            'descricao_nivel' => $this->nome_nivel,
        ]);
    }

    // metodo para deletar um vendedor na tabela
    public function apagar()
    {
        return (new Database('tb_nivel'))->delete('id_nivel =' . $this->id_nivel, []);
    }

    /** Lista todos os nivel cadastrado
     *  @param string $where
     */
    public static function listarNivelForm($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_nivel'))->select($where, $order, $limit, $fields);
    }

    /** Lista todos os nivel cadastrado
     *  @param string $where
     */
    public static function listarNivelPerfil($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_nivel'))->select($where, $order, $limit, $fields);
    }

    // Método para pegar o id dos nivel
    public static function getNivelId($id_nivel)
    {
        return (new Database('tb_nivel'))->select('id_nivel = ' . $id_nivel)->fetchObject(self::class);
    }


    /**
     * Lista todos os nivel cadastrado
     * @param string $where
     */
    public static function listarNivel($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_funcionario f
            INNER JOIN tb_funcionario_nivel fn ON f.id_funcionario = fn.id_usuario
            INNER JOIN tb_nivel_permissoes np ON fn.id_nivel = np.id_nivel
            INNER JOIN tb_permissoes p ON np.id_permissoes = p.id_permissao
    '))->select($where, $order, $limit, $fields);
    }

    // Método para pegar o id nivel 
    public static function VerificarNivel($id_funcionario)
    {
        return (new Database('tb_funcionario f
                INNER JOIN tb_funcionario_nivel fn ON f.id_funcionario = fn.id_usuario
                INNER JOIN tb_nivel_permissoes np ON fn.id_nivel = np.id_nivel
                INNER JOIN tb_permissoes p ON np.id_permissoes = p.id_permissao')
        )->select('id_funcionario = ' . $id_funcionario)->fetchObject(self::class);
    }

    // Método para pegar o id nivel 
    public static function VerificarNivel1($id_funcionario)
    {
        return (new Database('tb_funcionario f
                INNER JOIN tb_funcionario_nivel fn ON f.id_funcionario = fn.id_usuario
                INNER JOIN tb_nivel_permissoes np ON fn.id_nivel = np.id_nivel
                INNER JOIN tb_permissoes p ON np.id_permissoes = p.id_permissao')
        )->select('id_funcionario = ' . $id_funcionario)->fetchAll();
    }

    // Método para pegar o id nivel 
    public static function VerificarNivel2($id_funcionario)
    {
        return (new Database('usuario u
    INNER JOIN usuario_nivel un ON u.id_usuario = un.id_usuario
    INNER JOIN nivel_permissao np ON un.id_nivel = np.id_nivel
    INNER JOIN permissao p ON np.id_permissao = p.id_permissao')
        )->select('id_funcionario = ' . $id_funcionario)->fetch(MYSQLI_BOTH);
    }
}
