$(document).ready(function() {
    $('.tipo_registro').find('a').on('click', function(e) {
        e.preventDefault();
        var tipo_registro = $(this).attr('class');
        if (tipo_registro === "registro_comprador") {
            $('.row_registro_comprador').removeClass("hidden");
            $('.row_registro_vendedor').addClass("hidden");
        } else {
            $('.row_registro_comprador').addClass("hidden");
            $('.row_registro_vendedor').removeClass("hidden");
        }
    });

    $('#registrar_comprador').find('select[name="pais"]').on('change', function() {
        $('#registrar_comprador').find('select[name="provincia"]').html("<option value='0'>---</option>");
        $('#registrar_comprador').find('select[name="poblacion"]').html("<option value='0'>---</option>");
        var pais_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'home/provincia/ajax_get_provincias_htmlselect',
            data: {pais_id: pais_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_comprador').find('select[name="provincia"]').html(response.html);
            }
        });
    });

    $('#registrar_comprador').find('select[name="provincia"]').on('change', function() {
        $('#registrar_comprador').find('select[name="poblacion"]').html("<option value='0'>---</option>");
        var provincia_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'home/poblacion/ajax_get_poblaciones_htmlselect',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_comprador').find('select[name="poblacion"]').html(response.html);
            }
        });
    });

    $('#registrar_vendedor').find('select[name="pais"]').on('change', function() {
        $('#registrar_vendedor').find('select[name="provincia"]').html("<option value='0'>---</option>");
        $('#registrar_vendedor').find('select[name="poblacion"]').html("<option value='0'>---</option>");
        var pais_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'home/provincia/ajax_get_provincias_htmlselect',
            data: {pais_id: pais_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_vendedor').find('select[name="provincia"]').html(response.html);
            }
        });
    });

    $('#registrar_vendedor').find('select[name="provincia"]').on('change', function() {
        $('#registrar_vendedor').find('select[name="poblacion"]').html("<option value='0'>---</option>");
        var provincia_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'home/poblacion/ajax_get_poblaciones_htmlselect',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_vendedor').find('select[name="poblacion"]').html(response.html);
            }
        });
    });


    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });

    validateForms();
});

function validateForms() {
    var password_comprador = $("#registrar_comprador").find("input[name='password']");    
    var email_comprador = $("#registrar_comprador").find("input[name='email']");
    $("#registrar_comprador").validate({        
        rules: {
            email: {
                required: true, 
                email: true,
                remote: {
			url: SITE_URL+"/home/user/check_email",
			type: "post",
			data: {
				email: function(){ return email_comprador.val(); }
			}
		}
            },
            password: {required: true},
            password_confirmar: {required: true, equalTo: password_comprador}
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
            }
        }
    });
    
    var password_vendedor = $("#registrar_vendedor").find("input[name='password']");
    var email_vendedor = $("#registrar_vendedor").find("input[name='email']");
    $("#registrar_vendedor").validate({        
        rules: {
            email: {
                required: true, 
                email: true ,
                remote: {
			url: SITE_URL+"/home/user/check_email",
			type: "post",
			data: {
				email: function(){ return email_vendedor.val(); }
			}
		}
            },
            password: {required: true},
            password_confirmar: {required: true, equalTo: password_vendedor}
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
            }
        }
    });
}