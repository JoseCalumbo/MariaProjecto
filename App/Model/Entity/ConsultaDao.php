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

    //Método responsavel por Alterar o registrar da triagem
    public function atualizarTriagem($nomePacinete, $generoPacinete, $nascimentoPacinete, $idPaciente, $bilhetePaciente)
    {

        $obPacientes = PacienteDao::getPacienteId($idPaciente);
        $idPacienteEditado = $obPacientes->AtualizarTriagemPaciente($nomePacinete, $generoPacinete, $nascimentoPacinete, $bilhetePaciente);
        $this->id_paciente = $idPacienteEditado;

        return (new Database('tb_triagem'))->update('id_triagem = ' . $this->id_triagem, [
            'id_triagem' => $this->id_triagem,
            'observacao_triagem' => $this->observacao_triagem,

            'peso_triagem' => $this->peso_triagem,
            'temperatura_triagem' => $this->temperatura_triagem,
            'pressao_arterial_triagem' => $this->pressao_triagem,

            'frequencia_cardiaca_triagem' => $this->cardiaca_triagem,
            'frequencia_respiratorio_triagem' => $this->frequencia_triagem,
            'Saturacao_oxigenio_triagem' => $this->saturacao_triagem,

            'risco_triagem' => $this->risco_triagem,

            'id_paciente' => $this->id_paciente,
            'id_funcionario' => $this->id_funcionario,
            'data_triagem' => $this->data_triagem,
        ]);
    }

     # Apresenta os resultado da tabela exames Solicitados
    public static function listarConsultaRelizada($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_consulta_exames ce 
                              JOIN tb_consulta c ON ce.id_consulta = c.id_consulta 
                              JOIN tb_paciente p ON c.id_paciente  = p.id_paciente 
                              JOIN tb_exame    e ON e.id_exame    =  ce.id_exame 
                              JOIN tb_exame_resultado er ON  er.id_exame_solicitado = ce.id_exame_solicitado 
                              WHERE ce.estado_exame_solicitado = "concluído"'))->select($where, $order, $limit, $fields);
    }


    /** Apresenta as listagem dados da triagem
     * @param string $where
     */
    public static function listarTriagemFeita($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_triagem JOIN tb_paciente ON 
                              tb_triagem.id_paciente = tb_paciente.id_paciente'))->select($where, $order, $limit, $fields);
    }


    // Método responsavel por selecinar uma triagem salva pelo id
    public static function getTriagemId($id_triagem)
    {
        return (new Database('tb_triagem'))->select('id_triagem = ' . $id_triagem)->fetchObject(self::class);
    }

    
}
