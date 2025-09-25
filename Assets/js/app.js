//navbar dropdown do menu dos usuario logado
document.addEventListener('DOMContentLoaded', function () {
  var drop = document.querySelectorAll('.dropdown-trigger');
  var instances = M.Dropdown.init(drop, {
    coverTrigger: false,
    closeOnClick: false,
    constrainWidth: false,
    alignment: 'left',
    closeOnClick: false // mantém aberto enquanto navega

  });
});


// aside Acordion
document.addEventListener('DOMContentLoaded', function () {
  var elemss = document.querySelectorAll('.collapsible');
  var instances = M.Collapsible.init(elemss, {
    accordion: true,
    inDuration: 600
  });
});


// form not Acordion 
document.addEventListener('DOMContentLoaded', function () {
  var elems1 = document.querySelectorAll('.collapsibleFrom');
  var instances = M.Collapsible.init(elems1, {
    accordion: false,
    inDuration: 100,
    outDuration: 100,
  });
});

// form not Acordion 
document.addEventListener('DOMContentLoaded', function () {
  var elems1 = document.querySelectorAll('.expandable');
  var instances = M.Collapsible.init(elems1, {
    accordion: false,
    inDuration: 100,
    outDuration: 100,
  });
});

document.addEventListener('DOMContentLoaded', function () {

  // Inicializa o collapsible expansível
  var expandable = document.querySelectorAll('.collapsible.expandable');
  M.Collapsible.init(expandable, {
    accordion: false
  });

});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//abas do painel de vendedor
document.addEventListener('DOMContentLoaded', function () {
  var tabs = document.querySelectorAll('.tabsvendedor');
  var instance = M.Tabs.init(tabs);

});

//abas home grafico admin
document.addEventListener('DOMContentLoaded', function () {
  var tabs = document.querySelectorAll('.tabsGraficos');
  var instance = M.Tabs.init(tabs);
});

//select tag
document.addEventListener('DOMContentLoaded', function () {
  var elemselect = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elemselect, {

  });
});

//imagem 
document.addEventListener('DOMContentLoaded', function () {
  var img = document.querySelectorAll('.materialboxed');
  var instances = M.Materialbox.init(img, {
    inDuration: 1000,
    outDuration: 400
  });
});

//mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm
document.addEventListener('DOMContentLoaded', function () {
  var elems = document.querySelectorAll('.dropdown-trigger3');
  var instances = M.Dropdown.init(elems, {
    inDuration: 1000
  });
});

//////////////////////////////////////////////////////////////////////////////////////////////////

// tooltip msg de trocar a foto
document.addEventListener('DOMContentLoaded', function () {
  var tollFoto = document.querySelectorAll('.tooltippedFoto');
  var instances = M.Tooltip.init(tollFoto, {
    exitDelay: 1,
    margin: -50
  });
});

// tooltip msg de listagem de botao
document.addEventListener('DOMContentLoaded', function () {
  var tollFoto1 = document.querySelectorAll('.tooltippedListagem');
  var instances = M.Tooltip.init(tollFoto1, {
    exitDelay: 1,

  });
});

//////////////////////////////////////////////////////////////////////////////////////////////////

//modal view apagar Usuario
document.addEventListener('DOMContentLoaded', function () {
  var apagarUsuario = document.querySelectorAll('.apagarUsuario ');
  var instancesModal = M.Modal.init(apagarUsuario, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '25%',
    startingTop: 10,
    preventScrolling: true,
  });
});

//modal view apagar Funcionario
document.addEventListener('DOMContentLoaded', function () {
  var apagarFuncionario = document.querySelectorAll('.apagarFuncionario ');
  var instancesModal = M.Modal.init(apagarFuncionario, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '25%',
    startingTop: 10,
    preventScrolling: true,

  });
});

//modal view de relatorio de vendedor kjkjkjk
document.addEventListener('DOMContentLoaded', function () {
  var relatorioVendedor = document.querySelectorAll('.modalRelatorio');
  var instancesModal = M.Modal.init(relatorioVendedor, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '27%',
    startingTop: 10,
  });
});

