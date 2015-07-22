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
            nif_cif: {required: true}
        },
        messages: {
            nombre_empresa: {
                required: "Ingresa el nombre de tu empresa o compañia.",
                remote: "Este es un nombre invalido, intente con uno diferente."
            },
            nif_cif: {
                required: "Ingresa tu N.I.F o C.I.F"
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
                    $('#file_name').val(file.name);
                });
                $('#form_datos_2').submit();
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
});