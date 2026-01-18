<?php

require '../../vendor/autoload.php';

use App\controller\Pages\Prescrisao;

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$idade = filter_input(INPUT_POST, 'idade', FILTER_SANITIZE_STRING);
$peso = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_STRING);
$sintomas = filter_input(INPUT_POST, 'sintomas', FILTER_SANITIZE_STRING);
$diagnostico = filter_input(INPUT_POST, 'diagnostico', FILTER_SANITIZE_STRING);
$alergia = filter_input(INPUT_POST, 'alergia', FILTER_SANITIZE_STRING);
$usoMedicamento = filter_input(INPUT_POST, 'usoMedicamento', FILTER_SANITIZE_STRING);

$obPrescrisao = new Prescrisao();

// echo "para aqui"; exit;

// Envia os dados do paciente para o metodo para ser analizado
$obPrescrisao->analizarComIA($nome, $idade, $peso, $sintomas, $diagnostico, $alergia, $usoMedicamento);
