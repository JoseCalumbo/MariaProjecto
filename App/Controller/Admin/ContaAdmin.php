<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\AdmimUserDao;
use \App\Utils\Session;
use \App\Http\Request;
use \App\Controller\Mensagem\Mensagem;
use \App\Utils\Upload;

Class ContaAdmin extends Page{

    /**
      * Metodo para exibir  a mensagem 
      *@param Request $request
      *@return string
    */
    public static function exibeMensagem($request){

        $queryParam = $request->getQueryParams();
        
        if(!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'senhaEditada':
                return Mensagem::msgSucesso('Senha Alterado com sucesso');
                break;
            case 'imagemAlterado':
                return Mensagem::msgSucesso('Imagem Alterado com sucesso');
                break;
            case 'contaeditada':
                return Mensagem::msgSucesso('Conta editada com sucesso');
                break;
        }// fim do switch
    }

    // funcao para apresenatar os dados do user dados 
    private static function getUsuarioConta(){
            $item = '';
            $usuarioLogado = Session::getUsuarioLogado();
            $id=$usuarioLogado['id'];
    
            $obUsuario = AdmimUserDao::getUsuarioId($id);
    
            $item .= View::render('conta/dadosConta', [
                'id'=>$obUsuario->id_us,
                'nome'=>$obUsuario->nome_us,
                'genero'=>$obUsuario->genero_us,
                'nascimento'=>$obUsuario->nascimento_us,
                'bilhete'=>$obUsuario->bilhete_us,
                'email'=>$obUsuario->email_us,
                'telefone'=>$obUsuario->telefone_us,
                'nivel'=>$obUsuario->nivel_us,
                'registro'=>$obUsuario->create_us
            ]);
            return $item;
    }

    // funcao para apresenatar os dados do menu user dados 
    private static function getUsuarioMenu(){
            $item = '';

            $usuarioLogado = Session::getUsuarioLogado();
            $id=$usuarioLogado['id_us'];

            $obUsuario = UsuarioDao::getUsuarioId($id);
    
            $item .= View::render('conta/menuConta', [
                'id'=>$obUsuario->id_us,
                'nome'=>$obUsuario->nome_us,
                'imagem'=>$obUsuario->imagem_us,
            ]);
            return $item;
    }

    // metodo que renderiza a tela  do usuario 
    public static function telaConta($request){

        $usuarioLogado = Session::getUsuarioLogado();
        $id=$usuarioLogado['id_us'];

        $obUsuario = UsuarioDao::getUsuarioId($id);

         $content = View::render('conta/conta',[
            'dadosconta'=>self::getUsuarioConta(),
            'menuconta'=>self::getUsuarioMenu(),
            'imagem'=>$obUsuario->imagem_us,
            'msg'=>self::exibeMensagem($request),
            'msgVazio'=>''
        ]);
        return parent::getPage('Painel Usuario', $content);
    }

    /**
      * Metodo para editar os dados 
      *@param Request $request
      *@return string
    */
    public  static function editarConta($request,$id_us){

        $usuarioLogado = Session::getUsuarioLogado();
        $id=$usuarioLogado['id_us'];

        $obUsuario = UsuarioDao::getUsuarioId($id);
        
        $content = View::render('conta/registrosConta',[
            'msg'=>'',
            'menuconta'=>self::getUsuarioMenu(),
            'msgVazio'=>'',
            'imagem'=>$obUsuario->imagem_us,
        ]);
        return parent::getPage('Editar conta', $content);
             
    }

    // metodo que renderiza a tela alter senha
    public static function telaAlterarSenha($request ,$erroMsg){

        // pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $id=$usuarioLogado['id_us'];

        $obUsuario = UsuarioDao::getUsuarioId($id);
        $postVars = $request->getPostVars();

        // post do form da alteracao 
        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';

        $status = !is_null($erroMsg) ? Mensagem::mensagemErro($erroMsg) : '';

         $content = View::render('conta/alterarsenha',[
            'menuconta'=>self::getUsuarioMenu(),
            'senhaAntiga'=>$senhaAntiga,
            'senhaNova'=>$senhaNova,
            'senhaConf'=>$senhaConfirmada,
            'msg' => $status,
            'msgVazio'=>'',
            'imagem'=>$obUsuario->imagem_us,
        ]);
        return parent::getPage('Usuario Alterar senha', $content);
    }

    //metodo post para alterar senha
    public static function setAlterarSenha($request,$id_us){

        // obtem o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $id_us=$usuarioLogado['id_us'];

    
        $postVars = $request->getPostVars();

        $senhaAntiga = $postVars['senhaAntiga'] ?? '';
        $senhaNova = $postVars['senhaNova'] ?? '';
        $senhaConfirmada = $postVars['senhaConfirmada'] ?? '';
        
        $obUsuario = UsuarioDao::getUsuarioId($id_us);

        // validacao da senha se corresponde
        if (!password_verify($senhaAntiga, $obUsuario->senha_us)) {
            return self::telaAlterarSenha($request, '<p class="black-text"> Erro! Senha Incorreta </p>');
            exit;
        }

        // validacao da confirmacao da senha
        if ($senhaNova !== $senhaConfirmada) {
            return self::telaAlterarSenha($request, '<p> Erro! As senhas não são iguais</p>');
            exit;
        }

        // valida os campos das senhas 
        if (isset($postVars['senhaAntiga'],$postVars['senhaNova'],$postVars['senhaConfirmada'])){

            //faz a alteracao da senha
            $obUsuario->senha_us = password_hash($postVars['senhaNova'],PASSWORD_DEFAULT);
            $obUsuario->atualizarSenha(); 
        }
        
        $request->getRouter()->redirect('/conta?msg=senhaEditada');
   }

   // metodo para alterar a imagem do usuario
   public static function alterarImagem($request){

        $postVars = $request->getPostVars();

        // obtem o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $id_us=$usuarioLogado['id_us'];

        // instancia do user
        $obUsuario = UsuarioDao::getUsuarioId($id_us);

        // instancia da class que carrega a imagem
        $obUpload = new Upload($_FILES['imagem']) ?? '';

        if (isset($postVars['salvar'])){
            
            // verifica se foi carregado uma imagem 
            if ($_FILES['imagem']['error'] == 4) {
                $content = View::render('conta/conta',[
                    'msg'=>'',
                    //exibe os dados do user na pagina
                    'dadosconta'=>self::getUsuarioConta(),
                    // exibe o menu do user na pagina
                    'menuconta'=>self::getUsuarioMenu(),
                    // coloca a class para manter o modal de alter a foto
                    'blocks'=>'block',
                    'imagem'=>$obUsuario->imagem_us,
                    //exibe a mensagem de nao carregar uma foto
                    'msgVazio' => '<p class="div-conta-inf red center">Não selecionaste nenhuma imagem nova</p>',
                ]);
                return parent::getPage('Usuario Alterar senha', $content);
            }

            $sucess = $obUpload->upload(LOCAL_URL.'/Files/Imagem/user',false);
            
            $obUsuario->imagem_us = $obUpload->getBaseName();
            $obUsuario->atualizarImagem(); 
            
            if ($sucess) {
                $request->getRouter()->redirect('/conta?msg=imagemAlterado');
                exit;
            }
        }
   }

}