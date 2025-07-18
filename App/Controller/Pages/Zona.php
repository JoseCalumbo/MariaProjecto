<?php 

namespace App\Controller\Pages;
use \App\Utils\Pagination;
use \App\Model\Entity\ZonaDao;
use \App\Model\Entity\VendedorDao;
use \App\Utils\View;


Class Zona extends Page{

    // funcão para fazer pesquisa 
    private static function getBusca($request,&$obPagination){

        $queryParam = $request->getQueryParams();

        //$obPagination = new Pagination(null,null,null);
            
         // Var que retorna o conteudo
         $item='';
         
         $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);
             
             $condicoes = [
                 strlen($buscar) ? 'zona LIKE "%'.$buscar.'%"': null,
            ];
                
            // coloca na consulta sql
            $where = implode(' AND ',$condicoes);
                
            //quantidade total de registros da tabela user
             $quantidadetotal = ZonaDao::listarZona($where,'zona',null,'COUNT(*) as quantidade')->fetchObject()->quantidade;

             //pagina actual 
              $queryParams = $request->getQueryParams();
              $paginaAtual = $queryParams['page'] ?? 1;

              // instancia de paginacao
              $obPagination = new Pagination($quantidadetotal,$paginaAtual,9);

             $resultado = ZonaDao::listarZona($where,'zona',$obPagination->getLimit());

             while($obZona = $resultado->fetchObject(ZonaDao::class)){

                $item .= View::render('zonas/listarzona',[
                    'id_zona'=>$obZona->id_zona,
                    'zona'=>$obZona->zona,
                    'iniciovenda'=>$obZona->inicio_venda,
                    'fimvenda'=>$obZona->fim_venda,
                    'mercado'=>$obZona->mercado
                ]);
            }

            $queryParam = $request->getQueryParams();

            if($queryParam['pesquisar'] ?? '') {
                    
                    return View::render('pesquisar/item',[
                        'pesquisa'=>$buscar,
                        'resultados'=>$item,
                        'numResultado'=>$quantidadetotal,
                    ]);
            }

        return $item;
    }

    // Metodo para apresentar a tela zona 
    public static function telaZona($request){

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);
        $content = View::render('zonas/zona',[
             'pesquisar'=>$buscar,
            // 'listarZona'=>self::getBusca($request,$obPagination),
            // 'paginacao'=>parent::getPaginacao($request,$obPagination)
        ]);
        return parent::getPage('Painel Zona', $content);
    }

    //metodo responsavel para pegar os paciente
        public static function getPaciente(){
            $paciente = '';
            $paciente = VendedorDao::listarVendedor();
            while( $obpaciente = $paciente->fetchObject(VendedorDao::class)){
                $paciente .= View::render('item/paciente', [
                    'nome'=>$obpaciente->nome,
                    'value'=>$obpaciente->id
                ]);
            }
            return $paciente;
        }

    // Metodo que cadastra consultas
    public static function cadastrarZona($request){

        $obZona = new ZonaDao;

        if (isset($_POST['zona'], $_POST['inicio'], $_POST['fim'], $_POST['mercado'])){
            
            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];
            $obZona->cadastrarZona();
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=cadastrado');
        }

        $content = View::render('zonas/formZona', [
            'titulo' => 'Registrar Nova Consultas',
            'button' => 'Salvar',
            'zona'=>'',
            'fim'=>'',
            'inicio'=>'',
            //'paciente'=>self::getPaciente(),
            'mercado'=>''

        ]);
        return parent::getPage('Cadastrar nova Zona', $content);
    }

    // Metodo que Edita Zona
    public static function editarZona($request,$id_zona){

        $obZona = ZonaDao::getZona($id_zona);

        if (isset($_POST['zona'], $_POST['inicio'], $_POST['fim'], $_POST['mercado'])){
                
            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];
            $obZona->AtualizarZona();
    
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=editado');
        }

        $content = View::render('consulta/formRemarcarConsulta', [
                'titulo' => 'Editar Zona',
                'button' => 'Editar',
                'zona'=> $obZona->zona,
                'fim'=> $obZona->fim_venda,
                'inicio'=> $obZona->inicio_venda,
                'mercado'=> $obZona->mercado
        ]);
         return parent::getPage('Atualizar Zona', $content);
    }

    // Metodo que apagar Zona
    public static function apagarZona ($request,$id_zona){

        $obZona = ZonaDao::getZona($id_zona);

        if (isset($_POST['apagar'])){

            $obZona->apagarZona();
            
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=apagado');
        }

        $content = View::render('zonas/deletaZona', [
                'titulo' => 'Apagar Zona',
                'button' => 'Sim',
                'zona'=> $obZona->zona,
                'id_zona'=> $obZona->id_zona,
                'mercado'=> $obZona->mercado
        ]);
         return parent::getPage('Apagar Zona', $content);
    }

}