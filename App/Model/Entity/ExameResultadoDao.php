<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;

use \PDO;

class ExameResultadoDao
{
    // id do exame resultado
    public $id_resultado_exame;

    // obs resultado
    public $obs_resultado;

    //id exame solicitado
    public $id_exame_solicitados;

    //exame parametro
    public $parametro_resultado;

    // exame resultadp
    public $resultado_exame;

    // exame referencia
    public $referencia_resultado;

    // guarda o resultado imagem
    public $imagem_resultado;

    // Data resultado exame
    public $data_resultado;

    // Metodo que cadastra o resultado do exame
    public function cadastrarExameResulatdo()
    {
        // Instancia da Database
        $obDatabase = new Database('tb_exame_resultado');

        $this->id_resultado_exame = $obDatabase->insert([
            'id_resultado_exame'     => $this->id_resultado_exame,
            'obs_resultado'          => $this->obs_resultado,
            'id_exame'   => $this->id_exame_solicitados,
            'parametro_resultado'    => $this->parametro_resultado,
            'resultado_exame'        => $this->resultado_exame,
            'referencia_resultado'  => $this->referencia_resultado,
            'imagem_resultado'       => $this->imagem_resultado,
            'data_resultado'  => $this->data_resultado,
        ]);
        return true;
    }

    # Apresenta os resultado da tabela exame resultado
    public static function listarResultadoExame($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c ON ce.id_consulta = c.id_consulta 
                              JOIN tb_paciente p ON c.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame'))->select($where, $order, $limit, $fields);
    }


    //Metodo para  seleciona o resultado do exame
    public static function getExameResultadoId($id_resultado_exame)
    {
        return (new Database('tb_exame_resultado'))->select('id_resultado_exame = ' . $id_resultado_exame)->fetchObject(self::class);
    }
}
