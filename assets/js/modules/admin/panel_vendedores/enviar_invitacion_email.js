$(document).ready(function() {
    $("#email_form").validate({        
        rules: {
            email: {
                required: true, 
                email: true,
                remote: {
			url: SITE_URL+"util/verificar_email",
			type: "post",
			data: {
				email: function(){ return $("#email_form").find('input[name="email"]').val(); },
                                ignore_temporal : false
			}
		}
            },
            titulo: {required: true},
            comentario: {required: true},            
        },
        messages: {
            email: {
                required: "Ingrese su email",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en el sistema, ingrese uno diferente.'
            },           
            titulo: {
                required: "Este campo es requerido."
            },
            comentario: {
                required: "Este campo es requerido."
            }
        }
    });  
});