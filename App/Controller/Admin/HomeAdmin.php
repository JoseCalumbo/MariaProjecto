<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\VendedorDao;
use \App\Model\Entity\UsuarioDao;
use App\Model\Entity\ZonaDao;

class HomeAdmin extends PageAdmin
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
       // $quantidadetotal = UsuarioDao::listarUsuario(null, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;
       // return $quantidadetotal;
    }

    // busca o total dos Vendedor
    public static function getzonas()
    {
        //quantidade total de registros da tabela user
        $quantidadetotal = ZonaDao::listarZona(null, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }

    // M+etodos para buscar os registos dos dados 
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
    public static function getHomeAdmin($request)
    {
        $buscar = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_STRING);
        $content = View::renderAdmin('home/homeAdmin', [
            'pesquisar' => $buscar,
            'BuscaVendedor' => self::getBuscaVedendor($request),
            //'totalUsuario' => self::getDadosUsuario(),
            //'totalVendedor' => self::getDadosVendedor(),
            //'totalzona' => self::getzonas(),
        ]);
        // Retorna o metedo que renderiza a (Layouts) pagina 
        return parent::getPageAdmin('Auxiliar Médico - Admin', $content);
    }

}
