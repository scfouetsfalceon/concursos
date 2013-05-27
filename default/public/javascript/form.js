// Validar campo númerico y de tipo local
function numericoPrefijo(objecto, prefijo, mensaje) {
    objecto.live('keyup', function(){
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
        if ( text.length == 0 ){
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

function alertPopup(mensaje) {
    $('#alert').fadeOut().empty().html(mensaje).fadeIn('slow').delay(5000).fadeOut('slow');
}

$.fn.numerico = function() {
	$(this).on('keyup', function () {
        if ( this.value.substr(0,1) == 0 )  {
                this.value = '';
            } else {
		      this.value = this.value.replace(/[^0-9]/g,'');
        }
	});
}

$.fn.telefono = function() {
    numericoPrefijo(this, '02', "Esto no es un teléfono de habitación válido<br/>Si desea puede dejar el campo vacío");
}

$.fn.celular = function () {
    numericoPrefijo(this, '04', "Esto no es un teléfono de celular válido<br/>Si desea puede dejar el campo vacío");
}

$.fn.requerido = function () {
    $(this).on('blur', function(){
        var text = $(this).val();
        if ( text.length == 0 ) {
            $(this).addClass('box_error').focus();
            alertPopup("Este campo es obligatorio");
        } else {
            $(this).removeClass('box_error');
        }
    });
}

$.fn.correo = function() {
    $(this).on('blur', function(){
        var text = $(this).val();
        if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( text ) || text.length == 0 ) {
            $(this).removeClass('box_error');
        } else {
            $(this).addClass('box_error').focus();
            alertPopup("Este correo inválido");
        }
    });
}

$.fn.clearSelect = function() {
    $(this).empty();
    $(this).append( new Option('--', '') );
}

$.fn.loadSelect = function() {
    $(this).empty();
    $(this).append( new Option("Cargando...", "") );
}

$(document).ready(function(){
	var f = new Date(), ano = f.getFullYear();
    $('input[type="date"]').datepicker({
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
		yearRange: String(ano - 100) + ':' + String(ano)
	});
    $('input[class~="req"]').requerido();
    $('input[type="email"]').correo();
	$('input[type="number"]').numerico();
	$('input[type="tel"][data-type="local"]').telefono();
    $('input[type="tel"][data-type="celular"]').celular();
});