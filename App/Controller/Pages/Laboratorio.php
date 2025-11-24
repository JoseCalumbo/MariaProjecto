<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;

use \App\Model\Entity\ExameDao;

use \App\Model\Entity\FuncionarioDao;
use \App\Model\Entity\FuncionarioNivelDao;
use \App\Model\Entity\NivelDao;
use \App\Controller\Mensagem\MensagemAdmin;
use App\Model\Entity\ExameSolicitadoDao;

class Laboratorio extends Page
{

    /* Metodo para exibir  as mensagens
     *@param Request 
     *@ return string
     */
    public static function exibeMensagem($request)
    {
        $queryParam = $request->getQueryParams();

        if (!isset($queryParam['msg']))
            return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return MensagemAdmin::msgSucesso('Exame Cadastrado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Exame Alterado com sucesso');
                break;
            case 'alteradonivel':
                return MensagemAdmin::msgSucesso('Exame Alterado com sucesso');
                break;
            case 'seleciona':
                return MensagemAdmin::msgAlerta('Ação não realizada');
                break;
            case 'apagado':
                return MensagemAdmin::msgSucesso('Exame Apagado com sucesso');
                break;
            case 'confirma':
                return MensagemAdmin::msgAlerta('Clica em Confirmar antes de apagar');
                break;
        } // fim do switch
    }

    // Método para apresenatar os registos do exames cadastrados
    private static function getExameSolicitado($request, &$obPagination)
    {
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_exame LIKE "' . $buscar . '%"' : null,
        ];

        // coloca na consulta sql
        $where = implode(' AND ', $condicoes);

        //quantidade total de registros da tabela exames
        $quantidadetotal = ExameDao::listarExame($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 8);

        $resultado = ExameSolicitadoDao::listarExameSolicitado($where, 'emergencia_exame', $obPagination->getLimit());

        while ($obExameSolicitado = $resultado->fetchObject(ExameSolicitadoDao::class)) {

            $item .= View::render('laboratorio/listarExameSolicitado', [
                'id_exameSolicitado' => $obExameSolicitado->id_exame_solicitado,
                'nome_paciente' => $obExameSolicitado->id_exame,
                'exame' => $obExameSolicitado->tipo_exame,
                'emergencia' => $obExameSolicitado->emergencia_exame,
                'parametro' => $obExameSolicitado->parametro_exame,
                'data' => date('d-m-Y', strtotime($obExameSolicitado->criado_exameSolicitado)),
    
            ]);
        }

        // Verifica se foi realizada uma pesquisa
        $queryParam = $request->getQueryParams();

        if ($queryParam['pesquisar'] ?? '') {

            return View::render('pesquisar/box_resultado', [
                'pesquisa' => $buscar,
                'item' => $item,
                'numResultado' => $quantidadetotal,
            ]);
        }
        //Nenhum Exame encontado
        return $item = strlen($item) ? $item : '<tr class="no-hover no-border" style="height: 60px;">
                                                   <td colspan="7" class="center-align no-border" style="vertical-align: middle; height:120px; font-size:18px">
                                                   Não há solicitações de exames registadas no sistema.
                                                    </td>
                                                </tr>';
    }

    // Método que apresenta a tela do laboratorio
    public static function telaLaboratorio($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('laboratorio/laboratorio', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'listarExameSolicitado' => self::getExameSolicitado($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)

        ]);
        return parent::getPage('Tela Laboratorio', $content);
    }



}
