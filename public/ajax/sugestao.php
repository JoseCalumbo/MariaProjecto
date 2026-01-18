<?php
require '../../vendor/autoload.php';

use App\controller\Pages\Prescrisao;

$sugestao        = filter_input(INPUT_POST,'adicional',FILTER_SANITIZE_STRING);
$ResultadoActual = filter_input(INPUT_POST,'resultadoAtual',FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST,'nomePaciente',FILTER_SANITIZE_SPECIAL_CHARS);
$peso = filter_input(INPUT_POST,'pesoPaciente',FILTER_SANITIZE_SPECIAL_CHARS);
$idade = filter_input(INPUT_POST,'idadePaciente',FILTER_SANITIZE_SPECIAL_CHARS);

// Instanciar a classe
$prescrisao = new Prescrisao();


// echo $nome; 
// echo $peso; 
// echo $idade; 
// exit;

// obter o metodo da sugestão
$prescrisao->sugestaoMedica($nome, $peso, $idade, $sugestao, $ResultadoActual);
