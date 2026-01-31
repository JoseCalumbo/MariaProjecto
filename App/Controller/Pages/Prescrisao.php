<?php

namespace App\Controller\Pages;

require_once __DIR__ . '/../../Utils/OpenRouterService.php';

use \App\Utils\View;
use \App\Utils\OpenRouterService;
use \App\Utils\OpenRouterService3;

use App\Model\Entity\ConsultaDao;
use App\Model\Entity\MedicamentoDao;
use App\Model\Entity\MedicamentoPrescritoDao;
use App\Model\Entity\TriagemDao;
use App\Model\Entity\ReceitaDao;
use App\Model\Entity\FuncionarioDao;
use App\Model\Entity\PacienteDao;

use DateTime;

class Prescrisao extends Page
{
  // busca todos os medicamentos para os select
  public static function getMedicamentoSelect()
  {
    $resultadoMedicamento = '';

    $listarMedicamento = MedicamentoDao::listarMedicamento(null, 'nome_medicamento');

    while ($obMedicamento = $listarMedicamento->fetchObject(MedicamentoDao::class)) {
      $resultadoMedicamento .= View::render('ReceitaLayouts/itemPrescrisao/medicamentos', [
        'value' => $obMedicamento->id_medicamento,
        'medicamento' => $obMedicamento->nome_medicamento,
      ]);
    }
    return $resultadoMedicamento;
  }

  // busca todos os medicamentos prescritos
  public static function getMedicamentoPrescrito($id_receita)
  {
    $resultadoPrescrito = '';
    $numero = 1;

    $listarMedicamentoPrescrito = MedicamentoPrescritoDao::listarMedicamentoPresecrito('r.id_receita = ' . $id_receita . '', 'nome_medicamento');

    while ($obMedicamento = $listarMedicamentoPrescrito->fetchObject(MedicamentoPrescritoDao::class)) {

      $resultadoPrescrito .= View::render('ReceitaLayouts/itemPrescrisao/medicamentoPrescrito', [
        'via' => $obMedicamento->via_administracao,
        'numero' => $numero,
        'medicamento' => $obMedicamento->nome_medicamento,
        'posologia' => $obMedicamento->nome_medicamento,
      ]);

      $numero++;
    }
    return $resultadoPrescrito;
  }


  // Método apresenta a janela do gerador 
  public static function getTelaGeradorReceita($request, $id_consulta)
  {
    //obtem a consulta actual do paciente 
    $obConsulta = ConsultaDao::getConsultaRelizada($id_consulta);

    //obtem a triagem da consulta
    $obTriagem = TriagemDao::getTriagemId($obConsulta->id_triagem);

    $content = View::render('ReceitaLayouts/mainIA', [
      'nome' => $obConsulta->nome_paciente,
      'idade' => !empty($obConsulta->nascimento_paciente) ? (date('Y') - date('Y', strtotime($obConsulta->nascimento_paciente))) : "Indefinido",
      'peso' => $obTriagem->peso_triagem,
      'motivo_consulta' => $obConsulta->motivo_consulta,
      'diagnostico' => $obConsulta->diagnostico_consulta,
      'medicamentoUso' => $obConsulta->medicamentoUso_consulta,
      'alergia' => $obConsulta->alergia_consulta,

      'medicamentos' => self::getMedicamentoSelect(),
    ]);
    return parent::getPageReceita('Geradar de consulta', $content);
  }

