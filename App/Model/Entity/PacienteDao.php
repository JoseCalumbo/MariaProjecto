<?php

namespace App\Model\Entity;

use \App\Model\Database;
use \App\Utils\Session;
use \App\Model\Entity\AddNegocioDao;
use \App\Model\Entity\NegocioDao;
use \PDO;
class PacienteDao
{
    public $id_paciente;
    public $nome_paciente;
    public $genero_paciente;
    public $nascimento_paciente;
    public $pai_paciente;
    public $mae_paciente;
    public $bilhete_paciente;
    public $email_paciente;
    public $telefone1_paciente;
    public $telefone2_paciente;
    public $morada_paciente;
    public $imagem_paciente;
    public $estado_paciente;
    public $create_paciente;

    // campos chaves estrageiras 
    public $id_funcionario;
    public $id_consulta;
    public $id_triagem;

    // metodo para inserir um novo vendedor na tabela
    public function cadastrar()
    {

        $usuarioLogado = Session::getUsuarioLogado();
        // Pega a data actual do cadastro
        $this->create_vs = date('y-m-d H:i:s');
        //Pega o id do usuario logado
        $this->id_us = $usuarioLogado['id_us'];
        // o estado actual do vendedor
        $this->estado = 'activo';

        $obDatabase = new Database('vendedor');

        $this->id = $obDatabase->insert([
            'id' => $this->id_paciente,
            'nome' => $this->nome_paciente,
            'genero' => $this->genero_paciente,
            'nascimento' => $this->nascimento_paciente,
            'pai' => $this->pai_paciente,
            'mae' => $this->mae_paciente,
            'bilhete' => $this->bilhete_paciente,
            'email' => $this->email_paciente,
            'telefone1' => $this->telefone1_paciente,
            'telefone2' => $this->telefone2_paciente,
            'morada' => $this->morada_paciente,
            'imagem' => $this->imagem_paciente,
            'estado' => $this->estado_paciente,
            'id_us' => $this->id_us,
            'id_zona' => $this->id_zona,
            'create_vs' => $this->create_paciente,
        ]);

        // metodo que adiciona um negocio ao vendedor
        $this->adicionarNegocio();
        $this->adicionarConta();

        return true;
    }

    // adicionar Negocios ao vendedor
    public function adicionarNegocio()
    {

        // Obtem o id do vendedor 
        $this->id;

        // Obtem a data 
        $this->criado = date('y-m-d H:i:s');

        // lista os negocios cadastrados
        $neg = NegocioDao::listarNegocio();

        // Add negocio na tabela negocio e vendedor selecionado
        while ($obNeg = $neg->fetchObject(NegocioDao::class)) {

            // verifica keys existente no array
            $valor = in_array($obNeg->id_negocio, array_keys($_POST));

            if ($valor) {
                // instancia database negocio vendedor
                $obDatabase = new Database('negocio_vendedor');
                $this->id_addNegocio = $obDatabase->insert([
                    'id_vendedor' => $this->id,
                    'id_negocio' => $this->id_negocio = $obNeg->id_negocio,
                    'criado' => $this->criado,
                ]);
            }
        }

        return true;
    }

    // adicionar Negocios ao vendedor
    public function adicionarConta()
    {

        // Obtem o id do vendedor 
        $this->id;

        // Obtem a data 
        $this->data_conta1 = date('y-m-d H:i:s');

        // obtem o mes actual
        $mesActual = MensalidadeDao::getMesActual('s')->fetchObject();

        // instancia database conta vendedor
        $obDatabase = new Database('conta');
        //    $this->id_conta = $obDatabase->insert([
        //      'id_vendedor' => $this->id,
        //    'status_conta' => $this->status_conta = 'não pago',
        //  'id_mensal' => $this->id_mensal=$mesActual->id_mensal,
        // 'data_conta' => $this->data_conta1,
        // ]);

        return true;
    }

