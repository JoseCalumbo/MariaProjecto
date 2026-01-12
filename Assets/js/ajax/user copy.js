window.onload = function () {

  var btnGerar = document.querySelector("#btnAnalisar")
  var resultadoia = document.querySelector("#resultadoIA")

  var xhttp = new XMLHttpRequest()


  btnGerar.onclick = function () {
    console.log("aqui");
    console.log(resultadoIA);

    xhttp.onreadystatechange = function () {

      if (xhttp.readyState == 4 && xhttp.status == 200) {

        console.log(xhttp.responseText);

      }
    }

    xhttp.open('GET', '/AntigoMaria/public/ajax/user.php?action=OlaMundo2', true)
    xhttp.send();

  }
}

