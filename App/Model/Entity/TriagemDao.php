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
    public $presao_triagem;
    public $frequencia_triagem;
    public $risco_triagem;
    public $create_triagem;

    // campos chaves estrangeiros
    public $id_paciente; // salva o idp do paciente
    public $nome_paciente; // salva o nome do paciente
    public $genero_paciente; // salva o genero do paciente
    public $nascimento_paciente; // salva o data de nascimento do paciente
    public $id_funcionario; // salva o funcionario 

    //Método responsavel por Registrar uma nova triagem
    public function cadastrarTriagem($nomePacinete, $generoPacinete, $nascimentoPacinete)
    {
        $obPacientes = new PacienteDao;
        $idPacienteCadastrado = $obPacientes->registrarTriagemPaciente($nomePacinete, $generoPacinete, $nascimentoPacinete);
        $this->id_paciente =$idPacienteCadastrado;

        //Pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $this->id_funcionario = $usuarioLogado['id'];

        //Obtem a data e hora actual 
        $this->create_triagem = date('y-m-d H:i:s');

        $obDatabase = new Database('tb_triagem');
        $this->id_triagem = $obDatabase->insert([
            'id_triagem' => $this->id_triagem,
            'observacao_triagem' => $this->observacao_triagem,
            'peso' => $this->peso_triagem,
            'temperatura' => $this->temperatura_triagem,
            'pressao' => $this->presao_triagem,
            'frequencia'=> $this->frequencia_triagem,
            'id_paciente' => $this->id_paciente,
            'id_funcionario' => $this->id_funcionario,
            'data_triagem'=> $this->create_triagem,
            'risco'=> $this->risco_triagem ='Verde'
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


    /** Apresenta as listagem dados da triagem
     * @param string $where
     */
    public static function listarTriagem($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_triagem JOIN tb_paciente ON 
                              tb_triagem.id_triagem = tb_paciente.id_paciente'))->select($where, $order, $limit, $fields);
    }


    //para pegar o user id
    public static function getUsuarioId($id_triagem)
    {
        return (new Database('usuario'))->select('id_us = ' . $id_triagem)->fetchObject(self::class);
    }
}
