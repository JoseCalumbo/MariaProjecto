<?php

require '../../vendor/autoload.php';


use App\controller\Pages\Consulta;


$action = $_GET['action'] ?? '';

$permitidos = ['OlaMundo', 'sugestaoMedica','horario'];

$consulta = new Consulta();

if (in_array($action, $permitidos)) {
    $consulta->$action();
} else {
    http_response_code(404);
    echo 'Ação inválida';
}
