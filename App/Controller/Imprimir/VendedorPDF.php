<?php

namespace App\Controller\Imprimir;

use App\Model\Entity\NegocioDao;
use \App\Utils\ViewPagePDF;
use \App\Utils\View;
use \App\Utils\Session;
use \App\Model\Entity\VendedorDao;
use \App\Model\Entity\AdmimUserDao;

use Dompdf\Dompdf;
use Dompdf\Options;

class VendedorPDF{

    // metodo que busca os dados no BD dos Vendedores  
    private static function getVendedorPDF($request){

        $item = '';

        $resultado = AdmimUserDao::listarUsuario(null);

        while ($obVendedor = $resultado->fetchObject(VendedorDao::class)) {

            $item .= View::renderPDF('funcionario/resultadoV', [
                'id_us' => $obVendedor->id,
                'imagem' => $obVendedor->imagem,
                'nome' => $obVendedor->nome,
                'genero' => $obVendedor->genero,
                'nasci' => date('d-m-Y', strtotime($obVendedor->nascimento)),
                'telefone' => $obVendedor->telefone1,
                'zona' => $obVendedor->id_zona

            ]);
        }

        return $item;
    }

    // metodo que renderiza os dados dos vendedores na pagina HTML, lista de Vendedor 
    public static function listaPdf($request){

        $listaDados = self::getVendedorPDF($request);

        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');

        //obtem a logo
           $logo = 'http://localhost/MariaProjecto/Assets/img/logoMenu1.png';

        return View::renderPDF('usuario/listaUser',[
            'resultado' => $listaDados,
            'data-Actual' => $data,
            'logo' => $logo
        ]);
    }

