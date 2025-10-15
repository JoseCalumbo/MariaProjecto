<?php

namespace App\Http\Middleware;

use \App\Utils\Session;
use \App\Utils\SessionAdmin;
use \App\Http\Request;
use \App\Http\Response;

class NivelAcessoAdmin
{

    /**
     * Função para executar o middlewares
     *@param Request $request
     *@param Clouse $nest
     *@return Response
     */

    public function handle($request, $next)
    {

        // buscar funcionario por sessão
        $AdminUser = SessionAdmin::getAdminUserLogado();

        $nivel = $AdminUser['nivel'];

        // verifica o nivel de acesso do usuario logado  
        //  if ($nivel == 'administrador'){
        if ($nivel == 'Normal') {
            $request->getRouter()->redirect('/acesso/negado');
        }

        return $next($request);
    }
}
