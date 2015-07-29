$(document).ready(function() {    
    
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
    
    var fecha_inicio=$("#detalles_oferta").find('input[name="fecha_inicio"]');
    //alert(fecha_inicio);
    
    $("#detalles_oferta").validate({        
        rules: {            
            valor: {required: true,number:true},
            fecha_inicio: {required: true},
            fecha_finaliza: {required: true,greaterThan:fecha_inicio},     
            nombre: {required:true}
        },
        messages: {            
            valor: {required: "Este campo es necesario.",number:"Este campo tiene que ser un numero"},
            fecha_inicio: {required:"Indica una fecha de inicio de la oferta",date:"Ingresa una fecha valida"},
            fecha_finaliza: {required:"Indica una fecha de finalizacion de la oferta",date:"Ingresa una fecha valida",
                greaterThan:"La fecha de finalizar debe ser mayor que la de inicio"},
            nombre: {required:" Indique un nombre para identificar la oferta."}            
        }
    });
    
});