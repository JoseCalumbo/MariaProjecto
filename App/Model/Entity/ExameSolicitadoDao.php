<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;


use \PDO;

class ExameSolicitadoDao
{
    // id do exame solicitada
    public $id_exame_solicitado;

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

    // guarda o resultado do exame
    public $resultado_exame;

    // Data de cadastramento do exame
    public $descrisaoResultado_exame;

    //  guarda a descrisão do resultado do exame
    public $criado_exameSolicitado;


    /*	
            'id_exame_solicitado'=>      
        	'descrisaoResultado_exame' =>
            'resultado_exame'=>
            'id_consulta'=>
            'id_funcionario'=>	
            'id_exame'=>
            'tipo_exame'=>
            'emergencia_exame'=>
            'parametro_exame'=>
            'criado_exameSolicitado'=>	

            'id_consulta' => $this->id_consulta=1,
            'id_funcionario' => $this->id_funcionario =1,
            'id_exame' => $this->id_exame,
            'tipo_exame' => $this->tipo_exame,
            'parametros' => $this->parametro_exame,
            'emergencia' => $this->emergencia_exame,
            'criado_exameSolicitado' => $this->criado_exame,


        */

    // faz um insert na tabela exame
    public function cadastrarExameSolicitado()
    {
        $usuarioLogado = Session::getUsuarioLogado();
        $this->id_funcionario = $usuarioLogado['id'];

        // Instancia da Database
        $obDatabase = new Database('tb_consulta_exames');

        $this->id_exame_solicitado = $obDatabase->insert([
            'id_consulta'             => $this->id_consulta = 1,
            'id_funcionario'          => $this->id_funcionario,
            'id_exame'                => $this->id_exame,
            'tipo_exame'              => $this->tipo_exame,
            'emergencia_exame'        => $this->emergencia_exame,
            'parametro_exame'         => $this->parametro_exame,
            'criado_exameSolicitado'  => $this->criado_exameSolicitado,
        ]);
        return true;
    }

    // Metodo responsavel por lançar o resultado do exame
    public function LançarResultado()
    {
        return (new Database('tb_consulta_exames'))->update('id_exame_solicitado = ' . $this->id_exame_solicitado, [
            'descrisaoResultado_exame' => $this->resultado_exame,
            'resultado_exame'         => $this->descrisaoResultado_exame,
        ]);
    }

    // faz um delete na tabela exame
    public function apagarExame()
    {
        return (new Database('tb_exame'))->delete('id_exame = ' . $this->id_exame);
    }


    # Apresenta os resultado da tabela exames Solicitados
    public static function listarExameSolicitado($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames'))->select($where, $order, $limit, $fields);
    }

    //Metodo para  selecionar um registro da tabela exame
    public static function getExameId($id_exame)
    {
        return (new Database('tb_exame'))->select('id_exame = ' . $id_exame)->fetchObject(self::class);
    }
}
