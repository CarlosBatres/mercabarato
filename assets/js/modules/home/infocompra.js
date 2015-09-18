$(document).ready(function() {
    validateForms();


    $("#infocompras-general").find('input[name="tipo"]').on('change', function(e) {
        if ($(this).val() == 1) {
            $("#infocompras-general").find('.tipo-regalo').css('display', 'block');
            $("#infocompras-general").find('.tipo-ocio').css('display', 'none');

            $("#infocompras-general").find('.tipo-ocio').find('input[name="tipo-ocio"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-ocio').find('input[name="comida"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_inicio_restaurante"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_fin_restaurante"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="cantidad_personas"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="habitaciones"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_inicio_hoteles"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_fin_hoteles"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="cantidad_personas"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="exigencia"]').val('');

        } else if ($(this).val() == 4) {
            $("#infocompras-general").find('.tipo-regalo').css('display', 'none');
            $("#infocompras-general").find('.tipo-ocio').css('display', 'block');

            $("#infocompras-general").find('.tipo-regalo').find('input[name="regalo_tipo"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-regalo').find('input[name="sexo"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-regalo').find('input[name="edad"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-regalo').find('input[name="gustos"]').val('');
        } else {
            $("#infocompras-general").find('.tipo-regalo').css('display', 'none');
            $("#infocompras-general").find('.tipo-ocio').css('display', 'none');

            $("#infocompras-general").find('.tipo-ocio').find('input[name="tipo-ocio"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-ocio').find('input[name="comida"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_inicio_restaurante"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_fin_restaurante"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="cantidad_personas"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="habitaciones"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_inicio_hoteles"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="fecha_fin_hoteles"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="cantidad_personas"]').val('');
            $("#infocompras-general").find('.tipo-ocio').find('input[name="exigencia"]').val('');

            $("#infocompras-general").find('.tipo-regalo').find('input[name="regalo_tipo"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-regalo').find('input[name="sexo"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-regalo').find('input[name="edad"]').prop('checked', false);
            $("#infocompras-general").find('.tipo-regalo').find('input[name="gustos"]').val('');
        }
    });


    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });
    
    $('#infocompras-general-parte1').find('select[name="provincia"]').on('change', function() {
        console.log("change");
        $('#infocompras-general-parte1').find('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var provincia_id = $(this).val();        
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_poblaciones',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#infocompras-general-parte1').find('select[name="poblacion"]').html(response.html);
                $('#infocompras-general-parte1').find('select[name="poblacion"]').find('option:first').text("Todas las Poblaciones");
            }
        });
    });
});

function validateForms() {
    $("#infocompras-general").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "util/verificar_email_informacion",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#infocompras-general").find("input[name='email']").val();
                        }, ignore_temporal: false
                    }
                }
            },
            comentario: {required: true},
            tipo: {required: true},
            precio_desde:{number:true},
            precio_hasta:{number:true}
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "tipo") {
                error.insertBefore(element.parent().parent());
            } else {
                error.insertAfter(element);
            }

        },
        errorElement: 'div',
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido"                
            },
            comentario: {required: "Este campo es necesario."},
            tipo: {required: "Seleccione uno."},
            precio_desde:{number:"Debe ser numerico."},
            precio_hasta:{number:"Debe ser numerico."}
        }
    });
}   