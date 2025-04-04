<?php

namespace App\Utils;

class Session{

    /**
     * Metodo para iniciar uma sessao
     */
    private static function init(){
         if(session_status()!= PHP_SESSION_ACTIVE){
            session_start();
         }
    }

    //retorna os das na session do usuario
    public static function getUsuarioLogado(){
        self::init();
        return self::isLogged() ? $_SESSION['usuario']:null;
    }

     /**
      * Metodo para logar um usuario e os seus dados
      *@param User $obUsuario
      *@return boolean
      */
    public static function login($obUsuario){

        self::init();

        $_SESSION['usuario']=[
            'id_us'=>$obUsuario->id_us,
            'nome_us'=>$obUsuario->nome_us,
            'imagem_us' => $obUsuario->imagem_us,
            'nivel_us' => $obUsuario->nivel_us,
        ];

          return true;
    }


     /**Metodo para verificar se tem user logado na sessao */
    public static function isLogged(){

        // metodo que inicia a sessao do user
        self::init();

        //retorna a verificacao de usuario
        return isset($_SESSION['usuario']['id_us']);
    }

    /**
     * Funcao para deslogar o usuario do sistema 
     * @return boolean
     */
    public static function logout(){
        // metodo que inicia a sessao do user
        self::init();

        //Desloga o user
        unset($_SESSION['usuario']);
        
        return true;
    }
}