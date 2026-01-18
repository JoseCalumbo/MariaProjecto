<?php

namespace App\Controller\Pages;

require_once __DIR__ . '/../../Utils/OpenRouterService.php';

use \App\Utils\View;
use \App\Utils\ConsultaMedica;
use \App\Utils\OpenRouterService;
use \App\Utils\OpenRouterService3;
use App\Model\Entity\ConsultaDao;
use App\Model\Entity\MedicamentoDao;
use App\Model\Entity\TriagemDao;
use App\Model\Entity\MedicamentoDaoDao;

class Prescrisao extends Page
{

    // busca todos os exames para o select dos exames 
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


  // Método para gerar a pescrisao
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
