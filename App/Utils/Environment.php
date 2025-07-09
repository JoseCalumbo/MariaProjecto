<?php

namespace App\Utils;

class Environment{

    /**
     * responsavel para carregar as variaveis
     */
    public static function load($dir){
        if(!file_exists($dir.'/.env')){
            return false;
        }

        $lines = file($dir.'/.env');
        foreach($lines as $line){
            putenv(trim($line));
        }
    }
}
