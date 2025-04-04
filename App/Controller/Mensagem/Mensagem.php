<?php 

namespace App\Controller\Mensagem;

use \App\Utils\View;
use \App\Model\Entity\Organization;

Class Mensagem{

    /**
      * Função para retornar uma msg de sucesso
      *@param string $mesagem
      *@return string
    */
    public static function msgSucesso($mesagem){
          return View::render('mensagem/msg',[
            'tipo'=>'msg',
            'mensagem'=>$mesagem
          ]);   
    }

    /**
      * Função para retornar uma msg de erro
      *@param string $mesagem
      *@return string
    */
    public static function msgErro($mesagem){
          return View::render('mensagem/msg',[
            'tipo'=>'div-error',
            'mensagem'=>$mesagem
          ]);   
    }

    /**
      * Função para retornar uma msg de erro
      *@param string $mesagem
      *@return string
    */
    public static function mensagemErro($mesagem){
          return View::render('mensagem/msg1',[
            'tipo'=>'error',
            'mensagem'=>$mesagem
          ]);   
    }
}