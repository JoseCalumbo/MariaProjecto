
window.onload = function () {

  var btnGerar = document.querySelector("#btnAnalisar");
  var btnRefazer = document.querySelector("#btnRefazer");
  var resultadoIA = document.querySelector("#resultadoIA");
  var loading = document.getElementById('loadingIA');
  //form
  var formRefazer = document.getElementById('addSugestaoMedica');
  var formAnalizar = document.getElementById('formPaciente');

  var nome = document.querySelector('input[name="nome"]').value;
  var peso = document.querySelector('input[name="peso"]').value;
  var idade = document.querySelector('input[name="idade"]').value;


  let xhttp = null;


  //ANALIZAR E SUGERIR MEDICAMENTO COM IA
  formAnalizar.onsubmit = function (event) {

    //evita que a pagina  seja carregada
    event.preventDefault();    

    // validar formulario
    if (!validarFormulario()) {
      M.toast({ html: '⚠️ Preencha todos os campos obrigatórios corretamente', classes: 'red' });
      console.log("preenche os campos necessarios para continuar");
      return;
    }

    const formData = new FormData(formPaciente);

    loading.classList.add('active');

    xmlHttpPost('/MariaProjecto/public/ajax/analiza', function () {

      beforeSend(function () {
        loading.classList.add('active');
        // Coloca a resposta dentro do div
        resultadoIA.innerHTML = xhttp1.responseText;
      })

      sucesso(function () {
        console.log("RESPOSTA FEITA",xhttp1.responseText);
        M.toast({ html: '✅ Análise concluída com sucesso', classes: 'green' });
      })

      if (this.readyState == 4) {
        loading.classList.remove('active');
      }

    }, formData)

  }




  // REFAZER ANALISÉ COM BASE NA SUGESTÃO MÉDICA
  formRefazer.onsubmit = function (event) {

    // evita que a pagina  seja carregada
    event.preventDefault();

    const promptAdicional = document.getElementById('promptAdicional').value.trim();
    if (!promptAdicional) {
      M.toast({ html: '⚠️ Digite instruções adicionais no campo de prompt', classes: 'orange' });
      return;
    }

    // Verificar se já existe uma análise
    const resultadoAtual = document.getElementById('resultadoIA').innerHTML;
    if (resultadoAtual.includes('<em>')) {
      M.toast({ html: '⚠️ Faça a análise inicial primeiro', classes: 'orange' });
      return;
    }

    var form = new FormData(formRefazer);    

    //Envia o resultado para o formulario
    form.append('resultadoAtual', resultadoAtual);
    form.append('nomePaciente', nome);
    form.append('pesoPaciente', peso);
    form.append('idadePaciente', idade);

    xmlHttpPost('/MariaProjecto/public/ajax/sugestao', function () {
      
      beforeSend(function () {
        loading.classList.add('active');
        // Coloca a resposta dentro do div
        resultadoIA.innerHTML = xhttp1.responseText;
      })

      sucesso(function () {
        console.log("RESPOSTA REFEITA",xhttp1.responseText);
        M.toast({ html: '✅ Análise refeita concluída com sucesso', classes: 'green' });
      })

      if (this.readyState == 4) {
        loading.classList.remove('active');
      }

    }, form)

  }



  // gerar a primeira vez
  // btnGerar.onclick = function () {

  //   if (!validarFormulario()) {
  //     M.toast({ html: '⚠️ Preencha todos os campos obrigatórios corretamente', classes: 'red' });
  //     console.log("preenche os campos necessarios para continuar");
  //     return;
  //   }

  //   xhttp = new XMLHttpRequest();

  //   xhttp.onreadystatechange = function () {
  //     if (this.readyState < 4) {
  //       loading.classList.add('active');
  //     }

  //     if (xhttp.readyState == 4 && xhttp.status == 200) {

  //       console.log("Resposta do PHP 2:", xhttp.responseText);

  //       // Coloca a resposta dentro do div
  //       resultadoIA.innerHTML = xhttp.responseText;
  //       M.toast({ html: '✅ Análise concluída com sucesso!', classes: 'green' });
  //     }

  //     if (this.readyState == 4) {
  //       loading.classList.remove('active');
  //     }
  //   };

  //   // Ajuste a URL conforme seu arquivo PHP
  //   xhttp.open('GET', '/AntigoMaria/public/ajax/user.php?action=OlaMundo', true);
  //   xhttp.send();
  // }



}
