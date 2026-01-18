// ===============================
// CRIADOR DE XMLHttpRequest
// ===============================
function criarXHR(callback) {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                callback(null, xhr.responseText);
            } else {
                callback(`Erro HTTP: ${xhr.status}`, null);
            }
        }
    };

    xhr.onerror = function () {
        callback('Erro de rede', null);
    };

    return xhr;
}

// ===============================
// GET
// ===============================
function ajaxGet(url, callback, params = '') {
    const xhr = criarXHR(callback);
    xhr.open('GET', url + '.php' + params, true);
    xhr.send();
}

// ===============================
// POST
// ===============================
function ajaxPost(url, callback, dados) {
    const xhr = criarXHR(callback);
    xhr.open('POST', url + '.php', true);

    // ⚠️ Se for FormData, NÃO definir Content-Type
    xhr.send(dados);
}
