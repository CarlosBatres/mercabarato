$(document).ready(function() {
    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });  
        
    var email_comprador = $("#admin_nuevo_form").find("input[name='email']");
    $("#admin_nuevo_form").validate({        
        rules: {
            email: {
                required: true, 
                email: true,
                remote: {
			url: SITE_URL+"/home/usuario/check_email",
			type: "post",
			data: {
				email: function(){ return email_comprador.val(); }
			}
		}
            },
            password: {required: true},            
        },
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Email ya existe. Ingrese un email diferente.'
            },
            password: {
                required: "Ingrese un contraseña"
            }            
        }
    }); 
    
    $("#admin_edit_form").validate({        
        rules: {
            email: {
                required: true, 
                email: true,
                remote: {
			url: SITE_URL+"/home/usuario/check_email",
			type: "post",
			data: {
				email: function(){ return email_comprador.val(); }
			}
		}
            },            
        },
        messages: {
            email: {
                required: "Ingrese un email",
                email: "Ingrese un email valido",
                remote: 'Email ya existe. Ingrese un email diferente.'
            }            
        }
    });
});