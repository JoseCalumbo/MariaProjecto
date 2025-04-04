
var modal = document.querySelector('.modal')

// opem modal user 
let abrirModal = document.querySelector('.openModal')

var fecharModal = document.querySelector('#closeModal')


// metodo opem modal user
abrirModal.addEventListener('click',abrir)


fecharModal.addEventListener('click',fechaModal)


function abrir(){
    modal.style.display = "block";
}

// metodo para fechar um modal
function fechaModal(){
     modal.style.display = "none";
}
