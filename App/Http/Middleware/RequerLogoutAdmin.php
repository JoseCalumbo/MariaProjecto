<?php

namespace App\Http\Middleware;

use \App\Utils\Session;
use \App\Utils\SessionAdmin;
use \App\Http\Response;
use \App\Http\Request;


class RequerLogoutAdmin{

    /**
      * Função para executar o middlewares
      *@param Request $request
      *@param Clouse $nest
      *@return Response
    */
    public function handle($request, $next){

        if (SessionAdmin::isLogged()) {
            $request->getRouter()->redirect('/admin');
        }

        return $next($request);
    }
}