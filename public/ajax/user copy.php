<?php

require '../../vendor/autoload.php';


use App\controller\Pages\Prescrisao;


$action = $_GET['action'] ?? '';

$permitidos = ['OlaMundo', 'sugestaoMedica','tesPost'];

$controller = new Prescrisao();

if (in_array($action, $permitidos)) {
    $controller->$action();
} else {
    http_response_code(404);
    echo 'Ação inválida';
}
