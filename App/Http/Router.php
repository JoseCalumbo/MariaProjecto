<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \App\Http\Middleware\Queue;

class Router{

    private $url='';
    private $prefix='';
    private $routes=[];
    private $request;

    public function __construct($url=''){
        $this->request= new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    public function setPrefix(){
        $parseUrl = parse_url($this->url);
       $this->prefix = $parseUrl['path'] ??'';

    }
     /** 
      * @param string $method
      * @param string $route
      * @param string $params
      */
    private function addRoute($method,$route,$params=[]){

        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller']=$value;
                unset($params[$key]);
                continue;
            }
        }

        // middlewares da rota
        $params['middlewares'] = $params['middlewares'] ?? [];

        $params['variables'] = [];

        $patternVarial = '/{(.*?)}/';

        if (preg_match_all($patternVarial,$route,$matches)) {
            $route = preg_replace($patternVarial,'(.*?)',$route);
            $params['variables'] = $matches[1];

        }

        // padrao de validacaode routa
        $patternRoute='/^'.str_replace('/','\/',$route).'$/';

        $this->routes[$patternRoute][$method]=$params;

    }

    public function get($route,$params=[]){
        return $this->addRoute('GET',$route,$params);
    } 

    public function post($route,$params=[]){
        return $this->addRoute('POST',$route,$params);
    } 

    public function put($route,$params=[]){
        return $this->addRoute('PUT',$route,$params);
    } 

    public function delete($route,$params=[]){
        return $this->addRoute('DELETE',$route,$params);
    } 


    private function getUri(){
        $uri = $this->request->getUri();

        $xUri = strlen($this->prefix) ? explode($this->prefix,$uri):[$uri];
        return end($xUri);
    }

    private function getRoute(){
        $uri = $this->getUri();

        $httpMethod=$this->request->getHttpMethod();
        
        foreach($this->routes as $patternRoute=>$methods){

            //verifica se uri bate o padrao
            if(preg_match($patternRoute,$uri,$matches)){

                 //verifica o metodo
                if(isset($methods[$httpMethod])){

                    unset($matches[0]);

                    // chaves 
                     $keys = $methods[$httpMethod]['variables'];
                     $methods[$httpMethod]['variables'] = array_combine($keys,$matches);
                     $methods[$httpMethod]['variables']['request'] = $this->request; 

                    return $methods[$httpMethod];
                }
                throw new Exception("Metodo nao permetido", 405);
                
             }
        }// foreach end

        throw new Exception("URL nao encontrado", 404);
    }

    public function run(){
        try{
           $route = $this->getRoute();

            //verificao o controlador
            if(!isset($route['controller'])){
                throw new Exception("A URL nao processada",500);
            }

            $args = [];

            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();

               $args[$name] = $route['variables'][$name] ?? '';
            }

            // retorna a execucao da fila de middlewares
            return(new Queue($route['middlewares'],$route['controller'],$args))->next($this->request);

            //return call_user_func_array($route['controller'],$args); 

        }catch(Exception $e){

            return new Response($e->getCode(),$e->getMessage());
        }
    }

    /**
       * Função para .retornar Url atual
       *@return array
    */
    public function getCurrentUrl(){
         return $this->url.$this->getUri();
    }

    /**
       * Função para redericionar usuario a uma pagina
       *@param string $route
    */
    public function redirect($route){
         $url = $this->url.$route;
         header('location:'.$url);
         exit;
    }
}