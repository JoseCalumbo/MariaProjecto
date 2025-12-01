<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;

use \App\Model\Entity\PacienteDao;
use \PDO;

class TriagemDao extends PacienteDao
{
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
    public $nome_paciente; // salva o nome do paciente
    public $genero_paciente; // salva o genero do paciente
    public $nascimento_paciente; // salva o data de nascimento do paciente
    public $id_funcionario; // salva o funcionario 

    //Método responsavel por Registrar uma nova triagem
    public function cadastrarTriagem($nomePacinete, $generoPacinete, $nascimentoPacinete, $bilhetePaciente)
    {
        $obPacientes = new PacienteDao;
        $idPacienteCadastrado = $obPacientes->registrarTriagemPaciente($nomePacinete, $generoPacinete, $nascimentoPacinete, $bilhetePaciente);
        $this->id_paciente = $idPacienteCadastrado;

        //Pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $this->id_funcionario = $usuarioLogado['id'];

        //Obtem a data e hora actual 
        $this->data_triagem = date('y-m-d H:i:s');

        $obDatabase = new Database('tb_triagem');
        $this->id_triagem = $obDatabase->insert([
            'id_triagem' => $this->id_triagem,
            'observacao_triagem' => $this->observacao_triagem,

            'peso_triagem' => $this->peso_triagem,
            'temperatura_triagem' => $this->temperatura_triagem,
            'pressao_arterial_triagem' => $this->pressao_triagem,
            'frequencia_cardiaca_triagem' => $this->cardiaca_triagem,
            'frequencia_respiratorio_triagem' => $this->frequencia_triagem,
            'Saturacao_oxigenio_triagem' => $this->saturacao_triagem,

            'id_paciente' => $this->id_paciente,
            'id_funcionario' => $this->id_funcionario,
            'data_triagem' => $this->data_triagem,
            'risco_triagem' => $this->risco_triagem
        ]);
        return $this->id_triagem;
    }
    //Método responsavel por Registrar 
    public function cadastrarNovaTriagem($idPacinete)
    {
        //Pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $this->id_funcionario = $usuarioLogado['id'];

        $this->id_paciente = $idPacinete;

        //Obtem a data e hora actual 
        $this->data_triagem = date('y-m-d H:i:s');

        $obDatabase = new Database('tb_triagem');
        $this->id_triagem = $obDatabase->insert([
            'id_triagem' => $this->id_triagem,
            'observacao_triagem' => $this->observacao_triagem,

            'peso_triagem' => $this->peso_triagem,
            'temperatura_triagem' => $this->temperatura_triagem,
            'pressao_arterial_triagem' => $this->pressao_triagem,
            'frequencia_cardiaca_triagem' => $this->cardiaca_triagem,
            'frequencia_respiratorio_triagem' => $this->frequencia_triagem,
            'Saturacao_oxigenio_triagem' => $this->saturacao_triagem,

            'id_paciente' => $this->id_paciente,
            'id_funcionario' => $this->id_funcionario,
            'data_triagem' => $this->data_triagem,
            'risco_triagem' => $this->risco_triagem
        ]);
        return $this->id_triagem;
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

    // faz um delete de um registro 
    public function apagarTriagem()
    {
        return (new Database('tb_triagem'))->delete('id_triagem = ' . $this->id_triagem, []);
    }

    // faz um delete de um registro apartir do paciente
    public function apagarTriagemPaciente($id_paciente)
    {
        return (new Database('tb_triagem'))->delete('id_paciente = ' . $id_paciente, []);
    }


    /** Apresenta as listagem dados da triagem
     * @param string $where
     */
    public static function listarTriagem($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_triagem JOIN tb_paciente ON 
                              tb_triagem.id_paciente = tb_paciente.id_paciente'))->select($where, $order, $limit, $fields);
    }

    /** Apresenta as listagem da triagem correspondente do paciente
     * @param string $where
     */
    public static function getListarTriagemPaciente($id_paciente, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_triagem'))->select('id_paciente = ' . $id_paciente)->fetchObject(self::class);;
    }


    // Método responsavel por selecinar uma triagem salva pelo id
    public static function getTriagemId($id_triagem)
    {
        return (new Database('tb_triagem'))->select('id_triagem = ' . $id_triagem)->fetchObject(self::class);
    }

    // Método responsavel por selecinar uma triagem salva pelo id
    public static function getTriagemRegistradoId($id_triagem)
    {
        return (new Database('tb_triagem JOIN tb_paciente ON
                              tb_triagem.id_paciente = tb_paciente.id_paciente'))->select('id_triagem = ' . $id_triagem)->fetchObject(self::class);
    }




    /** Apresenta as listagem dados da triagem em andamento
     * @param string $where
     */
    public static function listarTriagemFeita($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_triagem JOIN tb_paciente ON 
                              tb_triagem.id_paciente = tb_paciente.id_paciente'))->select($where, $order, $limit, $fields);
    }
}
