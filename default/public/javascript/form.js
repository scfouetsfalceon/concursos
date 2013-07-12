// Validar campo númerico y de tipo local
function numericoPrefijo(objecto, prefijo, mensaje) {
    objecto.on('keyup', function(){
        if( this.value.length >= 2 ){
            if ( this.value.substr(0,2) != prefijo )  {
                this.value = '';
                alertPopup(mensaje);
            } else {
                this.value = this.value.replace(/[^0-9]/g,'');
            }
        } else {
            this.value = this.value.replace(/[^0-9]/g,'');
        }
    });

    objecto.on('blur', function(){
        var text = $(this).val();
        if ( text.length === 0 ){
            $(this).removeClass('box_error');
        } else
            if ( text.length >= 2 && text.length < 11 ) {
                $(this).addClass('box_error').focus();
                alertPopup(mensaje);
            } else {
                $(this).removeClass('box_error');
            }

    });
}

/**
* Plugin de JQuery para mostrar mensajes de alert
* Estilos del Bootstrap de Twitter
*
* @param String mensaje
* @param Object opciones
*/
$.fn.alertMsj = function (mensaje, opciones) {
    var settings = $.extend({
        tipo: 'alert',
        autocerrar: true,
        tiempo: 5000
    }, opciones );

    if ( settings.tipo != 'alert' ) {
        $(this).removeClass('alert-error alert-info alert-success').addClass('alert-'+settings.tipo);
    }

    $(this).fadeOut().empty().html(mensaje).fadeIn('slow');

    if (settings.autocerrar) {
        $(this).delay(settings.tiempo).fadeOut('slow');
    }
};

/**
* Plugin de JQuery para mostrar mensajes de success
* Estilos del Bootstrap de Twitter
*
* @param String mensaje
* @param Object opciones
*/
$.fn.sucessMsj = function (mensaje, opciones){
    var settings = $.extend({
        tipo: 'success',
        autocerrar: true,
        tiempo: 5000
    }, opciones );

    $(this).alertMsj(mensaje, settings);
};

/**
* Plugin de JQuery para mostrar mensajes de info
* Estilos del Bootstrap de Twitter
*
* @param String mensaje
* @param Object opciones
*/
$.fn.infoMsj = function (mensaje, opciones){
    var settings = $.extend({
        tipo: 'info',
        autocerrar: true,
        tiempo: 5000
    }, opciones );

    $(this).alertMsj(mensaje, settings);
};

/**
* Plugin de JQuery para mostrar mensajes de error
* Estilos del Bootstrap de Twitter
*
* @param String mensaje
* @param Object opciones
*/
$.fn.errorMsj = function(mensaje, opciones) {
    var settings = $.extend({
        tipo: 'error',
        autocerrar: true,
        tiempo: 5000
    }, opciones );
    $(this).alertMsj(mensaje, settings);
};

/**
* Plugin de JQuery para campos solo númericos
*
*/
$.fn.numerico = function() {
    $(this).on('keyup', function () {
        if ( this.value.substr(0,1) === 0 )  {
                this.value = '';
            } else {
                this.value = this.value.replace(/[^0-9]/g,'');
        }
    });
};

/**
* Plugin de JQuery para campos telefónicos
* números locales (Venezuela)
*
*/
$.fn.telefono = function() {
    numericoPrefijo(this, '02', "Esto no es un teléfono de habitación válido<br/>Si desea puede dejar el campo vacío");
};

/**
* Plugin de JQuery para campos telefónicos
* números celular(Venezuela)
*
*/
$.fn.celular = function () {
    numericoPrefijo(this, '04', "Esto no es un teléfono de celular válido<br/>Si desea puede dejar el campo vacío");
};

$.fn.requerido = function () {
    $(this).on('blur', function(){
        var text = $(this).val();
        if ( text.length === 0 ) {
            $(this).next('.help-block').remove();
            $(this).parent().parent().removeClass('error');
            $(this).after('<span class="help-block">Este campo es obligatorio</span>');
            $(this).parent().parent().addClass('error');
            $(this).focus();
        } else {
            $(this).next('.help-block').remove();
            $(this).parent().parent().removeClass('error');
        }
    });
};

/**
* Plugin de JQuery para campos correos
* electrónicos
*
*/
$.fn.correo = function() {
    $(this).on('blur', function(){
        var text = $(this).val();
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( text ) || text.length === 0 ) {
            $(this).removeClass('box_error');
        } else {
            $(this).addClass('box_error').focus();
            alertPopup("Este correo inválido");
        }
    });
};

$.fn.clearSelect = function() {
    $(this).empty();
    $(this).append( new Option('--', '') );
};

$.fn.loadSelect = function() {
    $(this).empty();
    $(this).append( new Option("Cargando...", "") );
};

jQuery.browser = {};
jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());

$(document).ready(function(){
//  var f = new Date(), ano = f.getFullYear();
//     $('input[type="date"]').datepicker({
//      dateFormat: 'dd/mm/yy',
//      changeMonth: true,
//      changeYear: true,
//      yearRange: String(ano - 100) + ':' + String(ano)
//  });
    $('input[class~="req"]').requerido();
    $('input[type="email"]').correo();
    $('input[type="number"]').numerico();
    $('input[type="tel"][data-type="local"]').telefono();
    $('input[type="tel"][data-type="celular"]').celular();
    $('input[type="date"]').datepicker({language: 'es'});
});