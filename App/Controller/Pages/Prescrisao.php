<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\ConsultaMedica;

class Prescrisao extends Page
{

    // Metodo para gerar a pescrisao
    public static function getTelaGeradorReceita($request, $id_consulta)
    {
      //  $consulta = new ConsultaMedica();
        $dados = "Paciente 20 anos, 60kg, febre 38ºC — qual medicamento usar?";

      //  $resposta = $consulta->analisarPaciente($dados);
        $content = View::render('ReceitaLayouts/mainIA', [
          // 'dados' => $resposta,
        ]);
        return parent::getPageReceita('Geradar de consulta', $content);
    }

}


/*
require_once "ConsultaMedica.php";

$consulta = new ConsultaMedica();

$dados = "Paciente 20 anos, 60kg, febre 38ºC — qual medicamento usar?";

$resposta = $consulta->analisarPaciente($dados);

echo "<pre>";
echo $resposta;
echo "</pre>";
*/