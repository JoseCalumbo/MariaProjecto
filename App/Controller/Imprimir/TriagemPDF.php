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

        //Instancia da classe model da triagem
        $triagemRegistrado = TriagemDao::getTriagemRegistradoId($id_triagem);

        while ($triagem = $triagemRegistrado->fetchObject(TriagemDao::class)) {

            // formata o hora 
            $formatadaHora = date("h:i", strtotime($triagem->data_triagem));

            // formata a idade do paciente
            $formataIdade = date("Y", strtotime($triagem->nascimento_paciente));
            $idade = date("Y") - $formataIdade;

            $item .= View::renderPDF('triagem/listarTriagem', [
                'titulo' => 'Triagem realizada com sucesso',
                'nome' => $triagemRegistrado->nome_paciente,
                'genero' => $triagemRegistrado->genero_paciente,
                'ano' => $idade,
                'peso' => $triagemRegistrado->peso_triagem,
                'temperatura' => $triagemRegistrado->temperatura_triagem,
                'pressao' => $triagemRegistrado->pressao_triagem,
                'frequencia_cardiaca' => $triagemRegistrado->pressao_triagem,
                'frequencia_respiratorio' => $triagemRegistrado->frequencia_triagem,
                'observação' => $triagemRegistrado->observacao_triagem,
                'button1' => 'Finalizar',
            ]);
        }

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

    // metodo que converte a pagina HTML em lista PDF 
    public static function ListaUserPDF($request, $id_triagem)
    {
        $exibe = self::fichaPdf($request, $id_triagem);
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

    // metodo responsavel que coloca os dados dos usuarios da lista na pagina HTML 
    public static function fichaPdf($request, $id_triagem)
    {
        //Instancia da classe model da triagem
        $triagemRegistrado = TriagemDao::getTriagemRegistradoId($id_triagem);

        //Obtem os dados do usuario
        // $dados = self::getTriagemPDF($request, $id_triagem);

         //Pega o id do usuario logado
        $usuarioLogado = Session::getUsuarioLogado();
        $funcionario = $usuarioLogado['nome'];

        // formata a idade do paciente
        $formataIdade = date("Y", strtotime($triagemRegistrado->nascimento_paciente));
        $idade = date("Y") - $formataIdade;

        // formata o data
        $dataTriagem = date("d/m/Y", strtotime($triagemRegistrado->data_triagem));
        // formata a hora
        $horaTriagem = date("H:i", strtotime($triagemRegistrado->data_triagem));

        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');

        // pioridade de atendimento
        $atender = $triagemRegistrado->risco_triagem;
        $triagemAtender = "";
        switch ($atender) {
            case 'a':
                $triagemAtender = "Vermelho";
                break;
            case 'b':
                $triagemAtender = "Laranja";
                break;
            case 'c':
                $triagemAtender = "Amarelo";
                break;
            case 'd':
                $triagemAtender = "Verde";
                break;
            case 'e':
                $triagemAtender = "Azul";
                break;
        } // fim do switch

                //Obtem a data e hora actual 
        $dataHoje = date('d-m-Y H:i:s');

        //obtem a logo
        $logo = 'http://localhost/MariaProjecto/Assets/img/logoMenu1.png';

        return View::renderPDF('triagem/fichaTriagem', [
            //  'resultado' => $dados,
            'data-Actual' => $data,
            'numero' => $triagemRegistrado->id_paciente,
            'nome' => $triagemRegistrado->nome_paciente,
            'nascimento' => $idade,
            'registrodata' => $dataTriagem,
            'registrohora' => $horaTriagem,
            'logo' => $logo,

            'peso' => $triagemRegistrado->peso_triagem,
            'temperatura' => $triagemRegistrado->temperatura_triagem,
            'pressao' => $triagemRegistrado->pressao_arterial_triagem,
            'frequencia_cardiaca' => $triagemRegistrado->frequencia_cardiaca_triagem = empty($triagemRegistrado -> frequencia_cardiaca_triagem) ? '______ ': $triagemRegistrado -> frequencia_cardiaca_triagem,
            'frequencia_respiratorio' => $triagemRegistrado->frequencia_respiratorio_triagem  = empty($triagemRegistrado->frequencia_respiratorio_triagem) ? '______ ': $triagemRegistrado->frequencia_respiratorio_triagem,
            'saturacao' => $triagemRegistrado->Saturacao_oxigenio_triagem = empty($triagemRegistrado->Saturacao_oxigenio_triagem) ? '______ ':$triagemRegistrado->Saturacao_oxigenio_triagem,
            'pioridade' => $triagemAtender,
            'obs' => $triagemRegistrado->observacao_triagem,
            'funcionario' => $funcionario,
            'data' => $dataHoje,

        ]);
    }

    // metodo que faz o dowload e a  impressao da lista
    public static function ImprimirFichaTriagem($request, $id_triagem)
    {
        $exibe = self::fichaPdf($request, $id_triagem);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\MariaProjecto\App\Controller\Imprimir');
        $opcao->setIsRemoteEnabled(true);
        $opcao->setIsPhpEnabled(true);

        // instancia o dom pdf
        $dompdf = new Dompdf($opcao);

        // carrega a pagina html
        $dompdf->loadHtml($exibe);

        // Renderiza o tipo de pagina
        $dompdf->setPaper('A4', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        ob_end_clean(); // limpa o buffer de saída

        // imprime o resultado saida
        echo ($dompdf->output());

        // nomeia o arquivo a se baixado
        $dompdf->stream("triagem.pdf", [
            "Attachment" => false,
            true
        ]);
    }

    // metodo que faz o dowload e a  impressao da lista
    public static function baixarFichaTriagem($request, $id_triagem)
    {
        $exibe = self::fichaPdf($request, $id_triagem);

        $opcao = new Options();

        $opcao->setChroot(__DIR__);

        $opcao->setIsRemoteEnabled(true);
        $opcao->setIsPhpEnabled(true);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf($opcao);

        // carrega a pagina html
        $dompdf->loadHtml($exibe);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        ob_end_clean(); // limpa o buffer de saída

        // renderiza o arquivo pdf
        $dompdf->render();

        $dompdf->stream("triagemFicha.pdf");
    }
}
