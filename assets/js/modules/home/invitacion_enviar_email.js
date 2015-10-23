$(document).ready(function() {
    var email_comprador = $("#enviar_invitacion").find("input[name='email']");
    $("#enviar_invitacion").validate({
        rules: {
            email: {
                required: true,
                email: true,                
            },
            titulo: {required: true},
            mensaje: {required: true},
        },
        messages: {
            email: {
                required: "Ingrese su email",
                email: "Ingrese un email valido",
                remote: 'Email ya existe. Ingrese un email diferente.'
            },            
            titulo: {
                required: "Este campo es requerido."
            },
            mensaje: {
                required: "Este campo es requerido."
            }
        }
    });
});
