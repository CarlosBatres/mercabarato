$(document).ready(function() {
    $('#perfil-opciones').metisMenu();

    $("#form_datos_1").validate({
        rules: {
            nombres: {required: true},
        },
        messages: {
            nombres: {
                required: "El nombre es requerido."
            },
        }
    });

    $("#form_datos_2").validate({
        rules: {
            nombre_empresa: {required: true},
            nif_cif: {required: true}
        },
        messages: {
            nombre_empresa: {
                required: "Ingresa el nombre de tu empresa o compañia."
            },
            nif_cif: {
                required: "Ingresa tu N.I.F o C.I.F"
            }
        }
    });

    $("#form_password").validate({
        rules: {
            password_old: {required: true},
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
            },
            password_old: {
                required: "Campo necesario"
            }
        }
    });

    $("#form_afiliarse").validate({
        rules: {
            nombre_empresa: {
                required: true,
                remote: {
                    url: SITE_URL + "util/verificar_nombre",
                    type: "post",
                    data: {
                        nombre: function() {
                            return $("#form_afiliarse").find("input[name='nombre_empresa']").val();
                        }
                    }
                }
            },
            nif_cif: {required: true},
            nickname: {required: true, maxlength: 30,minlength: 3,
                remote: {
                    url: SITE_URL + "util/verificar_nickname",
                    type: "post",
                    data: {
                        nombre: function() {
                            return $("#form_afiliarse").find("input[name='nickname']").val();
                        }
                    }
                }}
        },
        messages: {
            nombre_empresa: {
                required: "Ingresa el nombre de tu empresa o compañia.",
                remote: "Este es un nombre invalido, intente con uno diferente."
            },
            nif_cif: {
                required: "Ingresa tu N.I.F o C.I.F"
            },
            nickname: {
                required: "Ingresa un apodo unico que te identifique",
                remote: "Este apodo es invalido o ya existe ingresa uno nuevo.",
                maxlength: "El apodo debe tener un maximo de 30 caracteres.",
                minlength: "El apodo debe tener un minimo de 3 caracteres."
            }
        }
    });

    if ($('#fileupload').length) {
        $('#fileupload').fileupload({
            dataType: 'json',
            replaceFileInput: false,
            method: "post",
            autoUpload: "false",
            add: function(e, data) {
                $("#form_datos_2").find('button').off('click').on('click', function(e) {
                    e.preventDefault();
                    data.submit();
                });
            },
            done: function(e, data) {
                $.each(data.result.files, function(index, file) {
                    if (typeof file.error !== 'undefined') {                        
                        $('#fileupload_alert').css('display', 'block');
                        $('html, body').animate({
                            scrollTop: $('#fileupload_alert').offset().top
                        }, 1000);                        
                        $('#fileupload_alert').find('span').html(file.error);
                    } else {
                        $('#file_name').val(file.name);
                        $('#form_datos_2').submit();
                    }
                });
            }
        });

        $('#cambiar_imagen').on('click', function(e) {
            e.preventDefault();
            $('.fileupload_button').css('display', 'block');
            $('.preview_imagen_empresa').html('');
            $('.preview_imagen_empresa').css('display', 'none');
            $(this).css('display', 'none');
        });
    }

    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });

    /*$('select[name="pais"]').on('change', function() {
     $('#form_afiliarse').find('select[name="provincia"]').html("<option value='0'>Provincia</option>");
     $('#form_afiliarse').find('select[name="poblacion"]').html("<option value='0'>Población</option>");
     var pais_id = $(this).val();
     $.ajax({
     type: "POST",
     url: SITE_URL + 'util/get_provincias',
     data: {pais_id: pais_id},
     dataType: 'json',
     success: function(response) {
     $('#form_afiliarse').find('select[name="provincia"]').html(response.html);
     }
     });
     });*/

    $('select[name="provincia"]').on('change', function() {
        $('select[name="poblacion"]').html("<option value='0'>Seleccione una</option>");
        var provincia_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_poblaciones',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('select[name="poblacion"]').html(response.html);
            }
        });
    });

    //$('#form_afiliarse').find('select[name="pais"]').trigger('change');
});