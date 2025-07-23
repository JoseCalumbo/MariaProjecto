<?php

namespace App\Controller\Mensagem;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Mensagem
{


  /** Função para retornar uma msg de sucesso
   *@param string $mesagem
   *@return string
   */
  public static function msgSucesso($mesagem)
  {
    return View::renderAdmin('mensagem/msg', [
      'tipo' => 'sucesso',
      'pulse-tipo' => 'sucessoPulse',
      'mensagem' => $mesagem
    ]);
  }

  /**
   * Função para retornar uma msg de erro
   *@param string $mesagem
   *@return string
   */
  public static function msgErro($mesagem)
  {
    return View::render('mensagem/msg', [
      'tipo' => 'erro',
      'mensagem' => $mesagem
    ]);
  }

  /**
   * Função para retornar uma msg de erro
   *@param string $mesagem
   *@return string
   */
  public static function mensagemErro($mesagem)
  {
    return View::render('mensagem/msg1', [
      'tipo' => 'error',
      'mensagem' => $mesagem
    ]);
  }

  /**
   * Função para retornar uma msg de Alert
   *@param string $mesagem
   *@return string
   */
  public static function msgAlerta($mesagem)
  {
    return View::renderAdmin('mensagem/msg', [
      'tipo' => 'alert',
      'pulse-tipo' => 'erroAlert',
      'mensagem' => $mesagem
    ]);
  }
}
