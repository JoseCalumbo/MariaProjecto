<?php

namespace App\Utils;

use \Strings;

class View
{
    private static $vars = [];

    public static function init($vars = [])
    {
        self::$vars = $vars;
    }

    /**
     * Verifica se o arquivo existe html para 
     * @return string
     */
    private static function getContentView($view)
    {
        $file = __DIR__ . '/../../Resources/View/Pages/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    // Função para exibir o conteudo da pagina
    public static function render($view, $vars = [])
    {
        $contentView = self::getContentView($view);

        $vars = array_merge(self::$vars, $vars);
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);
        return str_replace($keys, array_values($vars), $contentView);
    }

    /**
     * Verifica se o arquivo existe html para ADMIN
     * @return string
     */
    private static function getContentViewAdmin($view)
    {
        $file = __DIR__ . '/../../Resources/View/PagesAdmin/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    // Função para exibir o conteúdo da página para ADMIN
    public static function renderAdmin($view, $vars = [])
    {
        $contentView = self::getContentViewAdmin($view);

        $vars = array_merge(self::$vars, $vars);
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);
        return str_replace($keys, array_values($vars), $contentView);
    }

    /**
     * Verifica se o arquivo existe pdf para imprimir 
     * @return string
     */
    private static function getContentViewPdf($view)
    {
        $file = __DIR__ . '/../../Resources/View/Imprimir/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    // Função para exibir o conteudo da página PDF
    public static function renderPDF($view, $vars = [])
    {
        $contentView = self::getContentViewPdf($view);
        $vars = array_merge(self::$vars, $vars);
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);
        return str_replace($keys, array_values($vars), $contentView);
    }

}