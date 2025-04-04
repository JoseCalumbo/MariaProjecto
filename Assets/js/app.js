//navbar dropdown do menu dos usuario logado
document.addEventListener('DOMContentLoaded', function () {
  var drop = document.querySelectorAll('.dropdown-trigger');
  var instances = M.Dropdown.init(drop, {
    coverTrigger: false,
    closeOnClick: false
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
  var elems = document.querySelectorAll('.collapsible');
  var instances = M.Collapsible.init(elems, {
    accordion: false,
    inDuration: 800
  });
});


//abas do painel de vendedor
document.addEventListener('DOMContentLoaded', function () {
  var tabs = document.querySelectorAll('.tabsvendedor');

  var instance = M.Tabs.init(tabs);

});

//select tag
document.addEventListener('DOMContentLoaded', function() {
  var elemselect = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elemselect, {
    
  });
});

//imagem 
document.addEventListener('DOMContentLoaded', function() {
  var img = document.querySelectorAll('.materialboxed');
  var instances = M.Materialbox.init(img,{
      inDuration:1000,
      outDuration:400
    });
});


// tooltip msg de trocar a foto
document.addEventListener('DOMContentLoaded', function() {
var tollFoto = document.querySelectorAll('.tooltippedFoto');
var instances = M.Tooltip.init(tollFoto, {
    exitDelay:1,
    margin:-50
  });
});


//modal apagar user
document.addEventListener('DOMContentLoaded', function() {
  var apagarUser = document.querySelectorAll('.apagarUser');
  var instances = M.Modal.init(apagarUser);
});

//modal view de relatorio de vendedor
document.addEventListener('DOMContentLoaded', function() {
  var relatorioVendedor = document.querySelectorAll('.modal');
  var instancesModal = M.Modal.init(relatorioVendedor,{
    preventScrolling:false,
    opacity:0.75,
    endingTop:'27%',
    startingTop:10,
  });
});

//modal view de relatorio de user
document.addEventListener('DOMContentLoaded', function() {
  var modalUser = document.querySelectorAll('.modaluser');
  var instancesModal = M.Modal.init(modalUser,{
    preventScrolling:false,
    opacity:0.75,
    endingTop:'27%',
    startingTop:10,
  });
});
//modal view apagar triagem
document.addEventListener('DOMContentLoaded', function() {
  var modalUser = document.querySelectorAll('.modalApagarTriagem');
  var instancesModal = M.Modal.init(modalUser,{
    preventScrolling:false,
    opacity:0.75,
    endingTop:'27%',
    startingTop:10,
  });
});

//modal view de relatorio da zona
document.addEventListener('DOMContentLoaded', function() {
  var modalzona = document.querySelectorAll('.modalzona');
  var instancesModal = M.Modal.init(modalzona,{
    preventScrolling:false,
    opacity:0.75,
    endingTop:'27%',
    startingTop:10,
  });
});

//modal consulta
document.addEventListener('DOMContentLoaded', function() {
  var modalzona = document.querySelectorAll('.modalConsultas');
  var instancesModal = M.Modal.init(modalzona,{
    preventScrolling:false,
    opacity:0.75,
    endingTop:'27%',
    startingTop:10,
  });
});

// Calendario datepicher
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.datepicker');
  var instances = M.Datepicker.init(elems, options);
});

// Or with jQuery

$(document).ready(function(){
  $('.datepicker').datepicker();
});

  
  // modal
  // document.addEventListener('DOMContentLoaded', function() {
  //   var elems1 = document.querySelectorAll('.meumodal11');
  //   var instances = M.Modal.init(elems1,{
  //      opacity:1,
  //      inDuration:1000,
  //      outDuration:800,
  //      //so fecha no botao
  //      dismissible:false,
  //      // inicio fim
  //      endingTop:50,
  //      startingTop:30,
  //      //sem scroll
  //      preventScrolling:false
  //   });
  // });