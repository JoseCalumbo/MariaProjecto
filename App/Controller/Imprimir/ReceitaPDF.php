<?php

namespace App\Controller\Imprimir;

use \App\Utils\ViewPagePDF;
use \App\Utils\View;
use \App\Utils\Session;
use \App\Model\Entity\VendedorDao;
use \App\Model\Entity\ReceitaDao;

use Dompdf\Dompdf;
use Dompdf\Options;

class ReceitaPDF{



    // metodo que renderiza os dados dos vendedores na pagina HTML, lista de Vendedor 
    public static function getFacturaDados($id_conta,$id){

        $dadosFactura = ReceitaDao::getReceitaID($id_conta);

        // obtem o vendedor 
        $obVendedor = VendedorDao::getVendedorId($id);

        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');
        $hora = date('H:i');

        //obtem a logo
        $logo = 'http://localhost/MariaProjecto/Assets/img/logoMenu1.png';

        return View::renderPDF('receita/receita',[
            'id' => $dadosFactura->id,
            'nome' => $dadosFactura->nome,
            'email' => $dadosFactura->email,
            'morada' => $dadosFactura->morada,

            'data-pag' => date('d-m-y', strtotime($dadosFactura->data_pagamento)),
            'mes' => $dadosFactura->mes,
            'preco' => $dadosFactura->valor,
            'id-mensal' => $dadosFactura->id_mensal,
            'valor-pago' => $dadosFactura->valor_pagamento,
            'troco' => $dadosFactura->troco,

            'vencimento' => $dadosFactura->vencimento,
            'id-conta' => $dadosFactura->id_conta,
            'numRecibo' => $dadosFactura->id_pagamento,

            'user' => $dadosFactura->nome_us,

            'total' => $dadosFactura->valor_pagamento,

            'data-Actual' => $data,
            'hora-Actual' => date('H:i', strtotime($hora)),
            'logo' => $logo
        ]);
    }

    // metodo que converte a pagina html em PDF, lista Vendedor
    public static function imprimirFactura($id_conta,$id){

        $exibe = self::getFacturaDados($id_conta, $id);

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

// metodo que busca os dados no BD dos Vendedores  
 private static function getDadosListagem($id){

            $item = '';
    
            $resultado = ReceitaDao::getReceitaID($id);

            while ($dadosFactura  = $resultado->fetchObject(ReceitaDao::class)) {
    
                $item .= View::renderPDF('factura/listarest', [
                    'id' => $dadosFactura->id,
                    'nome' => $dadosFactura->nome,
                    'email' => $dadosFactura->email,
                    'morada' => $dadosFactura->morada,
        
                    'data-pag' => date('d-m-y', strtotime($dadosFactura->data_pagamento)),
                    'mes' => $dadosFactura->mes,
                    'preco' => $dadosFactura->valor,
                    'id-mensal' => $dadosFactura->id_mensal,
                    'valor-pago' => $dadosFactura->valor_pagamento,
                    'troco' => $dadosFactura->troco,
        
                    'vencimento' => $dadosFactura->vencimento,
                    'id-conta' => $dadosFactura->id_conta,
                    'numRecibo' => $dadosFactura->id_pagamento,
                
                    'total' => $dadosFactura->valor_pagamento,
    
                ]);
            }
    
            return $item;
        }

    // metodo que renderiza os dados dos vendedores na pagina HTML, lista de Vendedor 
    public static function getListagem($id){

        //Obtem os dados do usuario
        $var = self::getDadosListagem($id);

                // obtem o vendedor 
                $obVendedor = VendedorDao::getVendedorId($id);

        //obtem a data da impressao
        $data = Date('d/m/Y - H:i');
        $hora = date('H:i');

        //obtem a logo
        $logo = 'http://localhost/projectovenda/Assets/img/logo1.png';

        return View::renderPDF('factura/lista',[

            'resultados'=>$var,

            'id'=>$obVendedor->nome,
            'nome'=>$obVendedor->id,
            'data-Actual' => $data,
            'hora-Actual' => date('H:i', strtotime($hora)),
            'logo' => $logo
        ]);
    }


    // metodo que converte a pagina html em PDF, listagem do Vendedor
    public static function imprimirListagem($id){

        $exibe = self::getListagem($id);

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
