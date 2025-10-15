<?php

namespace App\Http\Middleware;

class Maintenence{

    /**
      * Função para executar o middlewares
      *@param Request $request
      *@param Clouse $nest
      *@return Response
    */
    public function handle($request, $next){
        
        if(getenv('MAINTENANCE') == 'true'){
            throw new \Exception("Pagina em manutenção. Estara Disponivel brevemente",200);
        }

        return $next($request);
    }
}