//modal view de relatorio de user
document.addEventListener('DOMContentLoaded', function () {
  var modalUser = document.querySelectorAll('.modaluser');
  var instancesModal = M.Modal.init(modalUser, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '50%',
    startingTop: 50,
  });
});

//modal view de relatorio Vendedor
document.addEventListener('DOMContentLoaded', function () {
  var modalvendedor = document.querySelectorAll('.modalvendedor');
  var instancesModal = M.Modal.init(modalvendedor, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '30%',
    startingTop: 50,
  });
});

//modal view apagar triagem
document.addEventListener('DOMContentLoaded', function () {
  var modalApagarTriagem = document.querySelectorAll('.modalApagarTriagem');
  var instancesModal = M.Modal.init(modalApagarTriagem, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '27%',
    startingTop: 10,
  });
});

//modal view imprimir triagem
document.addEventListener('DOMContentLoaded', function () {
  var modalImprimirTriagem = document.querySelectorAll('.modalImprimirTriagem');
  var instancesModal = M.Modal.init(modalImprimirTriagem, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '27%',
    startingTop: 10,
  });
});

//modal view de relatorio da zona
document.addEventListener('DOMContentLoaded', function () {
  var modalzona = document.querySelectorAll('.modalzona');
  var instancesModal = M.Modal.init(modalzona, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '27%',
    startingTop: 10,
  });
});

//modal consulta
document.addEventListener('DOMContentLoaded', function () {
  var modalConsultas = document.querySelectorAll('.modalConsultas');
  var instancesModal = M.Modal.init(modalConsultas, {
    preventScrolling: false,
    opacity: 0.75,
    endingTop: '27%',
    startingTop: 10,
  });
});

//modal alterar senha
document.addEventListener('DOMContentLoaded', function () {
  var modalMudarSenha = document.querySelectorAll('.modalMudarSenha');
  var instancesModal = M.Modal.init(modalMudarSenha, {
    opacity: 0.80,
    startingTop: 5,
    endingTop: '5%',
    //  onCloseStart: function () {
    //console.log("O modal está começando a fechar.");
    // Você pode executar outras ações aqui:
    // alert("Fechando o modal!");
    //},
  });
});

//modal alterar imagem
document.addEventListener('DOMContentLoaded', function () {
  var modalMudarimagem = document.querySelectorAll('.modalMudarImagem');
  var instancesModal = M.Modal.init(modalMudarimagem, {
    opacity: 0.80,
    startingTop: 5,
    endingTop: '5%',
  });
});

//modal alterar Edita dados
document.addEventListener('DOMContentLoaded', function () {
  var modalMudarEdit = document.querySelectorAll('.modalMudarEdit');
  var instancesModal = M.Modal.init(modalMudarEdit, {
    opacity: 0.80,
    startingTop: 5,
    endingTop: '5%',
  });
});


//////////////////////////////////////////////////////////////////////////////////////////////////

// Calendario datepicher
document.addEventListener('DOMContentLoaded', function () {
  var data = document.querySelectorAll('.datepicker');
  var instances = M.Datepicker.init(data, {
    autoClose: true,
    format: 'yyyy/mm/dd',
    showClearBtn: true,
  });
});

// texto areia
document.addEventListener('DOMContentLoaded', function () {
  var elems = document.querySelectorAll('input[data-length], textarea');
  M.CharacterCounter.init(elems);
});

// Cria tooltips com base no atributo data-tooltip
document.querySelectorAll('.tooltip-btn').forEach(btn => {
  const texto = btn.getAttribute('data-tooltip');
  const tooltipDiv = document.createElement('div');
  tooltipDiv.className = 'tooltip-text';
  tooltipDiv.textContent = texto;
  btn.parentElement.appendChild(tooltipDiv);
});

// Cria tooltips com base no atributo data-tooltip
document.querySelectorAll('.my-tooltip').forEach(btn => {
  const texto = btn.getAttribute('data-tooltip');
  const tooltipDiv = document.createElement('div');
  tooltipDiv.className = 'tooltip-text';
  tooltipDiv.textContent = texto;
  btn.parentElement.appendChild(tooltipDiv);
});
