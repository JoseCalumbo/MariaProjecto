var xhttp1 = new XMLHttpRequest;

function xmlHttpGeT(url, collback, parametro = '') {
    xhttp1.onreadystatechange = collback
    xhttp1.open('GET', url + '.php' + parametro, true);
    xhttp1.send();

}

function xmlHttpPost(url, collback, parametro = '') {
    xhttp1.onreadystatechange = collback
    xhttp1.open('POST', url + '.php', true);
    xhttp1.send(parametro);
}

function beforeSend(collback) {
    if (xhttp1.readyState < 4) {
        collback();
    }
}

function sucesso(collback) {
    if (xhttp1.readyState == 4 && xhttp1.status == 200) {
        collback();
    }
}


function error(collback) {
    xhttp1.onerror = collback

}
