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
        },
        messages: {            
            nombre_empresa: {
                required: "Ingresa el nombre de tu empresa o compañia."
            },
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
            nombre_empresa: {required: true},            
        },
        messages: {            
            nombre_empresa: {
                required: "Ingresa el nombre de tu empresa o compañia."
            }            
        }
    }); 
    
    
    
});