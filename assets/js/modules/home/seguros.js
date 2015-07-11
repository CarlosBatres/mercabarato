$(document).ready(function() {
    validateForms();
});

function validateForms() {
    $("#seguro_hogar").validate({
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "home/usuario/check_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_hogar").find("input[name='email']").val();
                        }
                    }
                }
            },
            nombres: {required: true},
            apellidos: {required: true},
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
            nombres: {required: "Ingresa tu(s) Nombre(s)."},
            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
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
                    url: SITE_URL + "home/usuario/check_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_riesgo").find("input[name='email']").val();
                        }
                    }
                }
            },
            nombres: {required: true},
            apellidos: {required: true},
            sexo: {required: true},
            profesion: {required: true},
        },
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Este email ya esta registrado en nuestro sistema.'
            },
            nombres: {required: "Ingresa tu(s) Nombre(s)."},
            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
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
                    url: SITE_URL + "home/usuario/check_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_salud").find("input[name='email']").val();
                        }
                    }
                }
            },
            nombres: {required: true},
            apellidos: {required: true},
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
            nombres: {required: "Ingresa tu(s) Nombre(s)."},
            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
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
                    url: SITE_URL + "home/usuario/check_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_vehiculos").find("input[name='email']").val();
                        }
                    }
                }
            },
            nombres: {required: true},
            apellidos: {required: true},
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
            nombres: {required: "Ingresa tu(s) Nombre(s)."},
            apellidos: {required: "Ingresa tu(s) Apellido(s)."},
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
                    url: SITE_URL + "home/usuario/check_email",
                    type: "post",
                    data: {
                        email: function() {
                            return $("#seguro_otros").find("input[name='email']").val();
                        }
                    }
                }
            },
            nombres: {required: true},
            apellidos: {required: true},
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