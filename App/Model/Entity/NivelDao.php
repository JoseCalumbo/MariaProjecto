<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \PDO;

class NivelDao
{
    // dados do paciente pessoal
    public $id_paciente;
    public $nome_paciente;
    public $pai_paciente;
    public $mae_paciente;
    public $genero_paciente;
    public $nascimento_paciente;
    public $nacionalidade_paciente;
    public $bilhete_paciente;

    public $telefone1_paciente;
    public $telefone2_paciente;
    public $email_paciente;
    public $morada_paciente;

    public $motivo_paciente;
    public $estado_paciente;
    public $responsavelNome_paciente;
    public $responsavelTelefone_paciente;

    public $imagem_paciente;
    public $documentos_paciente;

    public $create_paciente;

    // campos chaves estrageiras 
    public $id_funcionario; // salva o funcionario 

    // metodo para inserir um novo vendedor na tabela
    public function cadastrarPaciente()
    {
        $usuarioLogado = Session::getUsuarioLogado();
        // Pega a data actual do cadastro
        $this->create_paciente = date('y-m-d H:i:s');
        //Pega o id do usuario logado
        $this->id_funcionario = $usuarioLogado['id'];

        // o estado actual do vendedor
        $this->estado_paciente = 'Em atendimento';

        $obDatabase = new Database('tb_paciente');

        $this->id_paciente = $obDatabase->insert([
            'id_paciente' => $this->id_paciente,
            'nome_paciente' => $this->nome_paciente,
            'bilhete_paciente' => $this->bilhete_paciente,
            'genero_paciente' => $this->genero_paciente,
            'nacionalidade_paciente' => $this->nacionalidade_paciente,
            'nascimento_paciente' => $this->nascimento_paciente,
            'pai_paciente' => $this->pai_paciente,
            'mae_paciente' => $this->mae_paciente,
            'responsavel_paciente' => $this->responsavelNome_paciente,
            'telefoneResponsavel_paciente' => $this->responsavelTelefone_paciente,
            'motivo_paciente' => $this->morada_paciente,
            'email_paciente' => $this->email_paciente,
            'telefone1_paciente' => $this->telefone1_paciente,
            'telefone2_paciente' => $this->telefone2_paciente,
            'morada_paciente' => $this->morada_paciente,
            'imagem_paciente' => $this->imagem_paciente,
            'documentos_paciente' => $this->documentos_paciente,
            'estado_paciente' => $this->estado_paciente,
            'id_funcionario' => $this->id_funcionario,
            'create_paciente' => $this->create_paciente,
        ]);

        return $this->id_paciente;
    }

    // Metodo para cadastrar Paciente 
    public function registrarTriagemPaciente($nomepaciente, $generoPacinete, $nascimentoPacinete, $bilhetePaciente)
    {
        // Obtem os dados do formularios de triagem 
        $this->nome_paciente = $nomepaciente;
        $this->genero_paciente = $generoPacinete;
        $this->nascimento_paciente = $nascimentoPacinete;
        $this->bilhete_paciente = $bilhetePaciente;

        $usuarioLogado = Session::getUsuarioLogado();
        // Pega a data actual do cadastro
        $this->create_paciente = date('y-m-d H:i:s');
        //Pega o id do usuario logado
        $this->id_funcionario = $usuarioLogado['id'];
        // o estado actual do vendedor
        $this->estado_paciente = 'activo';

        $obDatabase = new Database('tb_paciente');

        $this->id_paciente = $obDatabase->insert([
            'id_paciente' => $this->id_paciente,
            'nome_paciente' => $this->nome_paciente,
            'genero_paciente' => $this->genero_paciente,
            'bilhete_paciente' => $this->bilhete_paciente,
            'nascimento_paciente' => $this->nascimento_paciente,
            'estado_paciente' => $this->estado_paciente = "Aberto",
            'id_funcionario' => $this->id_funcionario,
            'imagem_paciente' => $this->imagem_paciente = "anonimo.png",
            'create_paciente' => $this->create_paciente,
        ]);

        return $this->id_paciente;
    }

