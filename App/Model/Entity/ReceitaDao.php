<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;

use \App\Model\Entity\ConsultaDao;

use \PDO;

class ReceitaDao extends ConsultaDao
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

    //Metodo para  selecionar um registro da tabela exame
    public static function getReceitaID($id_exame)
    {
        return (new Database('tb_exame'))->select('id_exame = ' . $id_exame)->fetchObject(PDO::FETCH_CLASS . self::class);
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




}
