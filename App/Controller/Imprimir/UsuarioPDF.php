<?php

namespace App\Controller\Imprimir;
use \App\Utils\View;
use \App\Utils\Session;
use \App\Model\Entity\UsuarioDao;
use Dompdf\Dompdf;
use Dompdf\Options;

class UsuarioPDF{

    // Metodo que busca os dados dos usuario no Banco de dado 
    private static function getUsuarioPDF($request){
        
        $item = '';

        $resultado = UsuarioDao::listarUsuario(null,'nome_us');
 
        while($obUsuario = $resultado->fetchObject(UsuarioDao::class)){
            
            $item .= View::renderPDF('usuario/resultado', [
                'id_us'=>$obUsuario->id_us,
                'imagem'=>$obUsuario->imagem_us,
                'nome'=>$obUsuario->nome_us,
                'genero'=>$obUsuario->genero_us,
                'nasci'=>date('d-m-Y', strtotime( $obUsuario->nascimento_us)),
                'telefone'=>$obUsuario->telefone_us,
                'nivel'=>$obUsuario->nivel_us
            ]);
        }

       return $item;
    }

    // metodo responsavel que coloca os dados dos usuarios da lista na pagina HTML 
    public static function listaPdf($request){

        //Obtem os dados do usuario
        $var = self::getUsuarioPDF($request);

        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');

        //obtem a logo
        $logo = 'http://localhost/mvcAmbulantes/Assets/img/logo1.png';

        return View::renderPDF('usuario/listaUser',[
                'resultado'=>$var,
                'data-Actual'=>$data,
                'logo'=>$logo
            ]);
    
    }

    // metodo que converte a pagina HTML em lista PDF 
    public static function ListaUserPDF($request){

        $exibe = self::listaPdf($request);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\App\View\Imprimir');
        $opcao->setIsRemoteEnabled(true);
        $opcao->setIsPhpEnabled(true);


        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($exibe);

        $dompdf->setPaper('A4','portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
         echo ($dompdf->output());

        return View::renderPDF('usuario/'.$dompdf.'',[
            'nome'=>'ka'
        ]);
    }

    // metodo que faz o dowload e a  impressao da lista
    public static function imprimirUser($request){

        $exibe = self::listaPdf($request);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\App\View\Imprimir');
        $opcao->setIsRemoteEnabled(true);
        $opcao->setIsPhpEnabled(true);

        // instancia o dom pdf
        $dompdf = new Dompdf($opcao);

        // carrega a pagina html
        $dompdf->loadHtml($exibe);

        // Renderiza o tipo de pagina
        $dompdf->setPaper('A4','portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        $dompdf->stream("listaUsuario.pdf");
         
    }

}