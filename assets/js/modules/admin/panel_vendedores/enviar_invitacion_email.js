$(document).ready(function() {
    $("#email_form").validate({
        ignore: [],
        rules: {
            email: {
                required: true, 
                email: true,
                remote: {
			url: SITE_URL+"util/verificar_email",
			type: "post",
			data: {
				email: function(){ return $("#email_form").find('input[name="email"]').val(); },
                                ignore_temporal : true
			}
		}
            },
            titulo: {required: true},
            contenido: {
                required: function()
                {
                    CKEDITOR.instances.content.updateElement();
                }
            }
        },
        messages: {
            email: {
                required: "Ingresa un email para enviar la invitacion",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en el sistema, ingrese uno diferente.'
            },           
            titulo: {
                required: "Este campo es requerido."
            },
            contenido: {
                required: "Este campo es requerido."
            }
        },
        errorPlacement: function(error, $elem) {            
            if ($elem.attr("name") == "contenido") {
                $elem.next().css('border', '1px solid red');
                error.insertBefore($elem);
            } else {
                error.insertAfter($elem);
            }

        },
    });  
});