<?php

namespace App\Utils;
use \App\Model\Entity\AdmimUserDao;
use \App\Model\Entity\UsuarioDao;

class Session
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
    public static function getUsuarioLogado()
    {
        self::init();
        return self::isLogged() ? $_SESSION['tb_usuario'] : null;
    }

    /**
     * Metodo para logar um usuario e os seus dados
     *@param AdmimUserDao 
     *@return boolean
     */
    public static function login($obAdminUser)
    {
        self::init();
        $_SESSION['tb_usuario'] = [
            'id' => $obAdminUser->id,
            'nome' => $obAdminUser->nome,
            'imagem' => $obAdminUser->imagem,
            'nivel' => $obAdminUser->nivel,
        ];

        return true;
    }

    /**Metodo para verificar se tem user logado na sessao */
    public static function isLogged()
    {
        // metodo que inicia a sessao do user
        self::init();
        //retorna a verificacao de usuario
        return isset($_SESSION['tb_usuario']['id']);
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
        unset($_SESSION['tb_usuario']);

        return true;
    }
}