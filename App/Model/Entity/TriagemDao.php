<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Model\Entity\PacienteDao;
use \PDO;

class TriagemDao extends PacienteDao
{
    public $id_triagem;
    public $observacao_triagem;
    public $peso_triagem;
    public $temperatura_triagem;
    public $presao_triagem;
    public $create_triagem;

    // campos chaves estrangeiros
    public $id_paciente; // salva o id do paciente
    public $nome_paciente; // salva o nome do paciente
    public $genero_paciente; // salva o genero do paciente
    public $nascimento_paciente; // salva o data de nascimento do paciente
    public $id_funcionario; // salva o funcionario 

    //Método responsavel por Registrar uma nova triagem
    public function cadastrarTriagem()
    {
        parent::cadastrarPaciente();

        echo '<pre>';
        print_r(parent::cadastrarPaciente());
        echo '</pre>';
        exit;

        $this->create_triagem = date('y-m-d H:i:s');
        $obDatabase = new Database('tb_triagem');
        $this->id_triagem = $obDatabase->insert([
            'id_triagem' => $this->id_triagem,
            'observacao_triagem' => $this->observacao_triagem,
            'peso_triagem' => $this->peso_triagem,
            'temperatura_triagem' => $this->temperatura_triagem,
            'presao_triagem' => $this->presao_triagem,
            'id_paciente' => $this->id_paciente,
            'id_funcionario' => $this->id_funcionario,
            'create_triagem' => $this->create_triagem,
        ]);
        return true;
    }

    //Método responsavel por Alterar o registrar da triagem
    public function atualizar()
    {
        return (new Database('tb_triagem'))->update('id_triagem = ' . $this->id_triagem, [
            'id_triagem' => $this->id_triagem,
            'observacao_triagem' => $this->observacao_triagem,
            'peso_triagem' => $this->peso_triagem,
            'temperatura_triagem' => $this->temperatura_triagem,
            'presao_triagem' => $this->presao_triagem,
            'id_paciente' => $this->id_paciente,
            'id_funcionario' => $this->id_funcionario,
            'create_triagem' => $this->create_triagem,
        ]);
    }

    // faz um delete na tabela usuario
    public function apagar()
    {
        return (new Database('usuario'))->delete('id_us = ' . $this->id_triagem, []);
    }


    /** Apresenta os resultado
     * @param string $where
     */
    public static function listarUsuario($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('usuario'))->select($where, $order, $limit, $fields);
    }


    //para pegar o user id
    public static function getUsuarioId($id_triagem)
    {
        return (new Database('usuario'))->select('id_us = ' . $id_triagem)->fetchObject(self::class);
    }
}
