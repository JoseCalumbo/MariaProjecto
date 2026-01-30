<?php

namespace App\Controller\Imprimir;

use App\Model\Entity\FuncionarioDao;
use \App\Utils\View;
use \App\Utils\Session;
use \App\Model\Entity\ReceitaDao;
use \App\Model\Entity\MedicamentoPrescritoDao;
use App\Model\Entity\PacienteDao;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReceitaPDF
{

    // metodo que busca a lista dos medicamentos prequistos 
    private static function getMedicamentosPrecristos($id_receita)
    {
        $item = '';
        $numero = 1;

        $listarMedicamentoPrescrito = MedicamentoPrescritoDao::listarMedicamentoPresecrito('r.id_receita = ' . $id_receita . '', 'nome_medicamento');

        while ($obMedicamento  = $listarMedicamentoPrescrito->fetchObject(ReceitaDao::class)) {

            $item .= View::renderPDF('receita/medicamentoPrescrito', [
                'via' => $obMedicamento->via_administracao,
                'numero' => $numero,
                'medicamento' => $obMedicamento->nome_medicamento,
                'posologia' => $obMedicamento->posologia_medicamento,
            ]);

            $numero++;
        }
        return $item;
    }

    // Metodo que renderiza os dados da receita
    public static function getConteudoHtml($id_receita)
    {
        //Obtem os dados do usuario
        $medicamentosPrescrito = self::getMedicamentosPrecristos($id_receita);

        // obtem a receita a se imprimir
        $obReceita = ReceitaDao::getReceitaID($id_receita);

        $obPaciente = PacienteDao::getPacienteId($obReceita->id_paciente);
        $obFuncionario = FuncionarioDao::getFuncionarioId($obReceita->id_funcionario);

        //obtem a data e hora da impressao
        $data = Date('d/m/Y - H:i');

        //obtem a logo
        $logo = '' . URL . '/Assets/img/logoMenu1.png';

        return View::renderPDF('receita/receita1', [

            'medicamentos' => $medicamentosPrescrito,

            'nome' => $obPaciente->nome_paciente,
            'numero' => $obPaciente->id_paciente,
            'idade' => !empty($obPaciente->nascimento_paciente) ? (date('Y') - date('Y', strtotime($obPaciente->nascimento_paciente))) : "Indefinido",

            'id' => $obReceita->id_receita,
            'registrodata' =>date('d/mY',strtotime($obReceita->data_receita)),
            'logo' => $logo,
            'obs' => $obReceita->observacoes,
            'funcionario' => $obFuncionario->nome_funcionario,
        ]);
    }

    // Metodo que imprimer a receita 
    public static function imprimirReceita($request, $id_receita)
    {
        $conteudo = self::getConteudoHtml($id_receita);

        $opcao = new Options();
        //$opcao->setChroot('C:\xampp\htdocs\MariaProjecto\Files\documentos');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($conteudo);

        $dompdf->setPaper('A5', 'portrait');
        //landscape

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
        echo ($dompdf->output());

        return View::renderPDF($dompdf, []);
    }


    //Metodo para baixar
    public static function baixarReceita($id_conta, $id)
    {
        echo '<pre>';
        print_r("vamos esta quase");
        echo '</pre>';
        exit;

        // $exibe = self::getFacturaDados($id_conta, $id);

        $opcao = new Options();
        //$opcao->setChroot('C:\xampp\htdocs\projectovenda\Files\documentos');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($exibe);

        $dompdf->setPaper('A5', 'portrait');
        //landscape

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
        echo ($dompdf->output());

        return View::renderPDF($dompdf, []);
    }
}
