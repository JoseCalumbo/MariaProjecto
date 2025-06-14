<?php

require __DIR__.'/config/app.php';

use \App\Http\Router;
use App\Model\Entity\MensalidadeDao;
use App\Utils\GerarMensalidade;

// instancia da routa 
$obRouter = new Router(URL);

// inclui os arquivos de routas do sistema
include __DIR__.'/routes/rotas.php';
include __DIR__.'/routes/rotasAdmin.php';
include __DIR__.'/routes/prints.php';


//$mensalida = new GerarMensalidade();

// apresenta os resultados das paginas
$obRouter->run()->sendResponse();//ola modificação
