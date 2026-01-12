<?php

namespace App\Controller\Pages;

require_once __DIR__ . '/../../Utils/OpenRouterService.php';



use \App\Utils\View;
use \App\Utils\ConsultaMedica;
use \App\Utils\OpenRouterService;
use \App\Utils\OpenRouterService3;

class Prescrisao extends Page
{

  // Metodo para gerar a pescrisao
  public static function getTelaGeradorReceita($request, $id_consulta)
  {

    // $resposta = $consulta->analisarPaciente($dados);

    $content = View::render('ReceitaLayouts/contem', [
      // 'dados' => $resposta,
    ]);
    return parent::getPageReceita('Geradar de consulta', $content);
  }

  public static function OlaMundo()
  {
    $IA1 = new OpenRouterService();

    $res = $IA1->sendMessage("Em um agente auxiliar medica, (utilizado por um médico) que ajuda a exclarecer e não substituir
                             o médico no consultorio, 

                            dados do paciente:
                            Ana Maria, 20 anos de idade sem nenhuma arlegia,
                            Dados da triagem: pressão arterial normal, frequência cardíaca normal, temperatura corporal 38 graus.
                            
                            Dados da consulta: Paciente relata dor de cabeça leve, náuseas ocasionais e cansaço excessivo, 
                            o exame laboratorial revelou níveis de Hemoglobina baixa e hematócrito reduzido, tem paludismo

                            Com base nesses dados, gera uma sugestão neste formato os MEDICAMENTOS:

                                1) nome do medicamento tipo {{Paracetamol}} 
                                   Posologia
                                   Duração
                                   Via de administração
                            
                             Medicações Sugeridas apresenta elas negritada

                            * Observações Importantes: Lembrando que este é apenas um agente auxiliar nã
                            o medico e que esta usar e deve sempre ser consultado para um diagnóstico preciso e prescrição adequada.

                            DEVE INCIAR ASSIM:
                            <h4> seguido do nome completo do paciente - idade anos - peso kg </h4>
                            <h6>💊 Recomendações dos Farmacos:</h6> 
                            deve eliminar os # 
                            deve eliminar os *
                            
    ");

    $enviarResultado = nl2br($res['reply']);
    
    echo '<p>';
    echo nl2br($res['reply']);
    echo '</p>';

    // return $res['reply'];
    return  $enviarResultado ;
  }


  public static function sugestaoMedica($sugestao, $resultado)
  {
    $IA = new OpenRouterService();
    
    $refazer = $IA->sendMessage(
     ' 
      Você é um agente auxiliar médico, utilizado exclusivamente como apoio ao médico,
      com a finalidade de sugerir recomendações clínicas complementares,
      sem substituir a avaliação, o diagnóstico ou a prescrição médica.

      Contexto para análise:
      - Dados do paciente:Ana Maria, 20 anos de idade
      - Resultado atual gerado pelo agente auxiliar (IA), incluindo as medicações previamente sugeridas:

       { '.$resultado.' }

        Agora considere a seguinte INSTRUÇÃO ADICIONAL DO MÉDICO:
        {{ '.$sugestao.'
        (ex: ajuste de dose, medicação complementar, substituição de fármacos, exame adicional, orientação clínica, etc.)}}

        Com base nisso, gere uma RECOMENDAÇÃO MÉDICA AUXILIAR ATUALIZADA,
        seguindo rigorosamente o formato abaixo:

        DEVE INICIAR EXATAMENTE ASSIM:
        <h4>Nome completo do paciente - idade anos - peso kg</h4>
        <h6>🩺 Recomendações Médicas Atualizadas:</h6>

        O conteúdo deve:
        - Evidenciar o resultado atual fornecido pela IA como referência
        - Sugerir alterações, ajustes ou complementos nas medicações previamente indicadas
        - Ser claro, objetivo e profissional
        - Considerar possíveis riscos, interações ou cuidados
        - Não substituir a decisão final do médico

        Formato da resposta:
        1) Nome do medicamento (em negrito)
          Posologia
          Duração
          Via de administração
          Justificativa clínica para alteração ou manutenção

        2) (Repetir para cada medicação alterada ou nova)

        Observações Importantes:
        Este conteúdo é apenas um apoio clínico auxiliar,
        destinado exclusivamente ao médico,
        não substituindo o julgamento clínico,
        nem a prescrição médica formal.

        ');

    echo '<p>';
    echo nl2br($refazer['reply']);
    echo '</p>';

    return nl2br($refazer['reply']);

  }

  public function olaMundo2()
  {
    $consulta = new ConsultaMedica();
    $dados = "Paciente 20 anos, 60kg, febre 38ºC — qual medicamento usar?";
    $resposta = $consulta->analisarPaciente($dados);
    echo json_decode($resposta);
  }
}
