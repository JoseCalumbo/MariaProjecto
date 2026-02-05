window.onload = function () {

    var btn = document.querySelector("#user")
    var div = document.querySelector("#div-user")
    var box = document.querySelector("#box")


    btn.onclick = function () {

        xmlHttpGeT('ajax/user', function () {

            beforeSend(function () {
                div.innerHTML = `<i class="fa fa-spinner fa-pulse fa-3x fa-fw text-green"></i>`
            })

            sucesso(function () {

                console.log(xhttp.responseText);

                var user = JSON.parse(xhttp.responseText);

                var table = `<table border="1">`
                table += `<thead>
                                <tr>
                                    <td>ID</td>
                                    <td>nome</td>
                                    <td>genero</td>
                                    <td>email</td>
                                    <td>Morada</td>
                                </tr>
                            </thead>`

                table += `<tbody>`
                user.forEach(function (users) {

                    table += `<tr>`

                    table += `<td>${users.id_paciente}</td>`
                    table += `<td>${users.nome_paciente}</td>`
                    table += `<td>${users.genero_paciente}</td>`
                    table += `<td>${users.email_paciente}</td>`
                    table += `<td>${users.morada_paciente}</td>`
                    table += `</tr>`

                });

                table += `</tbody>`

                table += `</table>`

                div.innerHTML = table;
            })

            error(function () {

                div.innerHTML = `<p class="text-red">Erro na requisição</p>`
            });

        },);



    }
}