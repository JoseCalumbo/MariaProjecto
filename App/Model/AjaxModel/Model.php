<?php

namespace App\Model\AjaxModel;

abstract class Model{

    private $connection;
        protected string $table = "tb_paciente";
   
    public function __construct()
    {
        $this->connection = Connection::connect();
    }

   public function all(){
    $sql = "SELECT * FROM {$this->table}";
    $all = $this->connection->prepare($sql);
    $all->execute();
    return $all->fetchAll();
   }

}