<?php

require '../../vendor/autoload.php';

use App\controller\Pages\Prescrisao;

//var_dump($_POST);

$sugestao = filter_input(INPUT_POST,'adicional',FILTER_SANITIZE_STRING);

$ResultadoActual = filter_input(INPUT_POST,'resultadoAtual',FILTER_SANITIZE_STRING);

$pres = new Prescrisao();

$resultado = $pres->OlaMundo();

$pres->sugestaoMedica($sugestao, $resultado);
