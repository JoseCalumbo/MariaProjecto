<?php

require __DIR__.'/../vendor/autoload.php';

use \App\Utils\View;
use \App\Http\Middleware\Queue;
use \App\Utils\Environment;
use \App\Model\Database;

//carega variavel de ambiente
Environment::load(__DIR__.'/../');

Database::config(
    getenv('HOST'),
    getenv('NAME'),
    getenv('USER'),
    getenv('PASS'),
    getenv('PORT'),
);

//define URL a constante do caminho do projecto 
define('URL',getenv('URL'));

//defini local server
define('LOCAL_URL',$_SERVER['DOCUMENT_ROOT'].'/MariaProjecto');

//valor padrao das variaveis 
View::init([
    'URL'=>URL
]);

//Mapea os middlewares
Queue::setMap([
    'maintenance' => \App\Http\Middleware\Maintenence::class,
    'requer-logout' => \App\Http\Middleware\RequerLogout::class,
    'requer-login' => \App\Http\Middleware\RequerLogin::class,
    'nivel-acesso' => \App\Http\Middleware\NivelAcesso::class
]);

//Mapea os middlewares padrao
Queue::setDefault([
    'maintenance' 
]);