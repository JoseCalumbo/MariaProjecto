<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;


use \PDO;

class ExameSolicitadoDao
{
    // id do exame solicitada
    public $id_exameSolicitada;

    // id consulta
    public $id_consulta;

    //id exame 
    public $id_exame;

    //id funcionario
    public $id_funcionario;

    // tipo de exame
    public $tipo_exame;

    // tipo de exame
    public $parametro_exame;

    // energencia exame
    public $emergencia_exame;

    // Data de cadastramento do exame
    public $criado_exame;


    // faz um insert na tabela exame
    public function cadastrarExameSolicitado()
    {
        $usuarioLogado = Session::getUsuarioLogado();
        $this->id_funcionario = $usuarioLogado['id'];

        // Instancia da Database
        $obDatabase = new Database('tb_consulta_examepedido');

        $this->id_exameSolicitada = $obDatabase->insert([
            'id_consulta' => $this->id_consulta=1,
            'id_funcionario' => $this->id_funcionario =1,
            'id_exame' => $this->id_exame,
            'tipo_exame' => $this->tipo_exame,
            'parametros' => $this->parametro_exame,
            'emergencia' => $this->emergencia_exame,

            'criado_exameSolicitado' => $this->criado_exame,
        ]);
        return true;
    }

    // faz um update na tabela da exame
    public function AtualizarExame()
    {
        return (new Database('tb_exame'))->update('id_exame = ' . $this->id_exame, [
            'id_exame' => $this->id_exame,
            'id_exame' => $this->id_exame,
            'tipo_exame' => $this->tipo_exame,
            'parametro_exame' => $this->parametro_exame,
            'criado_exame' => $this->criado_exame,
        ]);
    }

    // faz um delete na tabela exame
    public function apagarExame()
    {
        return (new Database('tb_exame'))->delete('id_exame = ' . $this->id_exame);
    }

    /**
     * Apresenta os resultado da tabela exame
     * @param string $where
     */
    public static function listarExame($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_exame'))->select($where, $order, $limit, $fields);
    }

    //Metodo para  selecionar um registro da tabela exame
    public static function getExameId($id_exame)
    {
        return (new Database('tb_exame'))->select('id_exame = ' . $id_exame)->fetchObject(self::class);
    }

    //Metodo para  selecionar um registro da tabela exame
    public static function getExameId1($id_exame)
    {
        return (new Database('tb_exame'))->select('id_exame = ' . $id_exame)->fetchObject(PDO::FETCH_CLASS . self::class);
    }
}
