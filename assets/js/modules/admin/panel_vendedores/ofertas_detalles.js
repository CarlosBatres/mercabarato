$(document).ready(function() {
    updateResultadosProductos();
    updateResultadosClientes();
    
    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });
    
    $("#datepicker2").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        yearRange: "1900:-nn"
    });
    
    $("#detalles_oferta").validate({        
        rules: {            
            valor: {required: true,number:true},
            fecha_inicio: {required: true},
            fecha_finaliza: {required: true},            
        },
        messages: {            
            valor: {required: "Este campo es necesario.",number:"Este campo tiene que ser un numero"},
            fecha_inicio: {required:"Indica una fecha de inicio de la oferta",date:"Ingresa una fecha valida"},
            fecha_finaliza: {required:"Indica una fecha de finalizacion de la oferta",date:"Ingresa una fecha valida"},
        }
    });
    
});

function updateResultadosProductos() {            
    $('#tabla-resultados-productos').html('<br><br><br>');
    $('#tabla-resultados-productos').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/ofertas/ajax_get_productos',
        data: {
            pagina: "1",
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-productos').unblock();
            $('#tabla-resultados-productos').html(response);
            //bind_pagination_links();
        }
    });
}

function updateResultadosClientes() {            
    $('#tabla-resultados-clientes').html('<br><br><br>');
    $('#tabla-resultados-clientes').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/ofertas/ajax_get_clientes',
        data: {
            pagina: "1",
            sexo: "X"
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-clientes').unblock();
            $('#tabla-resultados-clientes').html(response);
            //bind_pagination_links();
        }
    });
}