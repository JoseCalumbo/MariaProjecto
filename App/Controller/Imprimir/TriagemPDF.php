<?php

namespace App\Controller\Imprimir;

use \App\Utils\View;
use \App\Utils\Session;
use \App\Model\Entity\TriagemDao;
use Dompdf\Dompdf;
use Dompdf\Options;

class TriagemPDF
{

    // Metodo que busca os dados dos usuario no Banco de dado 
    private static function getTriagemPDF($request, $id_triagem)
    {
        $item = '';
        /*
 
        while ($obUsuario = $resultado->fetchObject(TriagemDao::class)) {

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($triagemRegistrado->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::renderPDF('usuario/resultado', [
                'nome' => $triagemRegistrado->nome_paciente,
                'genero' => $triagemRegistrado->genero_paciente,
                'ano' => $idade,
                'peso' => $triagemRegistrado->peso_triagem,
                'temperatura' => $triagemRegistrado->temperatura_triagem,
                'pressao' => $triagemRegistrado->pressao_triagem,
                'frequencia_cardiaca' => $triagemRegistrado->pressao_triagem,
                'frequencia_respiratorio' => $triagemRegistrado->frequencia_triagem,
                'observação' => $triagemRegistrado->observacao_triagem,
            ]);
        }
            */

        return $item;
    }

    // metodo responsavel que coloca os dados dos usuarios da lista na pagina HTML 
    public static function fichaPdf($request)
    {

        //Obtem os dados do usuario
        //  $var = self::getUsuarioPDF($request);

        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');

        //obtem a logo
        $logo = 'http://localhost/MariaProjecto/Assets/img/logoMenu.png';

        return View::renderPDF('triagem/fichaTriagem', [
            // 'resultado' => $var,
            'data-Actual' => $data,
            'logo' => $logo
        ]);
    }

    // metodo que converte a pagina HTML em lista PDF 
    public static function ListaUserPDF($request)
    {

        $exibe = self::fichaPdf($request);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\App\View\Imprimir');
        $opcao->setIsRemoteEnabled(true);
        $opcao->setIsPhpEnabled(true);


        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($exibe);

        $dompdf->setPaper('A4', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
        echo ($dompdf->output());

        return View::renderPDF('usuario/' . $dompdf . '', [
            'nome' => 'ka'
        ]);
    }

    // metodo que faz o dowload e a  impressao da lista
    public static function imprimirTriagem($request)
    {
        $exibe = self::fichaPdf($request);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\MariaProjecto\App\View\Imprimir');
        $opcao->setIsRemoteEnabled(true);
        $opcao->setIsPhpEnabled(true);

        // instancia o dom pdf
        $dompdf = new Dompdf($opcao);

        // carrega a pagina html
        $dompdf->loadHtml($exibe);

        // Renderiza o tipo de pagina
        $dompdf->setPaper('A5', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // nomeia o arquivo a se baixado
        $dompdf->stream("ficha_triagem.pdf",[
            "Attachment" => false,
            true

        ]);
    }
}
