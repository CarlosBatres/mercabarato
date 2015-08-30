$(document).ready(function() {
    validateForms();
    /*$('#form_buscar').find('select[name="pais"]').on('change', function() {
        $('#form_buscar').find('select[name="provincia"]').html("<option value='0'>Todas las Provincias</option>");
        $('#form_buscar').find('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var pais_id = $(this).val();
        updateResultados();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_provincias',
            data: {pais_id: pais_id},
            dataType: 'json',
            success: function(response) {
                $('#form_buscar').find('select[name="provincia"]').html(response.html);
                $('#form_buscar').find('select[name="provincia"]').find('option:first').text("Todas las Provincias");
            }
        });
    });*/

    $('#form_buscar').find('select[name="provincia"]').on('change', function() {
        $('#form_buscar').find('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var provincia_id = $(this).val();
        updateResultados();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_poblaciones',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#form_buscar').find('select[name="poblacion"]').html(response.html);
                $('#form_buscar').find('select[name="poblacion"]').find('option:first').text("Todas las Poblaciones");
            }
        });
    });

    $('#form_buscar').find('select[name="poblacion"]').on('change', function() {
        updateResultados();
    });

    //$('#form_buscar').find('select[name="pais"]').trigger('change');
    $('#form_buscar').find('select[name="provincia"]').trigger('change');

    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });

    $('#enviar-todos').on('click', function(e) {
        e.preventDefault();
        $.blockUI({ message: '<h1>Espere un momento...</h1>' });
        $.post(SITE_URL + "seguros/enviar-todos",
                {
                    pais: $('#form_buscar').find('select[name="pais"]').val(),
                    provincia: $('#form_buscar').find('select[name="provincia"]').val(),
                    poblacion: $('#form_buscar').find('select[name="poblacion"]').val()
                }).done(function() {
            updateResultados();            
            $.unblockUI();
            $('.terminar-btn').css('display', 'block');
        });
    });
});

function enviar_todos() {
    if ($('#form_buscar').find('select[name="poblacion"]').val() !== '0' || $('#form_buscar').find('select[name="provincia"]').val() !== '0') {
        $('.enviar-todos-btn').css('display', 'block');
    } else {
        $('.enviar-todos-btn').css('display', 'none');
    }
}

function validateForms() {
    $("#seguro_hogar").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "util/verificar_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_hogar").find("input[name='email']").val();
                        },ignore_temporal : false
                    }
                }
            },
//            nombres: {required: true},
//            apellidos: {required: true},
            edificio_apartamento: {required: true},
            edificio_vivienda: {required: true},
            uso: {required: true},
            regimen_vivienda: {required: true},
            construccion_estandar: {required: true},
            año_construccion: {required: true, range: [1900, 2100]},
        },
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en nuestro sistema.'
            },
//            nombres: {required: "Ingresa tu(s) Nombre(s)."},
//            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
            edificio_apartamento: {required: "Este campo es requerido."},
            edificio_vivienda: {required: "Este campo es requerido."},
            uso: {required: "Este campo es requerido."},
            regimen_vivienda: {required: "Este campo es requerido."},
            construccion_estandar: {required: "Este campo es requerido."},
            año_construccion: {required: "Este campo es requerido.", range: "Ingrese un año valido"},
        }
    });

    $("#seguro_riesgo").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "util/verificar_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_riesgo").find("input[name='email']").val();
                        }
                    }
                }
            },
//            nombres: {required: true},
//            apellidos: {required: true},
            sexo: {required: true},
            profesion: {required: true},
        },
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en nuestro sistema.'
            },
//            nombres: {required: "Ingresa tu(s) Nombre(s)."},
//            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
            sexo: {required: "Este campo es requerido"},
            profesion: {required: "Este campo es requerido"},
        }
    });

    $("#seguro_salud").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "util/verificar_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_salud").find("input[name='email']").val();
                        }
                    }
                }
            },
//            nombres: {required: true},
//            apellidos: {required: true},
            provincia_grupo_familiar: {required: true},
            numero_personas: {required: true},
            fecha_nacimiento: {required: true},
            sexo: {required: true},
        },
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en nuestro sistema.'
            },
//            nombres: {required: "Ingresa tu(s) Nombre(s)."},
//            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
            provincia_grupo_familiar: {required: "Este campo es requerido."},
            numero_personas: {required: "Este campo es requerido."},
            fecha_nacimiento: {required: "Este campo es requerido."},
            sexo: {required: "Este campo es requerido."},
        }
    });

    $("#seguro_vehiculos").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "util/verificar_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_vehiculos").find("input[name='email']").val();
                        }
                    }
                }
            },
//            nombres: {required: true},
//            apellidos: {required: true},
            tipo_vehiculo: {required: true},
            marca: {required: true},
            modelo: {required: true},
            vehiculo_combustible: {required: true},
            matricula: {required: true},
            fecha_nacimiento: {required: true},
            provincia: {required: true},
        },
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en nuestro sistema.'
            },
//            nombres: {required: "Ingresa tu(s) Nombre(s)."},
//            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
            tipo_vehiculo: {required: "Este campo es requerido"},
            marca: {required: "Este campo es requerido"},
            modelo: {required: "Este campo es requerido"},
            vehiculo_combustible: {required: "Este campo es requerido"},
            matricula: {required: "Este campo es requerido"},
            fecha_nacimiento: {required: "Este campo es requerido"},
            provincia: {required: "Este campo es requerido"},
        }
    });

    $("#seguro_otros").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "util/verificar_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_otros").find("input[name='email']").val();
                        }
                    }
                }
            },
//            nombres: {required: true},
//            apellidos: {required: true},
            observaciones: {required: true},
            otros: {required: true}
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "otros") {
                error.insertBefore(element);
            } else {
                error.insertAfter(element);
            }

        },
        errorElement: 'div',
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en nuestro sistema.'
            },
            nombres: {required: "Ingresa tu(s) Nombre(s)."},
            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
            observaciones: {required: "Este campo es requerido"},
            otros: {required: "Selecciona al menos uno"}
        }
    });
}

function updateResultados() {
    var pagina_id = $('#pagina').val();
    //var pais = $('select[name="pais"]').val();
    var provincia = $('select[name="provincia"]').val();
    var poblacion = $('select[name="poblacion"]').val();

    $('#tabla-resultados').css('opacity', '0.5');
    $('#tabla-resultados').block({message: $('#throbber'),
        css: {width: '4%', border: '0px solid #FFFFFF', cursor: 'wait', backgroundColor: '#FFFFFF', top: '50px'},
        overlayCSS: {backgroundColor: '#FFFFFF', opacity: 0.0, cursor: 'wait'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'seguros/buscar_prestadores',
        data: {
            pagina: pagina_id,
            //pais: pais,
            provincia: provincia,
            poblacion: poblacion
        },
        dataType: "json",
        success: function(response) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response.html);
            bind_pagination_links();
            bind_botones();
            if (response.result === "success") {
                enviar_todos();
            } else if (response.result === "empty") {
                $('.enviar-todos-btn').css('display', 'none');
            }

        }
    });
}

function bind_pagination_links() {
    $('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultados();
    });
}

function bind_botones() {
    $('.enviar_presupuesto').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.post(SITE_URL + "seguros/enviar", {id: id}).done(function() {
            updateResultados();
            $('.terminar-btn').css('display', 'block');
        });
    });
}