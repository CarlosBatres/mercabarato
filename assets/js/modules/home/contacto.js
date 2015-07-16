$(document).ready(function() {
    $("#formulario_contacto").validate({
        rules: {
            email: {required: true,email:true},
            mensaje : {required:true}
        },
        messages: {
            email: {
                required: "Ingresa un email.",
                email:"Ingresa un email valido."
            },
            mensaje:{
                required:" Escribe un comentario o mensaje."
            }
        }
    });
   
});
