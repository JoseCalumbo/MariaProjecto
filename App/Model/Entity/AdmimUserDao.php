<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \PDO;

class AdmimUserDao
{
    public $id; // guarda o numero ID unico do usuario Adimim
    public $nome;  // guarda o nome de identificação do usuario Adimim
    public $genero;  // guarda o genero de identificação do usuario Adimim
    public $email; // guarda o email de identificação do usuario Adimim
    public $telefone;
    public $nivel;
    public $imagem;
    public $senha;
    public $morada;
    public $criado;


    //Metodo responsavel por fazer insert na tabela tb_usuario
    public function cadastrar()
    {
        $this->criado = date('y-m-d H:i:s');
        $obDatabase = new Database('tb_usuario');
        $this->id = $obDatabase->insert([
            'id' => $this->id,
            'nome' => $this->nome,
            'genero' => $this->genero,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'nivel' => $this->nivel,
            'imagem' => $this->imagem,
            'morada' => $this->morada,
            'senha' => $this->senha,
            'criado' => $this->criado
        ]);
        return true;
    }

    // faz um update na tabela usuario
    public function atualizar()
    {
        return (new Database('tb_usuario'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'genero' => $this->genero,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'nivel' => $this->nivel,
            'imagem' => $this->imagem,
            'morada' => $this->morada,
            'senha' => $this->senha,
            'criado' => $this->criado
        ]);
    }

    // faz um delete na tabela usuario
    public function apagar()
    {
        return (new Database('tb_usuario'))->delete('id = ' . $this->id, []);
    }

    // responsavel para alterar senha 
    public function atualizarSenha()
    {
        return (new Database('tb_usuario'))->update('id = ' . $this->id, [
            'senha' => $this->senha,
        ]);
    }

    // responsavel para alterar imagem do usuario
    public function atualizarImagem()
    {
        return (new Database('tb_usuario'))->update('id = ' . $this->id, [
            'imagem' => $this->imagem,
        ]);
    }

    /**
     * apresenta os resultado
     * @param string $where
     */
    public static function listarUsuario($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_usuario'))->select($where, $order, $limit, $fields);
    }

    /**
     * Busca  o user Admim por email
     * @param string $email
     * @return $email
     */
    public static function getUsuarioEmail($email)
    {
        return (new Database('tb_usuario'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Busca  o user Admim por id
     * @param string $id
     * @return $email
     */
    public static function getAdminUserId($id)
    {
        return (new Database('tb_usuario'))->select('id = ' . $id)->fetchObject(self::class);
    }

}
