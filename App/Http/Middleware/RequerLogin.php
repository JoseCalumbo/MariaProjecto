<?php

namespace App\Http\Middleware;

use \App\Utils\Session;

class RequerLogin{

    /**
      * Função para executar o middlewares
      *@param Request $request
      *@param Clouse $nest
      *@return Response
    */
    public function handle($request, $next){

        if (!Session::isLogged()) {
            $request->getRouter()->redirect('/login');
        }

        return $next($request);
    }
}