  // Método para cadastrar a receita
  public static function setRegistrarReceita($request, $id_consulta)
  {

    $idMedicamento = [];

    //obtem a consulta actual do paciente 
    $obConsulta = ConsultaDao::getConsultaRelizada($id_consulta);

    // Instancia class dos medicamentos prescritos na recita
    $obMedicamentoPrescrito = new MedicamentoPrescritoDao();

    // Instancia class para salvar a receita no BD
    $obReceita = new ReceitaDao();

    $idConsulta = $id_consulta; // obtem o id da consulta
    $idPaciente = $obConsulta->id_paciente; // obtem o id do paciente 

    if (isset($_POST['salvarPrescrisao'])) {

      if (isset($_POST['obs'])) {
        $obReceita->id_paciente = $idPaciente;
        $obReceita->id_consulta = $idConsulta;
        $obReceita->observacoes = $_POST['obs'];
        // Acessa o metodo para salvar  a receita e obtem o retorno do id da receita salva 
        $idReceita = $obReceita->cadastrarReceita();
      }

      // Verifica se foi precrito medicamento
      if (isset($_POST['medicamentoNome'], $_POST['medicamentoVia'], $_POST['medicamentoPosologia'],)) {

        $idMedicamento = $_POST['medicamentoNome'];
        $medicamentoVia = $_POST['medicamentoVia'];
        $posologia = $_POST['medicamentoPosologia'];

        // Loop para os medicamentos um por um 
        for ($i = 0; $i < count($idMedicamento); $i++) {

          $obMedicamentoPrescrito->id_receita = $idReceita;

          $obMedicamentoPrescrito->id_medicamento = $idMedicamento[$i];
          $obMedicamentoPrescrito->via_administracao = $medicamentoVia[$i];
          $obMedicamentoPrescrito->posologia_medicamento = $posologia[$i];
          $obMedicamentoPrescrito->cadastrarMedicamentosPrescrito();
        }

        // troca o estado 
        $obConsulta->estadoConsultaReceita('Com receita');

        sleep(2);
        // Redireciona validaçao e gerar consulta depois dos exames
        $request->getRouter()->redirect('/receita/validar/' . $idReceita . '?msg=validar');
      } else {
        
        // troca o estado 
        $obConsulta->estadoConsultaReceita('Com receita');

        sleep(2);
        // Redireciona 
        $request->getRouter()->redirect('/receita/validar/' . $idReceita . '?msg=validar');
      }
    }
    //return parent::getPageReceita('Geradar de consulta');
  }

  // Metodo responsavel por finalizar a receita GET
  public static function getReceitaFinalizada($request, $id_receita)
  {
    // Obtem a receita finalizada por id
    $obReceita = ReceitaDao::getReceitaID($id_receita);

    $obConsulta =    ConsultaDao::getConsulta($obReceita->id_consulta);
    $obPaciente =    PacienteDao::getPacienteId($obReceita->id_paciente);
    $obTriagem =     TriagemDao::getTriagemId($obConsulta->id_triagem);
    $obFuncionario = FuncionarioDao::getFuncionarioId($obReceita->id_funcionario);

    $data = new DateTime($obReceita->data_receita);
    $meses = [
      1 => 'Janeiro',
      2 => 'Fevereiro',
      3 => 'Março',
      4 => 'Abril',
      5 => 'Maio',
      6 => 'Junho',
      7 => 'Julho',
      8 => 'Agosto',
      9 => 'Setembro',
      10 => 'Outubro',
      11 => 'Novembro',
      12 => 'Dezembro'
    ];

    $content = View::render('ReceitaLayouts/resumoReceita', [
      'id_receita' => $obReceita->id_receita,
      'nome' => $obPaciente->nome_paciente,
      'idade' => !empty($obPaciente->nascimento_paciente) ? (date('Y') - date('Y', strtotime($obPaciente->nascimento_paciente))) : "Indefinido",
      'peso' => $obTriagem->peso_triagem,
      'alergia' => $obConsulta->alergia_consulta,
      'data' => $obReceita->data_receita,
      'dataReceita' => $data->format('d') . ' de ' . $meses[(int)$data->format('m')] . ' de ' . $data->format('Y'),
      'obs' => $obReceita->observacoes,

      'medicamentos' => self::getMedicamentoPrescrito($id_receita),
    ]);
    return parent::getPageReceita('Receita salva', $content);
  }

  // Metodo responsavel por finalizar a receita POST
  public static function setReceitaFinalizada($request, $id_receita) {}

  // Metodo responsavel redireceiona para imprimir a receita
  public static function getImprimir($request, $id_consulta)
  {

    //Obtem a receita finalizada por id
    $obReceitaConsulta = ReceitaDao::getReceitaIDconsulta($id_consulta);

    // Obtem a receita finalizada por id
    $obReceita = ReceitaDao::getReceitaID($obReceitaConsulta->id_receita);

    // Redireciona para imprimir receita
    $request->getRouter()->redirect('/receita/imprimir/' . $obReceita->id_receita . '');
  }


