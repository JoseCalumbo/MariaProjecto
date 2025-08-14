<?php

namespace App\Controller\Pages;

use App\Model\Entity\FuncionarioDao;
use \App\Utils\View;
use \App\Model\Entity\VendedorDao;
use \App\Model\Entity\FuncionarioDaoDao;
use App\Model\Entity\ZonaDao;

class Home extends Page
{
    // busca o total dos Usuario
    public static function getDadosVendedor()
    {
        //quantidade total de registros da tabela user
        $quantidadetotal = VendedorDao::listarVendedor(null, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }

    // busca o total dos Vendedor
    public static function getDadosUsuario()
    {
        //quantidade total de registros da tabela user
        $quantidadetotal = FuncionarioDao::listarFuncionario(null, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }

    // busca o total dos Vendedor
    public static function getzonas()
    {
        //quantidade total de registros da tabela user
        $quantidadetotal = ZonaDao::listarZona(null, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }

    // funcao para apresenatar os registos dos dados 
    private static function getBuscaVedendor($request)
    {
        $queryParam = $request->getQueryParams();

        $item = '';

        // filtra o input da busca
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);

        if ($queryParam['pesquisar'] ?? '') {

            $condicoes = [
                strlen($buscar) ? 'id LIKE "' . $buscar . '%"' : null,
            ];

            // coloca na consulta sql
            $where = implode(' AND ', $condicoes);

            //quantidade total de registros da tabela vendedor
            $quantidadetotal = VendedorDao::listarVendedor($where, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;

            $resultado = VendedorDao::listarVendedor($where);

            while ($obVendedor = $resultado->fetchObject(VendedorDao::class)) {

                $item .= View::render('pesquisar/resultado', [
                    'id' => $obVendedor->id,
                    'nome' => $obVendedor->nome,
                    'genero' => $obVendedor->genero,
                    'imagem' => $obVendedor->imagem,
                ]);
            }

            // Verifica se foi realizada uma pesquisa
            $queryParam = $request->getQueryParams();

            if ($queryParam['pesquisar'] ?? '') {

                return View::render('pesquisar/item', [
                    'pesquisa' => $buscar,
                    'resultados' => $item,
                    'numResultado' => $quantidadetotal,
                ]);
            }
        }
    }

    // tela home adim
    public static function getHome($request)
    {

        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('home/home', [
            'pesquisar' => $buscar,
            'BuscaVendedor' => self::getBuscaVedendor($request),
            //'totalUsuario' => self::getDadosUsuario(),
            // 'totalVendedor' => self::getDadosVendedor(),
            //'totalzona' => self::getzonas(),
        ]);

        // Retorna o metedo que renderiza a (Layouts) pagina 
        return parent::getPage('Auxiliar Médico', $content);
    }

    //tela home Medico
    public static function getHomeMedico($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('home/homeMedico', [
            'pesquisar' => $buscar,
            'BuscaVendedor' => self::getBuscaVedendor($request),
        ]);
        return parent::getHeaderMedico('Venda Ambulante', $content);
    }

    // tela balcao
    public static function getHomeBalcao($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::render('home/homeBalcao', [
            'pesquisar' => $buscar,
            'BuscaVendedor' => self::getBuscaVedendor($request),
        ]);
        return parent::getHeaderDados('Venda Ambulante', $content);
    }


}
