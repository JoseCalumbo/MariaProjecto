document.addEventListener('DOMContentLoaded', function () {

  /* ===================== DROPDOWNS ===================== */
  M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'), {
    coverTrigger: false,
    closeOnClick: false,
    constrainWidth: false,
    alignment: 'left'
  });

  M.Dropdown.init(document.querySelectorAll('.dropdown-trigger3'), {
    inDuration: 1000
  });


  /* ===================== SIDENAV ===================== */
  M.Sidenav.init(document.querySelectorAll('.sidenav'));


  /* ===================== COLLAPSIBLE ===================== */
  // Aside accordion
  M.Collapsible.init(document.querySelectorAll('.collapsible.expandable'), {
    accordion: true,
    inDuration: 600
  });

  // Form não accordion
  M.Collapsible.init(document.querySelectorAll('.expandable'), {
    accordion: false,
    inDuration: 100,
    outDuration: 100
  });


  /* ===================== TABS ===================== */
  M.Tabs.init(document.querySelectorAll('.tabsvendedor'));
  M.Tabs.init(document.querySelectorAll('.tabsGraficos'));


  /* ===================== SELECT ===================== */
  M.FormSelect.init(document.querySelectorAll('select'));


  /* ===================== IMAGEM ===================== */
  M.Materialbox.init(document.querySelectorAll('.materialboxed'), {
    inDuration: 1000,
    outDuration: 400
  });


  /* ===================== TOOLTIPS ===================== */
  M.Tooltip.init(document.querySelectorAll('.tooltippedFoto'), {
    exitDelay: 1,
    margin: -50
  });

  M.Tooltip.init(document.querySelectorAll('.tooltippedListagem'), {
    exitDelay: 1
  });


  /* ===================== MODAIS ===================== */
  const modalConfig = {
    opacity: 0.75,
    startingTop: 10,
    preventScrolling: false
  };

  M.Modal.init(document.querySelectorAll('.apagarUsuario, .apagarFuncionario'), {
    ...modalConfig,
    endingTop: '25%',
    preventScrolling: true
  });

  M.Modal.init(document.querySelectorAll('.modalRelatorio'), {
    ...modalConfig,
    endingTop: '27%'
  });

  M.Modal.init(document.querySelectorAll('.modaluser'), {
    ...modalConfig,
    endingTop: '50%',
    startingTop: 50
  });

  M.Modal.init(document.querySelectorAll('.modalvendedor'), {
    ...modalConfig,
    endingTop: '30%',
    startingTop: 50
  });

  M.Modal.init(document.querySelectorAll('.modalApagarTriagem, .modalImprimirTriagem, .modalImprimirTriagem1, .modalzona, .modalConsultas'), {
    ...modalConfig,
    endingTop: '27%'
  });

  M.Modal.init(document.querySelectorAll('.modalChat'), {
    opacity: 0.10,
    startingTop: 0,
    endingTop: '7%',
    dismissible: false
  });

  M.Modal.init(document.querySelectorAll('.modalMudarSenha, .modalMudarImagem, .modalMudarEdit'), {
    opacity: 0.80,
    startingTop: 5,
    endingTop: '5%'
  });


  /* ===================== DATE & TIME ===================== */
  M.Datepicker.init(document.querySelectorAll('.datepicker'), {
    autoClose: true,
    format: 'yyyy/mm/dd',
    showClearBtn: true
  });

  M.Timepicker.init(document.querySelectorAll('.timepicker'), {
    twelveHour: false,
    autoClose: true,
    vibrate: true,
    defaultTime: 'now',
    i18n: {
      cancel: 'Cancelar',
      clear: 'Limpar',
      done: 'OK'
    }
  });


  /* ===================== CHARACTER COUNTER ===================== */
  M.CharacterCounter.init(document.querySelectorAll('input[data-length], textarea'));


  /* ===================== TOOLTIPS CUSTOM ===================== */
  document.querySelectorAll('.tooltip-btn, .my-tooltip').forEach(btn => {
    const texto = btn.getAttribute('data-tooltip');
    if (!texto) return;

    const tooltipDiv = document.createElement('div');
    tooltipDiv.className = 'tooltip-text';
    tooltipDiv.textContent = texto;
    btn.parentElement.appendChild(tooltipDiv);
  });

});
