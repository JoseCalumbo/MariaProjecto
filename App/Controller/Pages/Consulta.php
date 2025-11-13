<?php

namespace App\Controller\Pages;

use App\Model\Entity\PacienteDao;
use App\Model\Entity\TriagemDao;
use \App\Utils\Pagination;
use \App\Model\Entity\VendedorDao;
use \App\Utils\View;


class Consulta extends Page
{

    // Metodo que apresenta os pacientes aspera da consulta
    private static function getConsultasEspera($request, &$obPagination)
    {
        $queryParam = $request->getQueryParams();
        $obPagination = new Pagination(null, null, null);

        // Var que retorna o conteudo
        $item = '';
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $condicoes = [
            strlen($buscar) ? 'nome_paciente LIKE "%' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = TriagemDao::listarTriagemFeita($where, 'risco_triagem', null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 6);

        $resultado = TriagemDao::listarTriagemFeita($where, 'risco_triagem', $obPagination->getLimit());

        while ($obPacientesEspera = $resultado->fetchObject(TriagemDao::class)) {

            $atender =  $obPacientesEspera->risco_triagem;
            $triagemAtender = "";
            switch ($atender) {
                case 'a':
                    $triagemAtender = "Vermelho";
                    break;
                case 'b':
                    $triagemAtender = "Laranja";
                    break;
                case 'c':
                    $triagemAtender = "Amarelo";
                    break;
                case 'd':
                    $triagemAtender = "Verde";
                    break;
                case 'e':
                    $triagemAtender = "Azul";
                    break;
            } // fim do switch

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($obPacientesEspera->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::render('consulta/listarConsulta', [
                'id_triagem' => $obPacientesEspera->id_triagem,
                'id_paciente' => $obPacientesEspera->id_paciente,
                'imagem' => $obPacientesEspera->imagem_paciente,
                'nome_paciente' => $obPacientesEspera->nome_paciente,
                'genero' => $obPacientesEspera->genero_paciente,
                'idade' => $idade,
                'perioridade' => $triagemAtender,
            ]);
        }

        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::render('pesquisar/item', [
                'pesquisa' => $buscar,
                'resultados' => $item,
                'numResultado' => $quantidadetotal,
            ]);
        }

        return $item = strlen($item) ? $item : '<tr class="no-hover no-border" style="height: 60px;">
                                                   <td colspan="7" class="center-align no-border font-normal" style="vertical-align: middle; height:120px; font-size:18px">
                                                    Sem registos de pacientes em espera.
                                                    </td>
                                                </tr>';
    }

    // Metodo para apresentar a tela do consultorio
    public static function telaConsulta($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('consulta/Consultorio', [
            'pesquisar' => $buscar,
            'listarConsulta' => self::getConsultasEspera($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Consultorio', $content);
    }

    // Metodo que inicia as consultas
    public static function getcadastrarConsulta($request, $id_paciente)
    {
        //$obConsultorio = new ConsultorioDao;

        // Seleciona o paciente pelo id
        $obPaciente = PacienteDao::getPacienteId($id_paciente);
        $pacienteID = $obPaciente->id_paciente;

        if (isset($_POST['salvar'])) {

            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            exit;

            // $obZona->zona = $_POST['zona'];

            // Redireciona validaçao e gerar consulta
            $request->getRouter()->redirect('/consulta/validar?msg=cadastrado');
        }

        $content = View::render('consulta/formConsulta2', [
            'titulo' => 'Ficha de Consulta',
            'button' => 'Salvar',

            'id_paciente' => $pacienteID,
            'nome' => $obPaciente->nome_paciente,
            'morada' => $obPaciente->morada_paciente,
            'telefone1' => $obPaciente->telefone1_paciente,
            'email' => $obPaciente->email_paciente,
            'data' => $obPaciente->nascimento_paciente,
            'genero' => $obPaciente->genero_paciente == 'Feminino' ? 'checked' : '',


            'diagnostico' => '',
            'obs' => '',
            'motivo' => '',

        ]);
        return parent::getPage('Ficha - consulta', $content);
    }

    // Metodo para apresentar a tela Consulta 
    public static function comfirmarConsulta($request)
    {

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('consulta/formConfirmaConsulta', [
            'pesquisar' => $buscar,
            'listarZona' => self::getConsultasEspera($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Painel Consulta', $content);
    }


    //metodo responsavel para pegar os paciente
    public static function getPaciente()
    {
        $paciente = '';
        $paciente = VendedorDao::listarVendedor();
        while ($obpaciente = $paciente->fetchObject(VendedorDao::class)) {
            $paciente .= View::render('item/paciente', [
                'nome' => $obpaciente->nome,
                'value' => $obpaciente->id
            ]);
        }
        return $paciente;
    }







    // Metodo que marca a consulta
    public static function getMarcarConsulta($request, $id_paciente)
    {
        $content = View::render('consulta/formMarcarConsulta', [
            'titulo' => 'Marcação de consulta',
            'button' => 'Salvar',
            'dia' => '',
            'hora' => '',
            'obs' => '',
            'valor' => '',
            'tempo' => '',
        ]);
        return parent::getPage('Marcação de consulta', $content);
    }

    // Metodo que marca a consulta
    public static function setMarcarConsulta($request, $id_paciente)
    {
        //$obConsultorio = new ConsultorioDao;

        if (isset($_POST['salvar'])) {

            // $obZona->zona = $_POST['zona'];

            // Redireciona validaçao e gerar consulta
            $request->getRouter()->redirect('/consulta/validar?msg=cadastrado');
        }

        $content = View::render('consulta/formConsulta2', [
            'titulo' => 'Ficha de Consulta',
            'nome' => '',
            'button' => 'Salvar',
            'diagnostico' => '',
            'obs' => '',
            'motivo' => '',

        ]);
        return parent::getPage('Ficha - consulta', $content);
    }
}
