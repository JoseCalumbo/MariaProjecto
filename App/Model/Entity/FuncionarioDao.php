<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \PDO;

class FuncionarioDao
{

    public $id_funcionario;
    public $nome_funcionario;
    public $nascimento_funcionario;
    public $genero_funcionario;
    public $morada_funcionario;
    public $bilhete_funcionario;
    public $numeroordem_funcionario;
    public $email_funcionario;
    public $telefone1_funcionario;
    public $telefone2_funcionario;
    public $cargo_funcionario;
    public $imagem_funcionario;
    public $senha_funcionario;
    public $registrado;

    // metodo para inserir um novo funcionario na tabela
    public function cadastrarFuncionario()
    {
        // $usuarioLogado = Session::getUsuarioLogado();
        // Pega a data actual do cadastro
        $this->registrado = date('y-m-d H:i:s');
        //Pega o id do usuario logado
        //$this->id_us = $usuarioLogado['id_us'];

        $obDatabase = new Database('tb_funcionario');

        $this->id = $obDatabase->insert([
            'id_funcionario' => $this->id_funcionario,
            'nome_funcionario' => $this->nome_funcionario,
            'genero_funcionario' => $this->genero_funcionario,
            'nascimento_funcionario' => $this->nascimento_funcionario,
            'morada_funcionario' => $this->morada_funcionario,
            'bilhete_funcionario' => $this->bilhete_funcionario,
            'numeroordem_funcionario' => $this->numeroordem_funcionario,
            'email_funcionario' => $this->email_funcionario,
            'telefone1_funcionario' => $this->telefone1_funcionario,
            'telefone2_funcionario' => $this->telefone2_funcionario,
            'cargo_funcionario' => $this->cargo_funcionario,
            'imagem_funcionario' => $this->imagem_funcionario,
            'senha_funcionario' => $this->senha_funcionario,
            'registrado' => $this->registrado,
        ]);

        return true;
    }

    /**
     * lista todos os dados os funcionario
     * @param string $where
     */
    public static function listarFuncionario($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_funcionario'))->select($where, $order, $limit, $fields);
    }

    //atulizar os dados do Funcionario
    public function atualizarFuncionario()
    {
        return (new Database('tb_funcionario'))->update('id_funcionario = ' . $this->id_funcionario, [
            'id_funcionario' => $this->id_funcionario,
            'nome_funcionario' => $this->nome_funcionario,
            'genero_funcionario' => $this->genero_funcionario,
            'morada_funcionario' => $this->morada_funcionario,
            'nascimento_funcionario' => $this->nascimento_funcionario,
            'bilhete_funcionario' => $this->bilhete_funcionario,
            'numeroordem_funcionario' => $this->numeroordem_funcionario,
            'email_funcionario' => $this->email_funcionario,
            'telefone1_funcionario' => $this->telefone1_funcionario,
            'telefone2_funcionario' => $this->telefone2_funcionario,
            'cargo_funcionario' => $this->cargo_funcionario,
            'imagem_funcionario' => $this->imagem_funcionario,
            'senha_funcionario' => $this->senha_funcionario,
            'registrado' => $this->registrado,
        ]);
    }

    // metodo para deletar um funcionario na tabela
    public function apagarFuncionario()
    {
        return (new Database('tb_funcionario'))->delete('id_funcionario =' . $this->id_funcionario);
    }

    // metodo para buscar(selecionar) o Funcionario por ID
    public static function getFuncionarioId($id_funcionario)
    {
        return (new Database('tb_funcionario'))->select('id_funcionario = ' . $id_funcionario)->fetchObject(self::class);
    }

    /** metodo para buscar(selecionar) o Funcionario por Email
     * @param string $email_us
     */
    public static function getFuncionarioEmail($email_funcionario)
    {
        return (new Database('tb_funcionario'))->select('email_funcionario = "' . $email_funcionario . '"')->fetchObject(self::class);

    }

    // responsavel para alterar imagem do usuario
    public function actualizarImage()
    {
        return (new Database('tb_funcionario'))->update('id_funcionario = ' . $this->id_funcionario, [
            'imagem_funcionario' => $this->imagem_funcionario,
        ]);
    }

    // responsavel para alterar senha do funcionario
    public function atualizarSenha()
    {
        return (new Database('tb_funcionario'))->update('id_funcionario = ' . $this->id_funcionario, [
            'senha_funcionario' => $this->senha_funcionario,
        ]);
    }
}


// public id_funcionario;	
// public nome_funcionario;
// public nascimento_funcionario;	
// public genero_funcionario;	
// public bilhete_funcionario;	
// public numeroordem_funcionario;	
// public email_funcionario;	
// public telefone1_funcionario;	
// public telefone2_funcionario;	
// public cargo_funcionario;	
// public imagem_funcionario;	
// public senha_funcionario;	
// public registrado;