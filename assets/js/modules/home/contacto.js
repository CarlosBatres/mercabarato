$(document).ready(function() {
    $("#formulario_contacto").validate({
        rules: {
            el_email: {required: true,email:true},
            mensaje : {required:true},            
        },
        messages: {
            el_email: {
                required: "Ingresa un email.",
                email:"Ingresa un email valido."
            },
            mensaje:{
                required:" Escribe un comentario o mensaje."
            }
        }
    });
   
});
