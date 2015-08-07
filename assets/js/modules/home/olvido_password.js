$(document).ready(function() {

    $("#olvido_password").validate({
        rules: {
            email: {required: true, email: true},
        },
        messages: {
            email: {
                required: "El email es requerido.", email: "Ingrese un email valido."
            },
        }
    });

    $("#form_password").validate({
        rules: {            
            password_1: {required: true},
            password_2: {required: true, equalTo: $("#form_password").find("input[name='password_1']")},
        },
        messages: {
            password_1: {
                required: "Campo necesario"
            },
            password_2: {
                required: "Campo necesario",
                equalTo: "Las contraseñas tienen que ser iguales"
            }
        }
    });

});