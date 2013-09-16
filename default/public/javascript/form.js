var validate = true;

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
        var text = jQuery(this).val();
        if ( text.length === 0 ){
            jQuery(this).removeClass('box_error');
        } else
            if ( text.length >= 2 && text.length < 11 ) {
                jQuery(this).addClass('box_error').focus();
                alertPopup(mensaje);
            } else {
                jQuery(this).removeClass('box_error');
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
jQuery.fn.alertMsj = function (mensaje, opciones) {
    var settings = jQuery.extend({
        tipo: 'alert',
        autocerrar: true,
        tiempo: 5000
    }, opciones );

    if ( settings.tipo != 'alert' ) {
        jQuery(this).removeClass('alert-error alert-info alert-success').addClass('alert-'+settings.tipo);
    }

    jQuery(this).fadeOut().empty().html(mensaje).fadeIn('slow');

    if (settings.autocerrar) {
        jQuery(this).delay(settings.tiempo).fadeOut('slow');
    }
};

/**
* Plugin de JQuery para mostrar mensajes de success
* Estilos del Bootstrap de Twitter
*
* @param String mensaje
* @param Object opciones
*/
jQuery.fn.sucessMsj = function (mensaje, opciones){
    var settings = jQuery.extend({
        tipo: 'success',
        autocerrar: true,
        tiempo: 5000
    }, opciones );

    jQuery(this).alertMsj(mensaje, settings);
};

/**
* Plugin de JQuery para mostrar mensajes de info
* Estilos del Bootstrap de Twitter
*
* @param String mensaje
* @param Object opciones
*/
jQuery.fn.infoMsj = function (mensaje, opciones){
    var settings = jQuery.extend({
        tipo: 'info',
        autocerrar: true,
        tiempo: 5000
    }, opciones );

    jQuery(this).alertMsj(mensaje, settings);
};

/**
* Plugin de JQuery para mostrar mensajes de error
* Estilos del Bootstrap de Twitter
*
* @param String mensaje
* @param Object opciones
*/
jQuery.fn.errorMsj = function(mensaje, opciones) {
    var settings = jQuery.extend({
        tipo: 'error',
        autocerrar: true,
        tiempo: 5000
    }, opciones );
    jQuery(this).alertMsj(mensaje, settings);
};

/**
* Plugin de JQuery para campos solo númericos
*
*/
jQuery.fn.numerico = function() {
    // jQuery(this).on('keyup', function () {
        if ( this.value.substr(0,1) === 0 )  {
                this.value = '';
            } else {
                this.value = this.value.replace(/[^0-9]/g,'');
        }
    // });
};

/**
* Plugin de JQuery para campos telefónicos
* números locales (Venezuela)
*
*/
jQuery.fn.telefono = function() {
    numericoPrefijo(this, '02', "Esto no es un teléfono de habitación válido<br/>Si desea puede dejar el campo vacío");
};

/**
* Plugin de JQuery para campos telefónicos
* números celular(Venezuela)
*
*/
jQuery.fn.celular = function () {
    numericoPrefijo(this, '04', "Esto no es un teléfono de celular válido<br/>Si desea puede dejar el campo vacío");
};

jQuery.fn.requerido = function () {
    // jQuery(this).on('blur', function(){
        var text = jQuery(this).val();
        if ( text.length === 0 ) {
            jQuery(this).next('.help-block').remove();
            jQuery(this).parent().parent().removeClass('error');
            jQuery(this).after('<span class="help-block">Este campo es obligatorio</span>');
            jQuery(this).parent().parent().addClass('error');
            jQuery(this).focus();
        } else {
            jQuery(this).next('.help-block').remove();
            jQuery(this).parent().parent().removeClass('error');
        }
    // });
};

/**
* Plugin de JQuery para campos correos
* electrónicos
*
*/
jQuery.fn.correo = function() {
    // jQuery(this).on('blur', function(){
        var text = jQuery(this).val();
        jQuery(this).next('.help-block').remove();
        jQuery(this).parent().parent().addClass('error');
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+jQuery/.test( text ) || text.length === 0 ) {
            jQuery(this).next('.help-block').remove();
            jQuery(this).parent().parent().addClass('error');
        } else {
            jQuery(this).addClass('box_error').focus();
            jQuery(this).after('<span class="help-block">Este correo inválido</span>').parent().parent().addClass('error');
        }
    // });
};

jQuery.fn.clearSelect = function() {
    jQuery(this).empty();
    jQuery(this).append( new Option('--', '') );
};

jQuery.fn.loadSelect = function() {
    jQuery(this).empty();
    jQuery(this).append( new Option("Cargando...", "") );
};


// TODO: terminar de escribir la función para limpiar formularios
jQuery.fn.limpiar = function(){
    jQuery(this).each(function(){
        // los input tipo hidden no le paran ni al .reset() (a la verga de empatados)
        if( $(this).attr('type') != 'hidden' ) {
            this.reset();
        } else {
            this.value="";
        }
    });
};

// Comprobamos el navegador por JS
jQuery.browser = {};
jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());

jQuery(document).ready(function(){
    jQuery('input[class~="req"]').on('blur', requerido);
    jQuery('input[type="email"]').on('blur', correo);
    jQuery('input[type="number"]').on('keyup', numerico);
    jQuery('input[type="tel"][data-type="local"]').telefono();
    jQuery('input[type="tel"][data-type="celular"]').celular();

    // TODO: Validar que la función datepicker este disponible
    jQuery('.datepicker').datepicker({language: 'es'});

    // jQuery('form').on('submit', function(e){
    //     e.preventDefault();

    // });
});