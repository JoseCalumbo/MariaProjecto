<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;
use \App\Model\Entity\VendedorDao;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\AddNegocioDao;
use App\Model\Entity\NegocioDao;
use App\Model\Entity\ZonaDao;

Class Vendedor1 extends Page {

    // exibe a messagem de operacao
    public static function exibeMensagem($request){

        $queryParam = $request->getQueryParams();
        
        if(!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Vendedor Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Vendedor Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Vendedor Apagdo com sucesso');
                break;
        }// fim do switch
    }

    //lista os usuario e paginacao
    private static function getVendedor($request,&$obPagination){

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome LIKE "'.$buscar.'%"': null,
       ];
           
       // coloca na consulta sql
       $where = implode(' AND ',$condicoes);

        //quantidade total de registros da tabela vendedor
        $quantidadetotal = VendedorDao::listarVendedor($where,null,null,'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal,$paginaAtual,5);

        $resultado = VendedorDao::listarVendedor($where,'nome',$obPagination->getLimit());
        
       while($obVendedor = $resultado->fetchObject(VendedorDao::class)){

            $item .= View::render('vendedor/listarvendedor', [
                'id'=>$obVendedor->id,
                'imagem'=>$obVendedor->imagem,
                'nome'=>$obVendedor->nome,
                'genero'=>$obVendedor->genero,
                'telefone'=>$obVendedor->telefone1,
            ]);
      }

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

    //tela de vendedor
    public static function telaVendedor($request){

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);

         $content = View::render('vendedor/vendedor',[
            'pesquisar'=>$buscar,
            'msg'=>self::exibeMensagem($request),
            'item'=>self::getVendedor($request,$obPagination),
            'paginacao'=>parent::getPaginacao($request,$obPagination)
        ]);
        return parent::getPage('Painel vendedor ambulante', $content);
    }

    // busca todos os Zona cadastrado
    public static function getZonas(){

        $resultadoZona ='';

        $zonas = ZonaDao::listarZona( null,'zona');

        while($obZona = $zonas->fetchObject(ZonaDao::class)){

            $resultadoZona.= View::render('vendedor/item/item_zona', [
            'value'=>$obZona->id_zona,
            'zona'=>$obZona->zona,
            //'checado'=>$obNegocio->nome,
            ]);
        }
       return $resultadoZona;
    }
    
    // busca todos os negocios cadastrado
    public static function getNegocio(){

        $resultadoNeg ='';

        $negocios = NegocioDao::listarNegocio( null,'negocio');

        while($obNegocio = $negocios->fetchObject(NegocioDao::class)){

            $resultadoNeg .= View::render('vendedor/item/item_negocios', [
            'value'=>$obNegocio->id_negocio,
            'negocio'=>$obNegocio->negocio,
            //'checado'=>$obNegocio->nome,
            ]);
        }
       return $resultadoNeg;
    }

    // funcao que cadastra um novo registros na tabela vendedor
    public static function cadastrarVendedor($request){
    
            $obVendedor = new VendedorDao;
            
            $postVars = $request->getPostVars();

            if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['telefone1'], $_POST['telefone2'], $_POST['email'],$_POST['morada'],$_POST['nivel'], $_FILES['imagem'])) {
    
                $obUpload = new Upload($_FILES['imagem']) ?? '';
    
                if ($_FILES['imagem']['error'] == 4) {
                
                    $obVendedor->nome = $postVars['nome'];
                    $obVendedor->genero = $postVars['genero'];
                    $obVendedor->nascimento = $postVars['data'];
                    $obVendedor->pai = $postVars['pai'];
                    $obVendedor->mae = $postVars['mae'];
                    $obVendedor->bilhete = $postVars['bilhete'];
                    $obVendedor->telefone1 = $postVars['telefone1'];
                    $obVendedor->telefone2 = $postVars['telefone2'];
                    $obVendedor->email = $postVars['email'];
                    $obVendedor->morada = $postVars['morada'];
                    $obVendedor->id_zona = $postVars['zona'];
                    $obVendedor->nivelAcademico = $postVars['nivel'];
                    $obVendedor->imagem = 'anonimo.png';
                    $obVendedor->cadastrar();

                    $request->getRouter()->redirect('/vendedor?msg=cadastrado');
                    exit;
                }
    
                $sucess = $obUpload->upload(LOCAL_URL.'/Files/Imagem/vendedor',false);
                
                    $obVendedor->nome = $postVars['nome'];
                    $obVendedor->genero = $postVars['genero'];
                    $obVendedor->nascimento = $postVars['data'];
                    $obVendedor->pai = $postVars['pai'];
                    $obVendedor->mae = $postVars['mae'];
                    $obVendedor->bilhete = $postVars['bilhete'];
                    $obVendedor->telefone1 = $postVars['telefone1'];
                    $obVendedor->telefone2 = $postVars['telefone2'];
                    $obVendedor->email = $postVars['email'];
                    $obVendedor->morada = $postVars['morada'];
                    $obVendedor->id_zona = $postVars['zona'];
                    $obVendedor->nivelacademico = $postVars['nivel'];
                    $obVendedor->imagem = $obUpload->getBaseName();
                    $obVendedor->cadastrar();
    
                if ($sucess) {
                    $request->getRouter()->redirect('/vendedor?msg=cadastrado');
                    exit;
                } else {
                    echo 'Ficheiro nao Enviado';
                }
            }
    
            $content = View::render('vendedor/formVendedor1', [
                'titulo' => 'Cadastrar Novo Vendedor',
                'button' => 'Cadastrar',
                'msg'=>'',
                'nome'=>'',
                'genero'=>'',
                'data'=>'',
                'bilhete'=>'',
                'telefone1'=>'',
                'telefone2'=>'',
                'email'=>'',
                'pai'=>'',
                'mae'=>'',
                'morada'=>'',
                'zonas'=>self::getZonas(),
                'negocios'=>self::getNegocio(),
                'imagem'=>'anonimo.png'
            ]);
    
            return parent::getPage('Cadastrar Vendedor', $content);
    }

    // funcao que actualizar um novo registros na tabela vendedor
    public static function atualizarVendedor($request,$id){
    
        $obVendedor = VendedorDao::getVendedorId($id);
        $postVars = $request->getPostVars();

        if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['telefone1'], $_POST['telefone2'], $_POST['email'],$_POST['morada'],$_POST['nivel'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';
    
            if ($_FILES['imagem']['error'] == 4) {
                
                    $obVendedor->nome = $postVars['nome'] ?? $obVendedor->nome;
                    $obVendedor->genero = $postVars['genero'] ?? $obVendedor->genero;
                    $obVendedor->nascimento = $postVars['data'] ?? $obVendedor->nascimento;
                    $obVendedor->pai = $postVars['pai'] ?? $obVendedor->pai;
                    $obVendedor->mae = $postVars['mae'] ?? $obVendedor->mae;
                    $obVendedor->bilhete = $postVars['bilhete'] ?? $obVendedor->bilhete;
                    $obVendedor->telefone1 = $postVars['telefone1'] ?? $obVendedor->telefone1;
                    $obVendedor->telefone2 = $postVars['telefone2'] ?? $obVendedor->telefone2;
                    $obVendedor->email = $postVars['email'] ?? $obVendedor->email;
                    $obVendedor->morada = $postVars['morada'] ?? $obVendedor->morada;
                    $obVendedor->id_zona = $postVars['zona'] ?? $obVendedor->id_zona;
                    $obVendedor->nivelAcademico = $postVars['nivel'] ?? $obVendedor->nivelacademico;
                    $obVendedor->imagem = 'anonimo.png' ?? $obVendedor->imagem;
                    $obVendedor->atualizar();

                    $request->getRouter()->redirect('/vendedor?msg=alterado'.$obVendedor->nome.'');
                    exit;
            } // fim do if da verificacao da imagem
    
            $sucess = $obUpload->upload(LOCAL_URL.'/Files/Imagem/vendedor',false);
                
            $obVendedor->nome = $postVars['nome'] ?? $obVendedor->nome;
            $obVendedor->genero = $postVars['genero'] ?? $obVendedor->genero;
            $obVendedor->nascimento = $postVars['data'] ?? $obVendedor->nascimento;
            $obVendedor->pai = $postVars['pai'] ?? $obVendedor->pai;
            $obVendedor->mae = $postVars['mae'] ?? $obVendedor->mae;
            $obVendedor->bilhete = $postVars['bilhete'] ?? $obVendedor->bilhete;
            $obVendedor->telefone1 = $postVars['telefone1'] ?? $obVendedor->telefone1;
            $obVendedor->telefone2 = $postVars['telefone2'] ?? $obVendedor->telefone2;
            $obVendedor->email = $postVars['email'] ?? $obVendedor->email;
            $obVendedor->morada = $postVars['morada']?? $obVendedor->morada;
            $obVendedor->id_zona = $postVars['zona'] ?? $obVendedor->id_zona;
            $obVendedor->nivelAcademico = $postVars['nivel'] ?? $obVendedor->nivelacademico;
            $obVendedor->imagem = $obUpload->getBaseName() ?? $obVendedor->imagem;;
            $obVendedor->atualizar();
    
            if ($sucess) {
                    $request->getRouter()->redirect('/vendedor?msg=alterado'.$obVendedor->nome.'');
                    exit;
            } else {
                    echo 'Ficheiro nao Enviado';
                }
            }

            $content = View::render('vendedor/formVendedor1', [
                'titulo' => 'Editar Vendedor',
                'button' => 'Actualizar',
                'msg'=>'',
                'nome'=>$obVendedor->nome,
                'genero'=>$obVendedor->genero == 'Feminino' ? 'checked':'',
                'data'=>$obVendedor->nascimento,
                'pai'=>$obVendedor->pai,
                'mae'=>$obVendedor->mae,
                'bilhete'=>$obVendedor->bilhete,
                'telefone1'=>$obVendedor->telefone1,
                'telefone2'=>$obVendedor->telefone2,
                'email'=>$obVendedor->email,
                'morada'=>$obVendedor->morada,
                'base-nivel'=>$obVendedor->nivelAcademico == 'base' ? 'selected' : '',
                'medio'=>$obVendedor->nivelAcademico == 'medio' ? 'selected' : '',
                'licenciado'=>$obVendedor->nivelAcademico == 'licenciado' ? 'selected' : '',
                'imagem'=>$obVendedor->imagem,
                'zonas'=>self::getZonas(),
                'negocios'=>self::getNegocio(),
            ]);
    
            return parent::getPage('Editar Vendedor', $content);
    }

    // metodo para apagar um vendedor
    public static function apagarVendedor($request,$id){

        $obAddNegocio = new AddNegocioDao();
        
        $obVendedor = VendedorDao::getVendedorId($id);
        
        // validacao do click do botao apagar
        if(isset($_POST['apagar'])){

            $obAddNegocio-> deleteAddNegocio($id);

            $obVendedor->apagar();

            $request->getRouter()->redirect('/vendedor?msg=apagado');
            exit;
        }

        $content = View::render('vendedor/apagarVendedor',[
            'titulo' => ' Apagar o Vendedor',
            'id'=>$obVendedor->id,
            'nome'=>$obVendedor->nome,
            'Criado'=>$obVendedor->create_vs,
            'imagem'=>$obVendedor->imagem,
        ]);

        return parent::getPage('Apagar Vendedor', $content);
    }
}