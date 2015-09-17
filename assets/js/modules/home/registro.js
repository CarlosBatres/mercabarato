$(document).ready(function() {    
    $('#form_crear').find('select[name="pais"]').on('change', function() {
        $('#form_crear').find('select[name="provincia"]').html("<option value='0'>Provincia</option>");
        $('#form_crear').find('select[name="poblacion"]').html("<option value='0'>Población</option>");
        var pais_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_provincias',
            data: {pais_id: pais_id},
            dataType: 'json',
            success: function(response) {
                $('#form_crear').find('select[name="provincia"]').html(response.html);
            }
        });
    });

    $('#form_crear').find('select[name="provincia"]').on('change', function() {
        $('#form_crear').find('select[name="poblacion"]').html("<option value='0'>Población</option>");
        var provincia_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_poblaciones',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#form_crear').find('select[name="poblacion"]').html(response.html);
            }
        });
    });   
    
    $('#form_crear').find('select[name="pais"]').trigger('change');

    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });

    validateForms();    
});

function validateForms() {
    var password_comprador = $("#form_crear").find("input[name='password']");    
    var email_comprador = $("#form_crear").find("input[name='email']");
    $("#form_crear").validate({        
        rules: {
            email: {
                required: true, 
                email: true,
                remote: {
			url: SITE_URL+"util/verificar_email",
			type: "post",
			data: {
				email: function(){ return email_comprador.val(); },
                                ignore_temporal : true
			}
		}
            },
            password: {required: true},
            password_confirmar: {required: true, equalTo: password_comprador},
            nombres: {required: true,},
            apellidos: {required: true}
        },
        messages: {
            email: {
                required: "Ingrese su email",
                email: "Ingrese un email valido",
                remote: 'Email ya existe. Ingrese un email diferente.'
            },
            password: {
                required: "Ingrese una contraseña"
            },
            password_confirmar: {
                required: "Confirme su contraseña",
                equalTo: "Las contraseñas tienen que ser iguales"
            },
            nombres: {
                required: "Ingresa tu Nombre(s)."
            },
            apellidos: {
                required: "Ingresa tu(s) Apellido(s)."
            }
        }
    });   
    
}