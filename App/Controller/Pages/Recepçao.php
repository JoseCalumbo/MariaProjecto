<?php

namespace App\Controller\Pages;

require_once __DIR__ . '/../../Utils/OpenRouterService.php';



use \App\Utils\View;
use \App\Utils\ConsultaMedica;
use \App\Utils\OpenRouterService;
use \App\Utils\OpenRouterService3;

class Recepçao extends Page
{

  // Metodo para gerar a pescrisao
  public static function telaRecepçao($request)
  {

    $content = View::render('recepcao/recepcao', [
      // 'dados' => $resposta,
    ]);
    return parent::getPage('Recepção Atendimento', $content);
  }

}