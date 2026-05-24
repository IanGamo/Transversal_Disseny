$(document).ready(function () {

    // ── LÓGICA COOKIES 
    var cookiesAceptadas = localStorage.getItem('cookiesAceptadas');

    function mostrarLogin() {
        $('#login-form-wrapper').show();
        $('#btn-show-cookies').hide();
    }

    function ocultarLogin() {
        $('#login-form-wrapper').hide();
        $('#btn-show-cookies').show();
    }

    // Si ya aceptó → ocultar banner y mostrar login directamente
    if (cookiesAceptadas === 'true') {
        $('#cookie-banner').hide();
        mostrarLogin();

    // Si rechazó → ocultar banner pero bloquear login
    } else if (cookiesAceptadas === 'false') {
        $('#cookie-banner').hide();
        ocultarLogin();

    // Si no ha decidido → ocultar login hasta que decida
    } else {
        ocultarLogin();
    }

    // Aceptar cookies
    $('#btn-accept').on('click', function () {
        localStorage.setItem('cookiesAceptadas', 'true');
        $('#cookie-banner').slideUp(300);
        mostrarLogin();
    });

    // Rechazar cookies
    $('#btn-reject').on('click', function () {
        localStorage.setItem('cookiesAceptadas', 'false');
        $('#cookie-banner').slideUp(300);
        ocultarLogin();
    });

    // Botón para volver a ver el aviso
    $('#btn-show-cookies').on('click', function () {
        $('#cookie-banner').slideDown(300);
    });

});