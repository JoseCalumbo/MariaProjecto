<?php

namespace App\Http\Middleware;

use \App\Utils\Session;
use \App\Http\Response;
use \App\Http\Request;

class RequerLogout{

    /**
      * Função para executar o middlewares
      *@param Request $request
      *@param Clouse $nest
      *@return Response
    */
    public function handle($request, $next){

        if (Session::isLogged()) {
            $request->getRouter()->redirect('/');
        }

        return $next($request);
    }
}