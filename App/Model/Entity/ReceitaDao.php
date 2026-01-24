<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;

use \PDO;

class ReceitaDao
{
    public $id_receita;
    public $data_receita;
    public $alergias;
    public $medicamentos_em_uso;
    public $observacoes;
    public $status;

    // campos chaves estrangeiros
    public $id_paciente; // salva o idp do paciente
    public $id_funcionario; // salva o funcionario 
    public $id_consulta; // salva o funcionario 

    // metodo para inserir um novo vendedor na tabela
    public function cadastrarReceita()
    {
        $usuarioLogado = Session::getUsuarioLogado();
        // Pega a data actual do cadastro
        $this->data_receita = date('y-m-d H:i:s');
        //Pega o id do usuario logado
        $this->id_funcionario = $usuarioLogado['id'];

        $obDatabase = new Database('tb_receita');
        $this->id_receita = $obDatabase->insert([
            'id_receita' => $this->id_receita,
            'id_funcionario' => $this->id_funcionario,
            'id_paciente' => $this->id_paciente,
            'id_consulta' => $this->id_consulta,
            'alergias' => $this->alergias,
            'medicamentos_em_uso' => $this->medicamentos_em_uso,
            'observacoes ' => $this->observacoes ,
            'status' => $this->status ="ativa",
            'data_receita' => $this->data_receita,
        ]);

        return $this->id_receita;
    }

    //Metodo para  selecionar um registro da tabela receita
    public static function getReceitaID($id_receita)
    {
        return (new Database('tb_receita'))->select('id_receita = ' . $id_receita)->fetchObject(self::class);
    }


    # Apresenta os resultado da tabela exames Solicitados
    // public static function quantidadeReceitaAdcionado($id_consulta, $order = null, $limit = null, $fields = '*')
    // {
    //     return (new Database('tb_consulta_exames ce 
    //                           JOIN tb_consulta c1 ON ce.id_consulta = c1.id_consulta 
    //                           JOIN tb_paciente p ON c1.id_paciente  = p.id_paciente 
    //                           JOIN tb_exame    e ON e.id_exame    =  ce.id_exame
    //                           '))->select('ce.estado_exame_solicitado = "solicitado" AND c1.id_consulta =' . $id_consulta, $order, $limit, $fields);
    // }
}
