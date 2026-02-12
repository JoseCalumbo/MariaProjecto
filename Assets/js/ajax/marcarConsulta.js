window.onload = function () {

  var btnVerHorario = document.querySelector("#horario")
  var resultadoia = document.querySelector("#resultadoIA")

  const nomePaciente = document.getElementById('nomePaciente').value;
  const telefone = document.getElementById('telefone').value.trim();
  const especialidade = document.getElementById('especialidade').value;
  const data = document.getElementById('dataConsulta').value;

  var xhttp = new XMLHttpRequest()

  // Definir data mínima como hoje
  const hoje = new Date().toISOString().split('T')[0];
  document.getElementById('dataConsulta').setAttribute('min', hoje);


  btnVerHorario.onclick = function () {

    console.log(telefone);


    // Validação básica
    if (!nomePaciente) {
      M.toast({ html: '⚠️ Selecione um paciente', classes: 'orange' });
      return;
    }

    if (!telefone) {
      M.toast({ html: '⚠️ Informe o telefone', classes: 'orange' });
      return;
    }

    if (!especialidade || !data) {
      M.toast({ html: '⚠️ Selecione uma especialidade ee data', classes: 'orange' });
      return;
    }
    console.log("aqui");

    xhttp.onreadystatechange = function () {

      if (xhttp.readyState == 4 && xhttp.status == 200) {

        console.log(xhttp.responseText);
      }
    }

    xhttp.open('GET', '/MariaProjecto/public/ajax/consulta.php?action=horario', true)
    xhttp.send();
  }
}

