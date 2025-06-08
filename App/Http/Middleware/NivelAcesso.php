<?php

namespace App\Http\Middleware;

use \App\Utils\Session;
use \App\Http\Request;
use \App\Http\Response;

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
        $FuncionarioLogado = Session::getUsuarioLogado();

        $nivel = $FuncionarioLogado['nivel'];

        // verifica o nivel de acesso do usuario logado  
      //  if ($nivel == 'administrador'){
        if ($nivel == 'Normal'){
            $request->getRouter()->redirect('/acesso/negado');
        }

        return $next($request);
    }
}
