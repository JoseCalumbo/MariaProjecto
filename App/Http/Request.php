<?php

namespace App\Http;

use \Closure;

class Request{

    // instancia do router
    private $router;

    private $httpMethod;
    /**  */
    private $uri;

    /** Parametros da URL $_GET */
    private $queryParams=[];

    /** Parametros da URL $_GET */
    private $postVars=[];
    private $headers=[];

    public function  __construct($router){
       $this->router = $router;
       $this->queryParams = $_GET ?? [];
       $this->postVars = $_POST ?? [];
       $this->headers = getallheaders();
       $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
       $this->setUri();
    }

    /**
       * Função para para redifinir uma uri
       *@param integer 
       *@return integer
    */
    private function setUri(){
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $setUri = explode('?',$this->uri);
        $this->uri = $setUri[0];
    }

    public function getRouter(){
        return $this->router;
    }

    public function getHttpMethod(){
        return $this->httpMethod;
    }

    public function getUri(){
        return $this->uri;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function getQueryParams(){
        return $this->queryParams;
    }

    public function getPostVars(){
        return $this->postVars;
    }
}