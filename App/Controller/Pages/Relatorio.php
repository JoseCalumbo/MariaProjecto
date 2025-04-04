<?php 

namespace App\Controller\Pages;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\VendedorDao;
use \App\Model\Entity\ZonaDao;
use \App\Utils\View;

Class Relatorio extends Page{

    // busca o total dos Usuario
    public static function getDadosVendedor(){
        //quantidade total de registros da tabela user
        $quantidadetotal = VendedorDao::listarVendedor(null,null,null,'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }

    // busca o total dos Vendedor
    public static function getDadosUsuario(){
        //quantidade total de registros da tabela user
        $quantidadetotal = UsuarioDao::listarUsuario(null,null,null,'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }

                    // busca o total dos Vendedor
                    public static function getzonas(){
                        //quantidade total de registros da tabela user
                        $quantidadetotal = ZonaDao::listarZona(null,null,null,'COUNT(*) as quantidade')->fetchObject()->quantidade;
                        return $quantidadetotal;
                    }

    // apresenta a tela de relatorio
    public static function telaRelatorio(){
         $content = View::render('relatorio/relatorio',[
             'totalUsuario'=>self::getDadosUsuario(),
             'totalVendedor'=>self::getDadosVendedor(),
             'totalzona'=>self::getzonas(),

        ]);
        return parent::getPage('Painel de Relatorio', $content);
    }

    // busca o filtro do vendedor
    public static function FiltroVendedor(){
        $item='';
        
        $filtro = filter_input(INPUT_GET, 'filtro',FILTER_SANITIZE_STRING);
       // $filtro = in_array($filtro,['Feminino','Masculino','Administrador']) ? $filtro : '';

        $condicoes = [
            strlen($filtro) ? 'genero_us = "'.$filtro.'"' : null,
           // strlen($filtro) ? 'nivel_us = "'.$filtro.'"' : null,
        ];
  
        $condicoes = array_filter($condicoes);

        $where = implode(' AND ',$condicoes);

        $quantidadetotal = UsuarioDao::listarUsuario($where);
        
        while($obUsuario = $quantidadetotal->fetchObject(UsuarioDao::class)){

            $item .= View::render('relatorio/dados/resultadoFiltro', [
                'id_us'=>$obUsuario->id_us,
                'imagem'=>$obUsuario->imagem_us,
                'nome'=>$obUsuario->nome_us,
                'genero'=>$obUsuario->genero_us,
                'telefone'=>$obUsuario->telefone_us,
                'nivel'=>$obUsuario->nivel_us
            ]);
        }

        return $item;
    }

    // apresenta a tela relatorio de dados
    public static function RelatorioDados($request){

        $queryParam = $request->getQueryParams();

        //Resultado da aplicção dos filtros 
        if ($queryParam['filtro'] ?? '') {

            $content = View::render('relatorio/dados/filtro',[ 

                //'generoFiltro'=> $obUsuario->genero_us =='Feminino' ? 'checked':'',
                //filtro vendedor
                'generoVendedror'=>self::FiltroVendedor(),
            ]);

            return parent::getPage('Relatorio de Dados', $content);
        }

        $content = View::render('relatorio/relatorioDados',[ ]);

        return parent::getPage('Relatorio de Dados', $content);
    }
    
    // relatorio de finaceiro
    public static function RelatorioFinaceiro($request){
         $content = View::render('relatorio/relatorioFinaceiro',[
        ]);
        return parent::getPage('Relatorio Finaceiro', $content);
    }
}