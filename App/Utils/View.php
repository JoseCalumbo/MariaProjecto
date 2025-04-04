<?php

namespace App\Utils;

class View{

    private static $vars=[];
    
    public static function init($vars=[]){
        self::$vars = $vars;
    }

    /**
     * Verifica se o arquivo existe html para 
     * @return String
     */
    private static function getContentView($view){
        $file = __DIR__.'/../../Resources/View/Pages/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    // funcao para exibir o conteudo da pagina
    public static function render($view,$vars=[]){

        $contentView = Self::getContentView($view);

        $vars = array_merge(self::$vars,$vars);
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);
        return str_replace($keys,array_values($vars),$contentView);
    }

     /**
     * Verifica se o arquivo existe pdf para imprimir 
     * @return String
     */
    private static function getContentViewPdf($view){
        $file = __DIR__.'/../../Resources/View/Imprimir/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    // funcao para exibir o conteudo da pagina pdf
    public static function renderPDF($view,$vars=[]){

            $contentView = Self::getContentViewPdf($view);
    
            $vars = array_merge(self::$vars,$vars);
            $keys = array_keys($vars);
            $keys = array_map(function($item){
                return '{{'.$item.'}}';
            },$keys);
            return str_replace($keys,array_values($vars),$contentView);
    }

}