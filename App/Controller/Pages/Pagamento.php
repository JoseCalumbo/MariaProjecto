<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Utils\Pagination;
use \App\Model\Entity\VendedorDao;
use \App\Controller\Mensagem\Mensagem;
use App\Model\Entity\ContaDao;
use App\Model\Entity\MensalidadeDao;
use App\Model\Entity\PagamentoDao;
use App\Model\Entity\TaxaDao;

Class Pagamento extends Page {

    // exibe a messagem de operacao
    public static function exibeMensagem($request){

        $queryParam = $request->getQueryParams();
        
        if(!isset($queryParam['msg'])) return '';

        switch ($queryParam['msg']) {
            case 'cadastrado':
                return Mensagem::msgSucesso('Vendedor Cadastrado com sucesso');
                break;
            case 'alterado':
                return Mensagem::msgSucesso('Vendedor Alterado com sucesso');
                break;
            case 'apagado':
                return Mensagem::msgSucesso('Vendedor Apagdo com sucesso');
                break;
        }// fim do switch
    }

    //lista os usuario e paginacao
    private static function getConta($request,&$obPagination,$id){

        $item = '';

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);

        $condicoes = [
            strlen($buscar) ? 'nome LIKE "'.$buscar.'%"': null,
       ];
           
       // coloca na consulta sql
       $where = implode(' AND ',$condicoes);

        //quantidade total de registros da tabela vendedor
        $quantidadetotal = MensalidadeDao::listarContaMensal($id,null,null,'COUNT(*) as quantidade')
                                            ->fetchObject()->quantidade ?? '';

        //pagina actual 
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        // instancia de paginacao
        $obPagination = new Pagination($quantidadetotal,$paginaAtual,12);

        $resultado = MensalidadeDao::listarContaMensal($id,$obPagination->getLimit());

       while($obconta = $resultado->fetchObject(MensalidadeDao::class)){

            $item .= View::render('pagamento/listarconta', [
                'id_conta'=>$obconta->id_conta,
                'id_mensal'=>$obconta->id_mensal,
                'id_conta'=>$obconta->id_conta,
                'mes'=>$obconta->mes,
                'vencimento'=>$obconta->vencimento,
                'valor'=>$obconta->valor,
                'statu-conta'=>$obconta->status_conta,/// == 's' ? 'Corrente':'Processado',
                'cor-conta'=>$obconta->status_conta == 'não pago' ? 'red-text':'green-text',
                'statu'=>$obconta->status_mensalidade == 's' ? 'Corrente':'Processado',

                'cor'=>$obconta->status_mensalidade == 's' ? 'green-text':'',
                'ablitar-imprimir'=>$obconta->status_conta == 'não pago' ? 'disabled':'',
                'ablitar-pago'=>$obconta->status_conta == 'pago' ? 'disabled':'',
            ]);
      }

      $queryParam = $request->getQueryParams();

      if($queryParam['pesquisar'] ?? '') {

          return View::render('pesquisar/box_resultado',[
              'pesquisa'=>$buscar,
              'item'=>$item,
              'numResultado'=>$quantidadetotal,
          ]);

      }
        return $item;
    }

    // fazer pagamento
    public static function pagamento($request,$id_conta,$id){

        // obtem o valor da taxa do mes actual
        $obtaxaValor = TaxaDao::listarTaxa()->fetchObject(self::class);
        $valor = $obtaxaValor->valor;

        $obVendedor = VendedorDao::getVendedorId($id);
        $obVendedor->id;

        if(isset($_POST['valor'])){

            // Faz a diferenca do valor recido
            $trocoRecebido = $_POST["valor"]-$valor;

            $obPagamento = new PagamentoDao;
            $obPagamento->id_vendedor = $obVendedor->id;
            $obPagamento->valor_pagamento = $_POST['valor'];
            $obPagamento->troco = $trocoRecebido;
            $obPagamento->realizarPagamento();
        }

            $obconta = ContaDao::getTaxaId($id_conta);
            $obconta->status_conta = 'pago';
            $obconta->atualizarStatus();

            // Direciona na conta actual
            $request->getRouter()->redirect('/pagamento/'.$id);
    }

    //tela de pagamento das taxas 
    public static function telaPagamento($request,$id){

        // $pa= self::pagamento($request,$id,$id_conta);

        $mesActual = MensalidadeDao::getMesActual('s')->fetchObject();

        $VerificarMes = MensalidadeDao::verificarMesActual($id);

        // verificar o mes corrente cobrado
        if($mesActual->id_mensal != $VerificarMes->id_mensal){

            $novoconta = new VendedorDao;
            $novoconta->id = $id;
            //$novoconta->adicionarConta();
        }

        $obVendedor = VendedorDao::getVendedorId($id);

         $content = View::render('pagamento/pagamento',[

            'msg'=>self::exibeMensagem($request),
            'itemConta'=>self::getconta($request,$obPagination,$id),

            'imagem'=>$obVendedor->imagem,
            'id'=>$obVendedor->id,
            'nome'=>$obVendedor->nome,
            'estado'=>$obVendedor->estado,

        ]);
        return parent::getPage('Painel de pagamento', $content);
    }

}