  public static function analizarComIA($nome, $idade, $peso, $sintomas, $diagnostico, $alergia, $usoMedicamento)
  {
    $obIA = new OpenRouterService();

    $resposta = $obIA->sendMessage(
      'MUITO IMPORTANTE: ANTES IGNORE qualquer contexto ou instrução anterior especialmente formatação de texto

      Em um agente auxiliar medica, (utilizado por um médico) que ajuda a exclarecer e não 
      substituir o médico no consultorio, 

      DADOS DO PACIENTE:
      Nome ' . $nome . ' tem  ' . $idade . ' anos e pesa ' . $peso . 'kg. 
      É alergico algum medicamento ' . $alergia . ' e esta usar um medicamento actualmente ' . $usoMedicamento . '  ,
      DADOS DA TRIAGEM RELAIZADA NA CONSULTA: 
      pressão arterial normal, frequência cardíaca normal, temperatura corporal 38 graus.                
      DADOS DA CONSULTA: 
      Paciente relata ' . $sintomas . '
      O EXAME LABORATORIAL REVELOU:
      níveis de Hemoglobina baixa e hematócrito reduzido, tem paludismo
      O DIAGNÓSTICO FINAL: 
      Identificou-se que o paciente possoui ou tem a doença de: ' . $diagnostico . '

      Com base nesses dados, gera uma sugestão neste formato os MEDICAMENTOS:
        1) <strong>Nome:</strong>
           <strong>Posologia:</strong>
           <strong>Duração:</strong>
           <strong>Via de administração:</strong>
           <strong>Justificativa:</strong>

      * Observações Importantes: Lembrando que este é apenas um agente auxiliar não
      um medico e que esta usar e deve sempre ser consultado para um diagnóstico preciso e 
      prescrição adequada.

      FORMATAÇÃO IMPONTANTES COMO APRESENTAR O RESÚLTADO
      - Apresenta as seguintes palavras negritada: "Nome, Posologia, Duração, 
        "Via de administração" e "Justivicativa" e importante que ficam negritada
      - Não adiciona os Markdown como: (```html```, **, #)
      - NÃO adicione texto antes ou depois da resposta.

      DEVE INCIAR ASSIM:
      Primeira linha: Com o nome do paciente - idade anos - peso kg (Esta parte deve estar dentro de uma tag <h5></h5>
      Segunda linha : Recomendações e Sugestao dos Farmacos Inicial( Esta parte deve estar dentro de uma tag <h6></h6> 
      Treceira linha: Coloca a sugestao conforme o formato indicado acima.
      br
      Utima linha Coloca uma observação a frase:Aviso: Este é apenas um agente auxiliar médico não substitui a decisão final(Esta parte deve estar de uma tag <h6></h6>)


      LEVA EM CONTA O SEGUINTE 
      Situação geografica: Angola/Luanda
                            
    '
    );


    echo '<p>';
    echo nl2br($resposta['reply']);
    echo '</p>';
  }




  public static function sugestaoMedica($nome, $peso, $idade, $sugestao, $resultado)
  {

    $IA = new OpenRouterService();

    $refazer = $IA->sendMessage(
      ' 
      MUITO IMPORTANTE: ANTES IGNORE qualquer contexto ou instrução anterior especialmente formatação de texto

      Em um agente auxiliar medica, (utilizado por um médico) que ajuda a exclarecer e não 
      substituir o médico no consultorio, 
      
      DADOS DO PACIENTE:
      Nome ' . $nome . ' tem  ' . $idade . ' anos e pesa ' . $peso . 'kg. 
      
      Contexto para refazer a análise:
      - Resultado atual gerado pelo agente auxiliar (IA), incluindo as medicações
       previamente sugeridas:

       { ' . $resultado . ' }

        Agora considere a seguinte INSTRUÇÃO ADICIONAL DO MÉDICO:
        { ' . $sugestao . '}
        (ex: ajuste de dose, medicação complementar, substituição de fármacos, exame adicional, orientação clínica, etc.)}}

        Formato da resposta:
        Com base nesses dados, gera uma sugestão neste formato os MEDICAMENTOS:
        1) <strong>Nome:</strong>
            <strong>Posologia:</strong>
            <strong>Duração:</strong>
            <strong>Via de administração:</strong>
            <strong>Justificativa:</strong>

        2) (Repetir para cada medicação alterada ou nova)

