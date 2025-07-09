<?php

namespace App\Http\Middleware;

use \App\Utils\SessionAdmin;
use \App\Http\Response;
use \App\Http\Request;

class RequerLoginAdmin{

    /**
      * Função para executar o middlewares
      *@param Request $request
      *@param Clouse $nest
      *@return Response
    */
    public function handle($request, $next){

        if (!SessionAdmin::isLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }

        return $next($request);
    }
}