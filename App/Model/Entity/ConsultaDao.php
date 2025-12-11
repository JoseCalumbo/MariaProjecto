<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;

use \App\Model\Entity\PacienteDao;
use \PDO;

class ConsultaDao extends PacienteDao
{
    //campos consulta
    public $id_consulta;
    public $conduta_consulta;
    public $motivo_consulta;
    public $diagnostico_consulta;
    public $observacao_consulta;

    public $retorno_consulta;
    public $criado_consulta;
    public $alterado_consulta;
    public $estado_consulta;

    // campos da triagem
    public $id_triagem;
    public $observacao_triagem;
    public $peso_triagem;
    public $temperatura_triagem;
    public $pressao_triagem;
    public $frequencia_triagem;
    public $cardiaca_triagem;
    public $saturacao_triagem;
    public $risco_triagem;
    public $data_triagem;

    // campos chaves estrangeiros
    public $id_paciente; // salva o idp do paciente
    public $id_funcionario; // salva o funcionario 

    // Método responsavel por registrar consulta
    public function cadastrarConsulta()
    {
        //Pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $this->id_funcionario = $usuarioLogado['id'];

        //Obtem a data e hora actual 
        $this->criado_consulta = date('y-m-d H:i:s');

        $obDatabase = new Database('tb_consulta');

        $this->id_consulta = $obDatabase->insert([
            'id_paciente' => $this->id_paciente,
            'id_funcionario' => $this->id_funcionario,
            'id_triagem' => $this->id_triagem,

            'retorno_consulta' => $this->retorno_consulta,
            'conduta_consulta' => $this->conduta_consulta,
            'motivo_consulta' => $this->motivo_consulta,
            'diagnostico_consulta' => $this->diagnostico_consulta,
            'observacao_consulta' => $this->observacao_consulta,
            'criado_consulta' => $this->criado_consulta,
        ]);

        return $this->id_consulta;
    }

    //Método responsavel ao estado da consulta
    public function estadoConsulta($estado)
    {
        return (new Database('tb_consulta'))->update('id_consulta = ' . $this->id_consulta, [
            'estado_consulta' => $this->estado_consulta = $estado,
        ]);
    }

    //Método responsavel ao estado da consulta
    public function finalizarConsulta()
    {
        return (new Database('tb_consulta'))->update('id_consulta = ' . $this->id_consulta, [
            'estado_consulta' => $this->estado_consulta = "Finalizada",
        ]);
    }

    //Método responsavel ao estado da consulta
    public function validarConsulta()
    {
        return (new Database('tb_consulta'))->update('id_consulta = ' . $this->id_consulta, [
            'estado_consulta' => $this->estado_consulta = "Remarcada",
        ]);
    }

    //Método responsavel ao estado da consulta
    public function esperarExameConsulta()
    {
        return (new Database('tb_consulta'))->update('id_consulta = ' . $this->id_consulta, [
            'estado_consulta' => $this->estado_consulta = "Exames pendentes",
        ]);
    }

    // Método responsavel para selecionar uma consulta
    public static function getConsulta($id_consulta)
    {
        return (new Database('tb_consulta'))->select('id_consulta = ' . $id_consulta)->fetchObject(self::class);
    }

    # Apresenta os resultado da tabela exames Solicitados
    public static function getConsultaRelizada($id_consulta)
    {
        return (new Database('tb_consulta c 
                              JOIN tb_paciente p ON c.id_paciente  = p.id_paciente                               
                              '))->select('c.id_consulta =' . $id_consulta)->fetchObject(self::class);
    }

    # Apresenta os resultado da tabela exames Solicitados
    public static function quantidadeReceitaAdcionado($id_consulta, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c1 ON ce.id_consulta = c1.id_consulta 
                              JOIN tb_paciente p ON c1.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame
                              '))->select('ce.estado_exame_solicitado = "solicitado" AND c1.id_consulta =' . $id_consulta, $order, $limit, $fields);
    }

    /** Apresenta as listagem dados da triagem
     * @param string $where
     */
    public static function listarTriagemFeita($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_triagem JOIN tb_paciente ON 
                              tb_triagem.id_paciente = tb_paciente.id_paciente'))->select($where, $order, $limit, $fields);
    }

    /** Apresenta as listagem da consulta feita
     * @param string $where
     */
    public static function listarConsultaFeita($id, $order = null, $limit = null, $fields = '*')
    {
        //Pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $id = $usuarioLogado['id'];

        return (new Database('tb_consulta JOIN tb_paciente ON 
                              tb_consulta.id_paciente = tb_paciente.id_paciente')
        )->select('tb_consulta.id_funcionario = ' . $id . '', $order, $limit, $fields);
    }
}
