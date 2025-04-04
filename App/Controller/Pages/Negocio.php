<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\NegocioDao;
use \App\Controller\Mensagem\Mensagem;


Class Negocio extends Page {

    // Metodo para apresenatar os registos dos dados 
    private static function getNegocio($request,&$obPagination){
        
    $item = '';

    $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);

    $condicoes = [
        strlen($buscar) ? 'negocio LIKE "'.$buscar.'%"': null,
   ];
       
   // coloca na consulta sql
   $where = implode(' AND ',$condicoes);

    //quantidade total de registros da tabela user
    $quantidadetotal = NegocioDao::listarNegocio($where,null,null,'COUNT(*) as quantidade')->fetchObject()->quantidade;

    //pagina actual 
    $queryParams = $request->getQueryParams();
    $paginaAtual = $queryParams['page'] ?? 1;

    // instancia de paginacao
    $obPagination = new Pagination($quantidadetotal,$paginaAtual,10);

    $resultado = NegocioDao::listarNegocio($where,'negocio ',$obPagination->getLimit());
    
    while($negocio = $resultado->fetchObject(NegocioDao::class)){

        $item .= View::render('negocio/listarNegocio', [
            'id_negocio'=>$negocio->id_negocio,
            'negocio'=>$negocio->negocio,
            'data'=>$negocio->data_criacao,
        ]);
    }

    // Verifica se foi realizada uma pesquisa
    $queryParam = $request->getQueryParams();

    if($queryParam['pesquisar'] ?? '') {

        return View::render('pesquisar/box_resultado',[
            'pesquisa'=>$buscar,
            'item'=>$item,
            'numResultado'=>$quantidadetotal,
        ]);
    }
   return $item;
}

     public static function pagNegocio($request){

        $content = View::render('negocio/negocio',[
            'msg'=>'',
            'pesquisar'=>'',
            'item'=>self::getNegocio($request,$obPagination),
            'paginacao'=>parent::getPaginacao($request,$obPagination)
        ]);
        return parent::getPage('Negocio ', $content);
    }

    //cadastra novo tipo de negocio
    public static function cadastrar($request){

        if(isset($_POST['negocio'])){

            $obNegocio = new NegocioDao;

            $obNegocio->negocio = $_POST['negocio'];
            $obNegocio->cadastrarNegocio();

            $request->getRouter()->redirect('/negocio?msg=cadastrado');
            exit;
        }

        $content = View::render('negocio/formNegocio',[
            'titulo' => ' Cadastrar Novo Negócio',
            'pesquisar'=>'',
            'negocio'=>'',
            'button'=>'Cadstrar novo Negocio'
        ]);

        return parent::getPage('Cadastrar Novo Negócio ', $content);
    }

    //edita novo tipo de negocio
    public static function editarNegocio($request,$id_negocio){

        //Seleciona o negocio por id
        $obNegocio = NegocioDao::getNegocio($id_negocio);

        if(isset($_POST['negocio'])){

            $obNegocio->negocio = $_POST['negocio'] ?? $obNegocio->negocio;
            $obNegocio->atualizarNegocio();

            $request->getRouter()->redirect('/negocio?msg=editar');
            exit;
        }

        $content = View::render('negocio/formNegocio',[
            'titulo' => ' Editar Negócio',
            'pesquisar'=>'',
            'negocio'=>$obNegocio->negocio,
            'button'=>'Editar Negocio '
        ]);

        return parent::getPage('Editar Negócio id {{id_negocio}}', $content);
    }

    //apaga tipo de negocio
    public static function apagaNegocio($request,$id_negocio){

        $obNegocio = NegocioDao::getNegocio($id_negocio);

            $obNegocio->apagarNegocio();

            $request->getRouter()->redirect('/negocio?msg=apagado');
            exit;
    }
}


