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

    // energencia exame
    public $emergencia_exame;

    // guarda o estado do exame
    public $estado_exame_solicitado;

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
            'id_consulta'             => $this->id_consulta,
            'id_funcionario'          => $this->id_funcionario,
            'id_exame'                => $this->id_exame,
            'tipo_exame'              => $this->tipo_exame,
            'emergencia_exame'        => $this->emergencia_exame,
            'criado_exameSolicitado'  => $this->criado_exameSolicitado,
        ]);
        return true;
    }

    // Metodo responsavel por lançar o estado do exame
    public function alterarEstadoExame()
    {
        return (new Database('tb_consulta_exames'))->update('id_exame_solicitado = ' . $this->id_exame_solicitado, [
            'estado_exame_solicitado' => $this->estado_exame_solicitado,
        ]);
    }

    /* Apresenta os resultado da tabela exames Solicitados
    public static function getExameSolicitado($id_exame_solicitado)
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c ON ce.id_consulta = c.id_consulta 
                              JOIN tb_paciente p ON c.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame 
                              WHERE ce.estado_exame_solicitado = "solicitado"')
                              )->select('id_exame_solicitado ='.$id_exame_solicitado);
    }

    */

    # Apresenta os resultado da tabela exames Solicitados
    public static function listarExameSolicitado($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c ON ce.id_consulta = c.id_consulta 
                              JOIN tb_paciente p ON c.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame 
                              WHERE ce.estado_exame_solicitado = "solicitado"'))->select($where, $order, $limit, $fields);
    }

    # Apresenta o numero total de exames Solicitados em uma consulta
    public static function quantidadeExameSolicitado($id_consulta, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c1 ON ce.id_consulta = c1.id_consulta 
                              JOIN tb_paciente p ON c1.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame
                              '))->select('ce.estado_exame_solicitado = "solicitado" AND c1.id_consulta ='.$id_consulta, $order, $limit, $fields);
    
    }

    # Apresenta os resultado da tabela exames Solicitados na pagina de validação da consuta
    public static function listarExameSolicitadoValido($id_consulta, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c1 ON ce.id_consulta = c1.id_consulta 
                              JOIN tb_paciente p ON c1.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame
                              '))->select('ce.estado_exame_solicitado = "solicitado" AND c1.id_consulta ='.$id_consulta, $order, $limit, $fields);
    
    }


     # Apresenta os resultado da tabela exames Solicitados
    public static function listarExameFinalizado($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c ON ce.id_consulta = c.id_consulta 
                              JOIN tb_paciente p ON c.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame 
                              JOIN tb_exame_resultado er ON  er.id_exame_solicitado = ce.id_exame_solicitado 
                              WHERE ce.estado_exame_solicitado = "concluído"'))->select($where, $order, $limit, $fields);
    }

    //Metodo para  selecionar exame solicitado
    public static function getExameSolicitadoId($id_exame)
    {
        return (new Database('tb_consulta_exames'))->select('id_exame_solicitado = ' . $id_exame)->fetchObject(self::class);
    }
}