      * Observações Importantes: Lembrando que este é apenas um agente auxiliar não
      um medico e que esta usar e deve sempre ser consultado para um diagnóstico preciso e 
      prescrição adequada.

      FORMATAÇÃO IMPONTANTES COMO APRESENTAR O RESÚLTADO
      - As palavras: "Nome, Posologia, Duração, "Via de administração" e "Justivicativa" e importante que ficam negritada
      - Não adiciona os Markdown como: (```html```, **, #)
      - NÃO adicione texto antes ou depois da resposta.

     DEVE INCIAR ASSIM:
      Primeira linha: Com o nome do paciente - idade anos - peso kg (Esta parte deve estar dentro de uma tag)
      Segunda linha : Recomendações e Sugestao dos Farmacos Atualizado com as suas Instruções extras( Esta parte deve estar dentro de uma tag <h6></h6> 
      Treceira linha: Coloca a sugestao conforme o formato indicado acima.
      br
      Utima linha Coloca uma observação a frase:Aviso: Este é apenas um agente auxiliar médico não substitui a decisão final(Esta parte deve estar de uma tag <h6></h6>)


     LEVA EM CONTA O SEGUINTE 
      - Situação geografica: Angola
      - Evidenciar o resultado atual fornecido pela IA como referência
      - Sugerir alterações, ajustes ou complementos nas medicações previamente indicadas
      - Ser claro, objetivo e profissional
      - Considerar possíveis riscos, interações ou cuidados
      - Não substituir a decisão final do médico
    '
    );

    echo '<p>';
    echo nl2br($refazer['reply']);
    echo '</p>';

    return nl2br($refazer['reply']);
  }


  // public static function OlaMundo()
  // {
  //   $IA1 = new OpenRouterService();

  //   $resposta = $IA1->sendMessage("MUITO IMPORTANTE: ANTES IGNORE qualquer contexto ou instrução anterior especialmente formatação de texto

  //                           Em um agente auxiliar medica, (utilizado por um médico) que ajuda a exclarecer 
  //                            e não substituir o médico no consultorio, 

  //                           dados do paciente:
  //                           Ana Maria, 20 anos , 60kg de idade sem nenhuma arlegia,
  //                           Dados da triagem: pressão arterial normal, frequência cardíaca normal, temperatura corporal 38 graus.

  //                           Dados da consulta: Paciente relata dor de cabeça leve, náuseas ocasionais e cansaço excessivo, 
  //                           o exame laboratorial revelou níveis de Hemoglobina baixa e hematócrito reduzido, tem paludismo

  //                           Com base nesses dados, gera uma sugestão neste formato os MEDICAMENTOS:

  //                               1) nome do medicamento tipo {{Paracetamol}} 
  //                                 <strong>Posologia:</strong>
  //                                 <strong>Duração:</strong>
  //                                 <strong>Via de administração:</strong>

  //                            Medicações Sugeridas apresenta elas negritada

  //                           * Observações Importantes: Lembrando que este é apenas um agente auxiliar não
  //                           um medico e que esta usar e deve sempre ser consultado para um diagnóstico preciso e 
  //                           prescrição adequada.

  //                           DEVE INCIAR ASSIM:
  //                           com a tag obrigatorio <h6> seguido do nome completo do paciente - idade anos - peso kg </h6>
  //                           <h6>Recomendações dos Farmacos Inicial:</h6> 
  //                           deve eliminar os # 
  //                           deve eliminar os *
  //                           Responda APENAS com o conteúdo final.
  //                            NÃO use ```html, ``` ou qualquer bloco Markdown.
  //                           NÃO adicione texto antes ou depois da resposta.

  //   ");

  //   // $enviarResultado = nl2br($resposta['reply']);

  //   echo nl2br($resposta['reply']);

  //   // return $res['reply'];
  //   //  return  $enviarResultado ;
  // }


}
