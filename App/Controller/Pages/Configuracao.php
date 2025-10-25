<?php

namespace App\Controller\Pages;

use \App\Utils\View;

use \App\Model\Entity\FuncionarioDao;
use \App\Model\Entity\ExameDao;
use App\Model\Entity\PacienteDao;

class Configuracao extends Page
{

    // Busca o total paciente
    public static function getNumeroPaciente()
    {
        //quantidade total de registros da tabela paciente
        $quantidadetotal = PacienteDao::listarPaciente(null, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }

    // Busca o total dos Exames
    public static function getNumeroExame()
    {
        //quantidade total de registros da tabela user
        $quantidadetotal = ExameDao::listarExame(null, null, null, 'COUNT(*) as quantidade')->fetchObject()->quantidade;
        return $quantidadetotal;
    }



    // Método que apresenta a tela do Funcionario
    public static function telaConfiguracao($request)
    {
        $content = View::render('configuracao/configuracao', [
            'active' => 'blue-grey darken-3 white-text',
        ]);
        return parent::getPage('Configuração', $content);
    }

    // Método que apresenta a tela do Funcionario
    public static function cadastrosBasico($request)
    {
        $content = View::render('configuracao/item/cadastros_basico', [
            'active' => 'blue-grey darken-3 white-text',
            'numeroExame' => self::getNumeroExame(),
        ]);
        return parent::getPage('Configuração-Cadastro básico', $content);
    }

    // Método que apresenta a tela do Funcionario
    public static function configuracaoPaciente($request)
    {
        $content = View::render('configuracao/item/cadastros_paciente', [
            'active' => 'blue-grey darken-3 white-text',
            'numeroPaciente' => self::getNumeroPaciente(),
        ]);
        return parent::getPage('Configuração-Cadastro básico', $content);
    }
}
