<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;

use \App\Model\Entity\PacienteDao;
use \PDO;

class MarcarConsultaDao extends PacienteDao
{

    /** Apresenta as listagem dados da triagem
     * @param string $where
     */
    public static function listarConsultaMarcada($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_marcacao_consulta '))->select($where, $order, $limit, $fields);
    }
    
}