    //atulizar campo de vendedor
    public function atualizar()
    {
        return (new Database('tb_paciente'))->update('id_paciente = ' . $this->id_paciente, [
            'id_paciente' => $this->id_paciente,
            'nome_paciente' => $this->nome_paciente,
            'bilhete_paciente' => $this->bilhete_paciente,
            'genero_paciente' => $this->genero_paciente,
            'nacionalidade_paciente' => $this->nacionalidade_paciente,
            'nascimento_paciente' => $this->nascimento_paciente,
            'pai_paciente' => $this->pai_paciente,
            'mae_paciente' => $this->mae_paciente,
            'responsavel_paciente' => $this->responsavelNome_paciente,
            'telefoneResponsavel_paciente' => $this->responsavelTelefone_paciente,
            'motivo_paciente' => $this->motivo_paciente,
            'email_paciente' => $this->email_paciente,
            'telefone1_paciente' => $this->telefone1_paciente,
            'telefone2_paciente' => $this->telefone2_paciente,
            'morada_paciente' => $this->morada_paciente,
            'imagem_paciente' => $this->imagem_paciente,
            'documentos_paciente' => $this->documentos_paciente,
            'estado_paciente' => $this->estado_paciente,
            'id_funcionario' => $this->id_funcionario,
            'create_paciente' => $this->create_paciente,
        ]);
    }

    // metodo para deletar um vendedor na tabela
    public function apagar()
    {
        return (new Database('vendedor'))->delete('id =' . $this->id_paciente, []);
    }

    /**
     * Lista todos os nivel cadastrado
     * @param string $where
     */
    public static function listarNivel($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('tb_funcionario f
            INNER JOIN tb_funcionario_nivel fn ON f.id_funcionario = fn.id_usuario
            INNER JOIN tb_nivel_permissoes np ON fn.id_nivel = np.id_nivel
            INNER JOIN tb_permissoes p ON np.id_permissoes = p.id_permissao
    '))->select($where, $order, $limit, $fields);
    }

    // Método para pegar o id dos nivel
    public static function getNiveld($id_paciente)
    {
        return (new Database('tb_paciente'))->select('id_paciente = ' . $id_paciente)->fetchObject(self::class);
    }

    // Método para pegar o id nivel 
    public static function VerificarNivel($id_funcionario)
    {
        return (new Database('tb_funcionario f
                INNER JOIN tb_funcionario_nivel fn ON f.id_funcionario = fn.id_usuario
                INNER JOIN tb_nivel_permissoes np ON fn.id_nivel = np.id_nivel
                INNER JOIN tb_permissoes p ON np.id_permissoes = p.id_permissao')
        )->select('id_funcionario = ' . $id_funcionario)->fetchObject(self::class);
    }

    // Método para pegar o id nivel 
    public static function VerificarNivel1($id_funcionario)
    {
        return (new Database('tb_funcionario f
                INNER JOIN tb_funcionario_nivel fn ON f.id_funcionario = fn.id_usuario
                INNER JOIN tb_nivel_permissoes np ON fn.id_nivel = np.id_nivel
                INNER JOIN tb_permissoes p ON np.id_permissoes = p.id_permissao')
        )->select('id_funcionario = ' . $id_funcionario)->fetchAll();
    }

    // Método para pegar o id nivel 
    public static function VerificarNivel2($id_funcionario)
    {
        return (new Database('usuario u
    INNER JOIN usuario_nivel un ON u.id_usuario = un.id_usuario
    INNER JOIN nivel_permissao np ON un.id_nivel = np.id_nivel
    INNER JOIN permissao p ON np.id_permissao = p.id_permissao')
        )->select('id_funcionario = ' . $id_funcionario)->fetch(MYSQLI_BOTH);
    }
}
