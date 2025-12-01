<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;

use \App\Model\Entity\ExameDao;

use \App\Controller\Mensagem\MensagemAdmin;


class Atestado extends Page
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
                return MensagemAdmin::msgSucesso('Farmacia Cadastrado com sucesso');
                break;
            case 'alterado':
                return MensagemAdmin::msgSucesso('Farmacia Alterado com sucesso');
                break;
            case 'apagado':
                return MensagemAdmin::msgSucesso('Farmacia Apagado com sucesso');
                break;

        } // fim do switch
    }

    // Método para apresenatar os registos do exames cadastrados
    private static function getMedicamentos($request, &$obPagination)
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

        $resultado = ExameDao::listarExame($where, 'nome_exame ', $obPagination->getLimit());

        while ($obExames = $resultado->fetchObject(ExameDao::class)) {

            $item .= View::render('configuracao/exame/listarExamess', [
                'id_exame' => $obExames->id_exame,
                'nome' => $obExames->nome_exame,
                'tipo' => $obExames->tipo_exame,
                'valor' => $obExames->valor_exame,
                'descrisao' => $obExames->descrisao_exame,
                'dataRegistro' => date('d-m-Y', strtotime($obExames->criado_exame)),
                'estadoExame' => $obExames->estado_exame,
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
                                                    Nenhuma prescrição gerada pelo sistema.
                                                    </td>
                                                </tr>';
    }


    // Método que apresenta a tela do Funcionario
    public static function telaAtestado($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('atestado/atestado', [
            'pesquisar' => $buscar,
            'msg' => self::exibeMensagem($request),
            'item' => self::getMedicamentos($request, $obPagination),
            'paginacao' => parent::getPaginacao($request, $obPagination)
        ]);
        return parent::getPage('Farmácia', $content);
    }
}
