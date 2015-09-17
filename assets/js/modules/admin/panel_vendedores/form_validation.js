$(document).ready(function() {
    $("#admin_crear_form,#admin_edit_form,#enviar_invitacion").validate({
        ignore: [],
        rules: {
            titulo: {required: true},
            contenido: {
                required: function()
                {
                    CKEDITOR.instances.content.updateElement();
                }
            }
        },
        messages: {
            titulo: {required: "Este campo es requerido."},
            contenido: {required: "Este campo es requerido."}
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
    
    
    $("#responder_seguro_form,#responder_general_form").validate({
        ignore: [],
        rules: {
            precio: {required: true,number:true},
            respuesta: {
                required: function()
                {
                    CKEDITOR.instances.content.updateElement();
                }
            }
        },
        messages: {
            precio: {required: "Este campo es requerido.",number:"Debe ser un numero."},
            respuesta: {required: "Debes ofrecer una respuesta."}
        },
        errorPlacement: function(error, $elem) {            
            if ($elem.attr("name") == "respuesta") {
                $elem.next().css('border', '1px solid red');
                error.insertBefore($elem);
            } else {
                error.insertAfter($elem);
            }

        },
    });
    
});