    // metodo que converte a pagina html em PDF, lista Vendedor
    public static function ListaVendedorPDF($request){

        $exibe = self::listaPdf($request);

        $opcao = new Options();
$opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\Files\documentos');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($exibe);

        $dompdf->setPaper('A4', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
        echo ($dompdf->output());

        return View::renderPDF($dompdf, [
            'nome' => 'ka'
        ]);
    }

    // metodo que converte html e baixa a lista vendedor 
    public static function imprimiVendedorPDF($request) {

        $exibe = self::listaPdf($request);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\MariaProjecto\Files\pdfs');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($exibe);

        $dompdf->setPaper('A4', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        $dompdf->stream("lista-vendedor.pdf");
    }

    //______________________________________ FICHA__________________________________________________

    // metodo que busca o dado de um vendedor e renderiza na pagina Html
    public static function getVendedorDado($request, $id){

        // obtem o vendedor 
        $obVendedor = VendedorDao::getVendedorId($id);

        // obtem a zona de venda do vendedor
        $obZona = VendedorDao::negocioZona($id);

        // obtem os negocios do vendedor ambulante 
        $obNegocios = VendedorDao::negocioVendedor($id);

        // apresenta os negocios cadastrado
        $negocios = '';

        // apresenta a zona cadastrada
        $zona = '';

        
        foreach($obNegocios as $neg){
            $negocios .=''.$neg->negocio.',';
        }
        
        foreach($obZona as $zonas){
            $zona .=''.$zonas->mercado.'';
        }

        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');

        //obtem a logo
        $logo = 'http://localhost/mvcAmbulantes/Assets/img/logo1.png';

        return View::renderPDF('vendedor/fichaVendedor', [
            //dados do vendedor
            'id' => $obVendedor->id,
            'nome' => $obVendedor->nome,
            'genero' => $obVendedor->genero,
            'nascimento' => $obVendedor->nascimento,
            'pai' => $obVendedor->pai,
            'mae' => $obVendedor->mae,
            'bilhete' => $obVendedor->bilhete,
            'telefone1' => $obVendedor->telefone1,
            'telefone2' => $obVendedor->telefone2,
            'email' => $obVendedor->email,
            'morada' => $obVendedor->morada,
            'nivel' => $obVendedor->nivelAcademico,
            'imagem'=>$obVendedor->imagem,
            'criado' => $obVendedor->create_vs,
            'zonas' => $zona,
            'negocio' => $negocios,

            //por definir 
            'local'=>'Camama, 4 de Abril',
            // dados do sistema 
            'data-Actual' => $data,
            'logo' => $logo
        ]);
    }

    //metodo que converte a pagina Html em  ficha PDF
    public static function imprimiFicha($request,$id){

        // obtem os dodos do vendedor e pagina Html
        $vendedor = self::getVendedorDado($request,$id);

        $obVendedor = VendedorDao::getVendedorId($id);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\Files\documentos');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($vendedor);

        $dompdf->setPaper('A4', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
        echo ($dompdf->output());

        return View::renderPDF($dompdf, []);

        // baixa em pdf
        // $dompdf->stream("".$obVendedor->nome."Ficha.pdf");
        
    }

    //_______________________________________DECLARAÇÃO_________________________________________

    // metodo que busca o dado  de um vendedor e renderiza na pagina Html
    public static function getVendedorDeclaracao($request, $id){

        // obtem o vendedor 
        $obVendedor = VendedorDao::getVendedorId($id);
    
        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');
    
        //obtem a logo
        $logo = 'http://localhost/mvcAmbulantes/Assets/img/logo1.png';
    
        return View::renderPDF('vendedor/declaracao', [
                //dados do vendedor
                'id' => $obVendedor->id,
                'nome' => $obVendedor->nome,
                'genero' => $obVendedor->genero,
                'nascimento' =>date('d-M-Y', strtotime( $obVendedor->nascimento)),
                'pai' => $obVendedor->pai,
                'mae' => $obVendedor->mae,
                'bilhete' => $obVendedor->bilhete,
                'telefone1' => $obVendedor->telefone1,
                'telefone2' => $obVendedor->telefone2,
                'email' => $obVendedor->email,
                'morada' => $obVendedor->morada,
                'nivel' => $obVendedor->nivelAcademico,
                'imagem'=>$obVendedor->imagem,
                'criado' => date('d-M-Y', strtotime( $obVendedor->create_vs)),
    
                //por definir 
                'local'=>'Camama, 4 de Abril',
                // dados do sistema 
                'data-Actual' => $data,
                'logo' => $logo
        ]);
    }


    //metodo que converte a pagina Html em declaraçao PDF
    public static function declaracaoVendedor($request,$id){

        // obtem os dodos do vendedor e pagina Html
        $vendedor = self::getVendedorDeclaracao($request,$id);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\mvcAmbulantes\Files\documentos');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($vendedor);

        $dompdf->setPaper('A4', 'portrait');

        // renderiza o arquivo pdf
        $dompdf->render();

        // imforma que e um file pdf
        header('Content-type: application/pdf');

        // imprime o resultado saida
        echo ($dompdf->output());

        return View::renderPDF($dompdf, []);
    }
   


//_______________________________________Cartao_________________________________________

    // metodo que busca o dado  de um vendedor e renderiza na pagina Html
    public static function getVendedorCartao($request, $id){

        // obtem o vendedor 
        $obVendedor = VendedorDao::getVendedorId($id);

        $dia=170;
    
        //obtem a data da impressao
        $data = Date('d/m/Y',strtotime('+' . $dia . ' days'));
    
        //obtem a logo
        $logo = 'http://localhost/projectovenda/Assets/img/logo1.png';
    
        return View::renderPDF('vendedor/cartaoVendedor', [
                //dados do vendedor
                'id' => $obVendedor->id,
                'nome' => $obVendedor->nome,
                'genero' => $obVendedor->genero,
                'nascimento' =>date('d-M-Y', strtotime( $obVendedor->nascimento)),
                'pai' => $obVendedor->pai,
                'mae' => $obVendedor->mae,
                'bilhete' => $obVendedor->bilhete,
                'telefone1' => $obVendedor->telefone1,
                'telefone2' => $obVendedor->telefone2,
                'email' => $obVendedor->email,
                'morada' => $obVendedor->morada,
                'nivel' => $obVendedor->nivelAcademico,
                'imagem'=>$obVendedor->imagem,
                'criado' => date('d-M-Y', strtotime( $obVendedor->create_vs)),
    
                //por definir 
                'zona'=>'Camama, 4 de Abril',
                // dados do sistema 
                'data' => $data,
                'logo' => $logo
        ]);
    }


    //metodo que converte a pagina Html em declaraçao PDF
    public static function cartaoVendedor($request,$id){

        // obtem os dodos do vendedor e pagina Html
        $vendedor = self::getVendedorCartao($request,$id);

        $opcao = new Options();
        $opcao->setChroot('C:\xampp\htdocs\projectovenda\Files\documentos');
        $opcao->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($opcao);

        $dompdf->loadHtml($vendedor);

        $dompdf->setPaper('A7', 'portrait');
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
