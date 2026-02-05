window.onload = function () {

  var btnVerHorario = document.querySelector("#horario")
  var resultadoia = document.querySelector("#resultadoIA")

  var xhttp = new XMLHttpRequest()


  btnVerHorario.onclick = function () {
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

