<?php

namespace App\Model;

use \PDO;
use \PDOException;

class Database{

    private static $host;
    private static $name;
    private static $user;
    private static $pass;
    private static $port;

    private $table;
    private $connection;

   /**
   * Método responsável por configurar a classe
   * @param  string  $host
   * @param  string  $name
   * @param  string  $user
   * @param  string  $pass
   * @param  integer $port
   */
  public static function config($host,$name,$user,$pass,$port = 3306){
    self::$host = $host;
    self::$name = $name;
    self::$user = $user;
    self::$pass = $pass;
    self::$port = $port;
  }

  // metodo estrutura class 
    public function __construct($table=null){
        $this->table=$table;
        $this->setConnection();
    }

    // conecta a BD com php
    private function setConnection(){

        try {
            $this->connection = new PDO('mysql:host='.self::$host.';dbname='.self::$name.';port='.self::$port,self::$user,self::$pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e){
            die('ERROR'.$e->getMessage());
      }
    } // fim de set connection


    // Executa sql
    public function execute($query,$params=[]){
        try {
       $statement = $this->connection->prepare($query);
       $statement->execute($params);
       return $statement;
        } catch (PDOException $e){
            die('ERROR'.$e->getMessage());
      }
    }

    // Metodo responsavel por excutar sql salva dados na tabela
    public function insert($values) {

    $fields= array_keys($values);
    $binds = array_pad([],count($fields),'?');

    $query = 'INSERT INTO '.$this->table.'('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

     $this->execute($query,array_values($values));

    return $this->connection->lastInsertId();
    }

    // sql script consultar registro
    public function select($where=null, $order = null, $limit = null, $fields = '*'){

        $where=strlen($where) ? 'WHERE '.$where :'';
        $order=strlen($order) ? 'ORDER BY '.$order :'';
        $limit=strlen($limit) ? 'LIMIT '.$limit :'';

        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

         //echo $query; // exit;

        return $this-> execute($query);
    }

    // sql script atualizar registro
    public function update($where,$values){

        $fields = array_keys($values);

        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

        $this->execute($query,array_values($values));
        
        // echo '<pre>'; print_r($query);  echo '</pre>'; exit;
        return true;
    }

    // sql script apagar registro
    public function delete($where){
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
        $this->execute($query);

       //echo '<pre>'; print_r($query);  echo '</pre>'; exit;

        return true;
    }

}