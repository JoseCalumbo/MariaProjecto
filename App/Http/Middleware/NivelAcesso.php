<?php

namespace App\Http\Middleware;

use \App\Utils\Session;

class NivelAcesso
{

    /**
     * Função para executar o middlewares
     *@param Request $request
     *@param Clouse $nest
     *@return Response
     */
    
    public function handle($request, $next){

        // busca se 
        $usuarioLogado = Session::getUsuarioLogado();

        $nivel = $usuarioLogado['nivel_us'];

        // verifica o nivel de acesso do usuario logafo  
        if ($nivel == 'Normal') {
            $request->getRouter()->redirect('/acesso/negado');
        }

        return $next($request);
    }
}
