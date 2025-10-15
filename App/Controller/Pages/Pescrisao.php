<?php 

namespace App\Controller\Pages;
use \App\Utils\Pagination;
use \App\Model\Entity\UsuarioDao;
use \App\Model\Entity\ZonaDao;
use \App\Model\Entity\VendedorDao;
use \App\Utils\View;


Class Pescrisao extends Page{



    // Metodo para gerar a pescrisao
    public static function telaConsulta($request){

        $buscar = filter_input(INPUT_GET, 'pesquisar',FILTER_SANITIZE_STRING);
        $content = View::render('consulta/consulta',[
             'pesquisar'=>$buscar,
            // 'listarZona'=>self::getBusca($request,$obPagination),
           //  'paginacao'=>parent::getPaginacao($request,$obPagination)
        ]);
        return parent::getPage('Painel Consulta', $content);
    }

    //metodo responsavel para pegar os paciente
    public static function getPaciente(){
            $paciente = '';
            $paciente = VendedorDao::listarVendedor();
            while( $obpaciente = $paciente->fetchObject(VendedorDao::class)){
                $paciente .= View::render('item/paciente', [
                    'nome'=>$obpaciente->nome,
                    'value'=>$obpaciente->id
                ]);
            }
            return $paciente;
    }

    // Metodo que cadastra consultas
    public static function cadastrarConsulta($request){

        $obZona = new ZonaDao;

        if (isset($_POST['zona'], $_POST['inicio'], $_POST['fim'], $_POST['mercado'])){
            
            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];
            $obZona->cadastrarZona();
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=cadastrado');
        }

        $content = View::render('consulta/formConsulta', [
            'titulo' => 'Registrar Nova Consultas',
            'button' => 'Salvar',
            'zona'=>'',
            'fim'=>'',
            'inicio'=>'',
            //'paciente'=>self::getPaciente(),
            'mercado'=>''

        ]);
        return parent::getPage('Cadastrar nova Zona', $content);
    }

    // Metodo que Edita Zona
    public static function editarZona($request,$id_zona){

        $obZona = ZonaDao::getZona($id_zona);

        if (isset($_POST['zona'], $_POST['inicio'], $_POST['fim'], $_POST['mercado'])){
                
            $obZona->zona = $_POST['zona'];
            $obZona->inicio_venda = $_POST['inicio'];
            $obZona->fim_venda = $_POST['fim'];
            $obZona->mercado = $_POST['mercado'];
            $obZona->AtualizarZona();
    
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=editado');
        }

        $content = View::render('zonas/formZona', [
                'titulo' => 'Editar Zona',
                'button' => 'Editar',
                'zona'=> $obZona->zona,
                'fim'=> $obZona->fim_venda,
                'inicio'=> $obZona->inicio_venda,
                'mercado'=> $obZona->mercado
        ]);
         return parent::getPage('Atualizar Zona', $content);
    }

    // Metodo que apagar Zona
    public static function apagarZona ($request,$id_zona){

        $obZona = ZonaDao::getZona($id_zona);

        if (isset($_POST['apagar'])){

            $obZona->apagarZona();
            
            // Redireciona para Painel Zona 
            $request->getRouter()->redirect('/zona?msg=apagado');
        }

        $content = View::render('zonas/deletaZona', [
                'titulo' => 'Apagar Zona',
                'button' => 'Sim',
                'zona'=> $obZona->zona,
                'id_zona'=> $obZona->id_zona,
                'mercado'=> $obZona->mercado
        ]);
         return parent::getPage('Apagar Zona', $content);
    }

}