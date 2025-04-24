<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Utils\Upload;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\PostoDao;
use \App\Controller\Mensagem\Mensagem;
use \App\Controller\Pages\Posto;



class Usuario extends Page{

    /**
      * Metodo para exibir  a mensagem 
      *@param Request $request
      *@return string
    */
    public static function exibeMensagem($request){

        $queryParam = $request->getQueryParams();
        
        if(!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Usuario Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Usuario Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Usuario Apagdo com sucesso');
                break;
        }// fim do switch
    }

    // metodo para obter os postos
    public static function getPosto(){
        
        $posto = '';
        $postos = PostoDao::listarPosto();
        while( $obposto = $postos->fetchObject(PostoDao::class)){
            $posto .= View::render('item/posto', [
                'posto'=>$obposto->nome_posto,
                'value'=>$obposto->id_posto
            ]);
        }
        return $posto;
    }

    // Metodo para apresenatar os registos dos dados 
    private static function getUsuario($request,&$obPagination){
        
        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome_us LIKE "'.$buscar.'%"': null,
       ];
           
       // coloca na consulta sql
       $where = implode(' AND ',$condicoes);

        //quantidade total de registros da tabela user
        $quantidadetotal = UsuarioDao::listarUsuario($where,null,null,'COUNT(*) as quantidade')->fetchObject()->quantidade;

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal,$paginaAtual,10);

        $resultado = UsuarioDao::listarUsuario($where,'nome_us ',$obPagination->getLimit());
        
        while($obUsuario = $resultado->fetchObject(UsuarioDao::class)){

            $item .= View::render('funcionario/listaruser', [
                'id_us'=>$obUsuario->id_us,
                'imagem'=>$obUsuario->imagem_us,
                'nome'=>$obUsuario->nome_us,
                'genero'=>$obUsuario->genero_us,
                'telefone'=>$obUsuario->telefone_us,
                'nivel'=>$obUsuario->nivel_us
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

    // Metodo que apresenta a tela de usuario
    public static function TelaUsuario($request){

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);
        
        $content = View::render('funcionario/funcionario', [
            'pesquisar'=>$buscar,
            'msg'=>self::exibeMensagem($request),
            'item'=>self::getUsuario($request,$obPagination),
            'paginacao'=>parent::getPaginacao($request,$obPagination)
        ]);
   
        return parent::getPage('Painel funcionario',$content);
    }

    // Metodo que cadastra usuario 
    public static function cadastrarUser($request){
        
        $obUsuario = new UsuarioDao;

        // Obtem os postos cadastrados 
        $obPosto = new Posto;
        
        if (isset($_POST['nome'],$_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['email'], $_POST['telefone'], $_POST['acesso'], $_FILES['imagem'])) {

            $obUpload = new Upload($_FILES['imagem']) ?? '';

            if ($_FILES['imagem']['error'] == 4) {
            
                $obUsuario->nome_us = $_POST['nome'];
                $obUsuario->genero_us = $_POST['genero'];
                $obUsuario->nascimento_us = $_POST['data'];
                $obUsuario->bilhete_us = $_POST['bilhete'];
                $obUsuario->email_us = $_POST['email'];
                $obUsuario->telefone_us = $_POST['telefone'];
                $obUsuario->nivel_us = $_POST['acesso'];
                $obUsuario->posto_us = $_POST['posto'];
                $obUsuario->senha_us = password_hash($_POST['bilhete'],PASSWORD_DEFAULT);
                $obUsuario->imagem_us = 'anonimo.png';
                $obUsuario->cadastrar();
            
                $request->getRouter()->redirect('/usuario?msg=cadastrado');
                exit;
            }

            $sucess = $obUpload->upload(LOCAL_URL.'/Files/Imagem/user',false);
            
            $obUsuario->nome_us = $_POST['nome'];
            $obUsuario->genero_us = $_POST['genero'];
            $obUsuario->nascimento_us = $_POST['data'];
            $obUsuario->bilhete_us = $_POST['bilhete'];
            $obUsuario->email_us = $_POST['email'];
            $obUsuario->telefone_us = $_POST['telefone'];
            $obUsuario->nivel_us = $_POST['acesso'];
            $obUsuario->posto_us = $_POST['posto'];
            $obUsuario->senha_us = password_hash($_POST['bilhete'],PASSWORD_DEFAULT);
            $obUsuario->imagem_us = $obUpload->getBaseName();
            $obUsuario->cadastrar();

            if ($sucess) {
                $request->getRouter()->redirect('/usuario?msg=cadastrado');
                exit;
            } else {
                echo 'Ficheiro nao Enviado';
            }
        }

        $content = View::render('funcionario/', [
            'titulo' => 'Cadastrar Novo Usuario',
            'button' => 'Cadastrar',
            'msg'=>'',
            'nome_us'=>'',
            'sobrenome_us'=>'',
            'femenino'=>'',
            'data'=>'',
            'bilhete'=>'',
            'email'=>'',
            'telefone'=>'',
            'nivel'=>'',
            'imagem'=>'anonimo.png',
            'itemPosto'=>self::getPosto(),
           'pot'=>''

        ]);

        return parent::getPage('Cadastrar Usuario', $content);
    }

    // metodo para ir na pagina editar usuario
    public static function getAtualizarUser($request,$id_us){

        $obUsuario = UsuarioDao::getUsuarioId($id_us);
        
        $content = View::render('funcionario/copy', [
            'titulo' => ' Actualizar dados de  Usuario',
            'button' => 'Actulizar',
            'msg'=>'',
            'nome_us'=>$obUsuario->nome_us,
            'genero'=>$obUsuario->genero_us == 'Feminino' ? 'checked':'',
            'data'=>$obUsuario->nascimento_us,
            'bilhete'=>$obUsuario->bilhete_us,
            'email'=>$obUsuario->email_us,
            'telefone'=>$obUsuario->telefone_us,
            'nivel-adim'=>$obUsuario->nivel_us == 'Administrador' ? 'selected' : '',
            'nivel-normal'=>$obUsuario->nivel_us == 'Normal' ? 'selected' : '',
            'nivel-visit'=>$obUsuario->nivel_us == 'Visitante' ? 'selected' : '',
            'itemPosto'=>self::getPosto(),
            'imagem'=>$obUsuario->imagem_us,
            'pot'=>$obUsuario->posto_us,
        ]);
        
        return parent::getPage('Funcionario Usuario', $content);
    }

    // Metodo para editar usuario
    public static function setAtualizarUser($request,$id_us){

        $obUsuario = UsuarioDao::getUsuarioId($id_us);
    
        $postVars = $request->getPostVars();
    
        if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['email'], $_POST['telefone'], $_POST['acesso'], $_FILES['imagem'])) {
            
            $obUpload = new Upload($_FILES['imagem']) ?? '';
    
            if ($_FILES['imagem']['error'] == 4) {
    
                $obUsuario->nome_us = $postVars['nome'] ?? $obUsuario->nome_us;
                $obUsuario->genero_us = $postVars['genero'] ?? $obUsuario->genero_us ;
                $obUsuario->nascimento_us = $postVars['data']?? $obUsuario->nascimento_us;
                $obUsuario->bilhete_us = $postVars['bilhete'] ?? $obUsuario->bilhete_us;
                $obUsuario->email_us = $postVars['email'] ?? $obUsuario->email_us;
                $obUsuario->telefone_us = $postVars['telefone'] ?? $obUsuario->telefone_us;
                $obUsuario->nivel_us = $postVars['acesso'] ?? $obUsuario->nivel_us;
                $obUsuario->imagem_us =  $obUsuario->imagem_us != null? $obUsuario->imagem_us :'anonimo.png';
                $obUsuario->posto_us = $_POST['posto'] ?? $obUsuario->posto_us;
                $obUsuario->atualizar();   
                
                $request->getRouter()->redirect('/funcionario?msg=alterado');

            }  

            $sucess = $obUpload->upload(LOCAL_URL.'/Files/Imagem/user',false);

            $obUsuario->nome_us = $postVars['nome'] ?? $obUsuario->nome_us;
            $obUsuario->sobrenome_us = $postVars['sobrenome'] ?? $obUsuario->sobrenome_us;
            $obUsuario->genero_us = $postVars['genero'] ?? $obUsuario->genero_us ;
            $obUsuario->nascimento_us = $postVars['data']?? $obUsuario->nascimento_us;
            $obUsuario->bilhete_us = $postVars['bilhete'] ?? $obUsuario->bilhete_us;
            $obUsuario->email_us = $postVars['email'] ?? $obUsuario->email_us;
            $obUsuario->telefone_us = $postVars['telefone'] ?? $obUsuario->telefone_us;
            $obUsuario->nivel_us = $postVars['acesso'] ?? $obUsuario->nivel_us;
            $obUsuario->posto_us = $_POST['posto'] ?? $obUsuario->posto_us;
            $obUsuario->imagem_us = $obUpload->getBaseName() ?? $obUsuario->imagem_us;
            $obUsuario->atualizar(); 
            
            if ($sucess) {

                $request->getRouter()->redirect('/funcionario?msg=alterado');
            } else {
                echo 'Ficheiro nao Enviado';
            }    
        }
            
        $content = View::render('funcionario/formUser', []);

        return parent::getPage('Cadastrar Usuario', $content);
    }

    // Metodo para ir na pagina de apagar usuario 
    public static function apagarUser($request,$id_us){

        $obUsuario = UsuarioDao::getUsuarioId($id_us);

        $content = View::render('funcionario/apagarUser', [
            'titulo' => ' Apagar o Usuario',
            'id'=>$obUsuario->id_us,
            'imagem'=>$obUsuario->imagem_us,
            'nome'=>$obUsuario->nome_us,
            'Criado'=>$obUsuario->create_us,   
        ]);
        return parent::getPage('Apagar Usuario {{id}}', $content);
    }

    // Metodo para apagar usuario
    public static function setapagarUser($request,$id_us){
        
        $obUsuario = UsuarioDao::getUsuarioId($id_us);
        $obUsuario->apagar();
        $request->getRouter()->redirect('/funcionario?msg=apagado');
    }

}



