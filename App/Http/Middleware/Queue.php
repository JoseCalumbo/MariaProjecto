<?php

namespace App\Http\Middleware;

class Queue{

    //mapeamento de middlewares
    private static $map = [];

    //mapeamento de middlewares que estara em todas as rotas
    private static $default = [];

    // fila de middleware
    private $middlewares = [];

    // var que executa o controlador
    private $controller;

    // var de argumento de controller
    private $controllerArgs = [];

    /**
     * Funcao para construir a class de fila de middleware
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs){
        $this->middlewares = array_merge(self::$default,$middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
      * Função para definir mapeamento de middlewares
      *@param array $map
    */
    public static function setMap($map){
        self::$map = $map;
    }

    /**
      * Função para definir mapeamento de middlewares de varias rotas padrao
      *@param array $default
    */
    public static function setDefault($default){
        self::$default = $default;
    }
    
    /**
      * Função para exexutar o proximo nivel de middlewares
      *@param request $request
      *@return response
    */
    public function next($request){

        if(empty($this->middlewares)) return call_user_func_array($this->controller,$this->controllerArgs);

        // exibe os middlewares
        $middleware = array_shift($this->middlewares);

        if(!isset(self::$map[$middleware])){
            throw new \Exception("Problemas a processar os middlewares",500);
        }

        $queue = $this;
        $next = function($request) use ($queue){
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request,$next);
    }
}