    // adicionar Negocios ao vendedor
    public function editarNegocio()
    {

        // Obtem o id do vendedor 
        $this->id;

        // Obtem a data 
        $this->criado = date('y-m-d H:i:s');


        echo '<pre>';
        print_r($_POST);
        //    echo '</pre>';
        //    exit;
        //    exit;

        // lista os negocios cadastrados
        $neg = NegocioDao::listarNegocio();

        // obtem o id da tabela relacao entre vend e neg
        $Relacao = AddNegocioDao::listarNegocioVendedor();

        // Add negocio na tabela negocio e vendedor selecionado
        while ($obRelacao = $Relacao->fetchObject(AddNegocioDao::class)) {

            echo '<pre>';
            print_r($obRelacao->id_vend_neg);
            echo '</pre>';

            // obtem o id da tabela relacao entre vend e neg
            $idRelacao = AddNegocioDao::getIDaddNegocio($this->id_addNegocio = $obRelacao->id_vend_neg);

            echo '<pre>';
            print_r($idRelacao);
            echo '</pre>';


            // Add negocio na tabela negocio e vendedor selecionado
            while ($obNeg = $neg->fetchObject(NegocioDao::class)) {

                // verifica keys existente no array
                $valor = in_array($obNeg->id_negocio, array_keys($_POST));

                if ($valor and $obRelacao->id_negocio != $obNeg->id_negocio) {

                    // // instancia database negocio vendedor
                    // return (new Database('negocio_vendedor'))->update('id_vend_neg = '. $obRelacao->id_vend_neg,[
                    //     'id_vendedor' => $this->id,
                    //     'id_negocio' => $this->id_negocio=$obNeg->id_negocio,
                    //     'criado' => $this->criado, 
                    // ]);


                    $obDatabase = new Database('negocio_vendedor');
                    $this->id_addNegocio = $obDatabase->insert([
                        'id_vendedor' => $this->id_paciente,
                        'id_negocio' => $this->id_negocio = $obNeg->id_negocio,
                        'criado' => $this->criado,
                    ]);
                }
            }
        }

        exit;
    }

    //atulizar campo de vendedor
    public function atualizar()
    {

        $this->editarNegocio();

        return (new Database('vendedor'))->update('id = ' . $this->id, [
            'id' => $this->id_paciente,
            'nome' => $this->nome_paciente,
            'genero' => $this->genero_paciente,
            'nascimento' => $this->nascimento_paciente,
            'pai' => $this->pai_paciente,
            'mae' => $this->mae_paciente,
            'bilhete' => $this->bilhete_paciente,
            'email' => $this->email_paciente,
            'telefone1' => $this->telefone1_paciente,
            'telefone2' => $this->telefone2,
            'morada' => $this->morada_paciente,
            'nivelAcademico' => $this->nivelAcademico,
            'imagem' => $this->imagem_paciente,
            'id_zona' => $this->id_zona,
            'create_vs' => $this->create_vs,
        ]);
    }

    // metodo para deletar um vendedor na tabela
    public function apagar()
    {
        return (new Database('vendedor'))->delete('id =' . $this->id_paciente, []);
    }

    /**
     * lista todos os dados do vendedor
     * @param string $where
     */
    public static function listarVendedor($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('vendedor'))->select($where, $order, $limit, $fields);
    }

    /**
     * lista todos os dados do vendedor
     * @param string $where
     */
    public static function listarVendedorZona($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('vendedor JOIN zona ON 
        vendedor.id_zona = zona.id_zona
        '))->select($where, $order, $limit, $fields);
    }

    // metodo para pegar o id do vendedor
    public static function getVendedorId($id)
    {
        return (new Database('vendedor'))->select('id = ' . $id)->fetchObject(self::class);
    }

    /**
     * Listar a quantidade total de negocio
     * @param string $where
     */
    public static function quantidadeNeogio($where = null, $order = null, $limit = null, $fields = 'COUNT(*) as quantidade')
    {
        return (new Database('negocio'))->select($where, $order, $limit, $fields)->fetchObject()->quantidade;
        ;
    }

    // * Apresenta dados dos Vendedor negocios
    // * @param string $where
    // *
    public static function negocioVendedor($id)
    {
        return (new Database('negocio_vendedor JOIN negocio ON 
        negocio.id_negocio = negocio_vendedor.id_negocio 
        '))->select('id_vendedor = ' . $id)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    // * Apresenta dados zonas vendedor
    // * @param string $where
    // *
    public static function negocioZona($id)
    {
        return (new Database('vendedor JOIN zona ON 
        vendedor.id_zona = zona.id_zona 
        '))->select('id = ' . $id)->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
