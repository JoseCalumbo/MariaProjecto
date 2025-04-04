<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\TaxaDao;
use \App\Controller\Mensagem\Mensagem;


class Tesouraria extends Page{

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

    // Metodo para buscar as Taxa cadastrada
    private static function getTaxa(){
        
        $item = '';

        $resultado = TaxaDao::listarTaxa(null);
        
        while($obTaxa = $resultado->fetchObject(TaxaDao::class)){

            $item .= View::render('tesouraria/resultado', [
                'id_taxa'=>$obTaxa->id_taxa,
                'taxa'=>$obTaxa->taxa,
                'valor'=>$obTaxa->valor,
            ]);
        }
       return $item;
    }

    // Metodo que apresenta a tela de Tesouraria
    public static function TelaTaxa($request){

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);
        
        $content = View::render('tesouraria/tesouraria', [
            'resultado'=>self::getTaxa(),
            'msg'=>self::exibeMensagem($request),
        ]);
   
        return parent::getPage('Painel Usuario',$content);
    }

    // Metodo que cadastra usuario 
    public static function cadastrarUser($request){
        $obUsuario = new UsuarioDao;   
        
        if (isset($_POST['nome'],$_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['email'], $_POST['telefone'], $_POST['acesso'], $_FILES['imagem'])) {

        

            if ($_FILES['imagem']['error'] == 4) {
            
                $obUsuario->nome_us = $_POST['nome'];
                $obUsuario->genero_us = $_POST['genero'];
                $obUsuario->nascimento_us = $_POST['data'];
                $obUsuario->bilhete_us = $_POST['bilhete'];
                $obUsuario->email_us = $_POST['email'];
                $obUsuario->telefone_us = $_POST['telefone'];
                $obUsuario->nivel_us = $_POST['acesso'];
                $obUsuario->senha_us = password_hash($_POST['bilhete'],PASSWORD_DEFAULT);
                $obUsuario->imagem_us = 'anonimo.png';
                $obUsuario->cadastrar();
            
                $request->getRouter()->redirect('/usuario?msg=cadastrado');
                exit;
            }

            
            $obUsuario->nome_us = $_POST['nome'];
            $obUsuario->genero_us = $_POST['genero'];
            $obUsuario->nascimento_us = $_POST['data'];
            $obUsuario->bilhete_us = $_POST['bilhete'];
            $obUsuario->email_us = $_POST['email'];
            $obUsuario->telefone_us = $_POST['telefone'];

            $obUsuario->cadastrar();
        }

        $content = View::render('usuario/formUser', [
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
        ]);

        return parent::getPage('Cadastrar Usuario', $content);
    }

    // metodo para ir na pagina editar os precos
    public static function editarTaxa($request,$id_taxa){

        $obTaxa = TaxaDao::getTaxaId($id_taxa);

        $tipotaxa = $obTaxa->taxa;
        
        $content = View::render('tesouraria/formTaxa', [
            'titulo' => 'Editar o  Valor <strong>'.$tipotaxa.'</strong>',
            'button' => 'Actualizar',
            'msg'=>'',
            'taxa'=>$obTaxa->taxa,
            'valor'=>$obTaxa->valor,
        ]);
        return parent::getPage('Editar Valor', $content);
    }

    // Metodo para editar usuario
    public static function setAtualizarUser($request,$id_us){

        $obUsuario = UsuarioDao::getUsuarioId($id_us);
    
        $postVars = $request->getPostVars();
    
        if (isset($_POST['nome'], $_POST['genero'], $_POST['data'], $_POST['bilhete'], $_POST['email'], $_POST['telefone'], $_POST['acesso'], $_FILES['imagem'])) {
            
        
    
            if ($_FILES['imagem']['error'] == 4) {
    
                $obUsuario->nome_us = $postVars['nome'] ?? $obUsuario->nome_us;
                $obUsuario->genero_us = $postVars['genero'] ?? $obUsuario->genero_us ;
                $obUsuario->nascimento_us = $postVars['data']?? $obUsuario->nascimento_us;
                $obUsuario->bilhete_us = $postVars['bilhete'] ?? $obUsuario->bilhete_us;
                $obUsuario->email_us = $postVars['email'] ?? $obUsuario->email_us;
                $obUsuario->telefone_us = $postVars['telefone'] ?? $obUsuario->telefone_us;
                $obUsuario->nivel_us = $postVars['acesso'] ?? $obUsuario->nivel_us;
                $obUsuario->imagem_us = 'anonimo.png' ?? $obUsuario->imagem_us;
                $obUsuario->atualizar();   
                
                $request->getRouter()->redirect('/usuario?msg=alterado');

            }  
            
        $content = View::render('usuario/formUser', []);

        return parent::getPage('Cadastrar Usuario', $content);
    }

    // Metodo para ir na pagina de apagar usuario 


}


    // Metodo que apresenta a tela de Tesouraria
    public static function TelaCaixa($request){
        
        $content = View::render('tesouraria/caixa', [
            'resultado'=>self::getTaxa(),
            'msg'=>self::exibeMensagem($request),
        ]);
   
        return parent::getPage('Painel Usuario',$content);
    }
}



