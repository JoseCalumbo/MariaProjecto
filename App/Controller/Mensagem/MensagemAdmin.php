<?php

namespace App\Controller\Mensagem;

use \App\Utils\View;

class MensagemAdmin
{

  /** Função para retornar uma msg de sucesso
   *@param string $mesagem
   *@return string
   */
  public static function msgSucesso($mesagem)
  {
    return View::renderAdmin('mensagem/msg', [
      'tipo' => 'sucesso',
      'mensagem' => $mesagem
    ]);
  }

  /**
   * Função para retornar uma msg de erro
   * @param string $mesagem
   * @return string
   */
  public static function msgErro($mesagem)
  {
    return View::renderAdmin('mensagem/msg', [
      'tipo' => 'div-error',
      'mensagem' => $mesagem
    ]);
  }

  /**
   * Função para retornar uma msg de erro
   *@param string $mesagem
   *@return string
   */
  public static function msgAlerta($mesagem)
  {
    return View::renderAdmin('mensagem/msg', [
      'tipo' => 'alert',
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
    return View::renderAdmin('mensagem/msg1', [
      'tipo' => 'error',
      'mensagem' => $mesagem
    ]);
  }
}