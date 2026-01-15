
window.onload = function () {


  var btnGerar = document.querySelector("#btnAnalisar");
  var btnRefazer = document.querySelector("#btnRefazer");
  var resultadoIA = document.querySelector("#resultadoIA");
  var loading = document.getElementById('loadingIA');
  var formRefazer = document.getElementById('addSugestaoMedica');

  let xhttp = null;


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

    // ✅ AQUI está o dado que faltava
    form.append('resultadoAtual', resultadoAtual);

    xmlHttpPost('/AntigoMaria/public/ajax/create', function () {

      beforeSend(function () {
        loading.classList.add('active');
        // Coloca a resposta dentro do div
        resultadoIA.innerHTML = xhttp1.responseText;
      })

      sucesso(function () {
        console.log(xhttp1.responseText);
        M.toast({ html: '✅ Análise refeita concluída com sucesso', classes: 'green' });
      })

      if (this.readyState == 4) {
        loading.classList.remove('active');
      }

    }, form)

  }

  // gerar a primeira vez
  btnGerar.onclick = function () {

      if (!validarFormulario()) {
        M.toast({ html: '⚠️ Preencha todos os campos obrigatórios corretamente', classes: 'red' });
        console.log("preenche os campos necessarios para continuar");
        return;
      }

    xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
      if (this.readyState < 4) {
        loading.classList.add('active');
      }

      if (xhttp.readyState == 4 && xhttp.status == 200) {

        console.log("Resposta do PHP 2:", xhttp.responseText);

        // Coloca a resposta dentro do div
        resultadoIA.innerHTML = xhttp.responseText;
        M.toast({ html: '✅ Análise concluída com sucesso!', classes: 'green' });
      }

      if (this.readyState == 4) {
        loading.classList.remove('active');
      }
    };

    // Ajuste a URL conforme seu arquivo PHP
    xhttp.open('GET', '/AntigoMaria/public/ajax/user.php?action=OlaMundo', true);
    xhttp.send();
  }


}
