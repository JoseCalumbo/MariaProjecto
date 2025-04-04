<?php

namespace App\Controller\Imprimir;

use App\Controller\Relatorio\PageRelatorio;
use \App\Utils\ViewPagePDF;
use \App\Utils\View;
use \App\Model\Entity\VendedorDao;
use \App\Utils\Session;
use \App\Model\Entity\UsuarioDao;

use Dompdf\Dompdf;
use Dompdf\Options;

class Exemplo extends PageRelatorio{

    private static function getVendedor(){

        $item='';

       // $usuarioLogado = Session::getUsuarioLogado();
       // $id=$usuarioLogado['id_us'];

        $obVendedor = VendedorDao::getVendedorId(11);

            $item .= View::render('pdf/cartao', [
                'id'=>$obVendedor->id,
                'imagem'=>$obVendedor->imagem,
                'nome'=>$obVendedor->nome,
                'genero'=>$obVendedor->genero,
                'telefone'=>$obVendedor->telefone1,
                'zona'=>'Camama 4 de Abril',
            ]);
        return $item;
    }

        // funcao para apresenatar os dados do user dados 
        private static function getUsuarioConta(){
            $item = '';

            $usuarioLogado = Session::getUsuarioLogado();
            $id=$usuarioLogado['id_us'];
    
            $obUsuario = UsuarioDao::getUsuarioId($id);
    
            $item .= View::render('conta/dados', [
                'id'=>$obUsuario->id_us,
                'nome'=>$obUsuario->nome_us,
                'sobrenome'=>$obUsuario->sobrenome_us,
                'genero'=>$obUsuario->genero_us,
                'nascimento'=>$obUsuario->nascimento_us,
                'bilhete'=>$obUsuario->bilhete_us,
                'email'=>$obUsuario->email_us,
                'telefone'=>$obUsuario->telefone_us,
                'nivel'=>$obUsuario->nivel_us,
                'registro'=>$obUsuario->create_us,
                'imagem'=>$obUsuario->imagem_us
            ]);
            return $item;
    }

    public static function paginaText($request){

        //$var = self::getUsuarioConta();

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\Files\pdfs');
        $opcao->setIsRemoteEnabled(true);
        $opcao->setIsPhpEnabled(true);

        $dompdf = new Dompdf($opcao);


        // carrega um ficheiro html para class
        //$dompdf -> loadHtml('<h1> Vende1 Ambulante </h1>');
        //$dompdf->loadHtml($var);

        $dompdf->loadHtmlFile('C:\xampp\htdocs\mvcAmbulantes\Files\pdfs\listaVendedor.html');
        
        // pagina
        $dompdf->setPaper('A4', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
         echo ($dompdf->output());

        // $dompdf->stream('venda ');

        // $dompdf = ViewPagePDF::renderPDF($dompdf, [
        //     'nome' => 'Jose kk'
        // ]);

        // return parent::getPDF('Venda Ambulante', $dompdf);

        //metodo que renderiza layouts da pagina
        return View::render($dompdf,[
            'nome'=>'ka'
        ]);
    
    }


    public static function paginaTextBi($request){

        $var = self::getVendedor();

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\Files\documentos');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);


        // carrega um ficheiro html para class
        //$dompdf -> loadHtml('<h1> Vende1 Ambulante </h1>');
        $dompdf->loadHtml($var);

       // $dompdf->loadHtmlFile('C:\xampp\htdocs\mvcAmbulantes\Files\documentos\listaVendedor.html');
        //<script type="text/php"> ... </script>
        // pagina
        $customPaper = array(50,-50,609,488,-110,935);

        $dompdf->setPaper($customPaper);

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
         echo ($dompdf->output());

        // $dompdf->stream('venda ');

        $content = ViewPagePDF::renderPDF($dompdf, [
            //'conte' => $var
        ]);

        return parent::getPDF('Venda Ambulante', $content);
    }


    public static function userPrint(){
        
    }
}
