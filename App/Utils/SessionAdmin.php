<?php

namespace App\Utils;

class SessionAdmin
{

    /**Metodo para Iniciar uma Sessão
    /** void 
     */
    private static function init()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    //retorna os dados na session do usuario
    public static function getAdminUserLogado()
    {
        self::init();
        return self::isLogged() ? $_SESSION['usuario'] : null;
    }

    /**
     * Metodo para logar um usuario e os seus dados
     *@param 
     *@return boolean
     */
    public static function login($obFuncionario)
    {
        self::init();

        $_SESSION['usuario'] = [
            'id' => $obFuncionario->id,
            'nome' => $obFuncionario->nome,
            'imagem' => $obFuncionario->imagem,
            'nivel' => $obFuncionario->nivel,
        ];
        return true;
    }

    /**Metodo para verificar se tem user logado na sessao */
    public static function isLogged()
    {
        // metodo que inicia a sessao do user
        self::init();
        //retorna a verificacao de usuario
        return isset($_SESSION['usuario']['id']);
    }

    /**
     * Funcao para deslogar o usuario do sistema 
     * @return boolean
     */
    public static function logout()
    {
        // metodo que inicia a sessao do user
        self::init();

        //Desloga o user
        unset($_SESSION['usuario']);
        
        return true;
    }
}