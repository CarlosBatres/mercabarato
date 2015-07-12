$(document).ready(function() {     
    $("#productos_crear").validate({        
        rules: {
            nombre :{required:true},
            costo :{required:true,number:true},  
            duracion:{required:true,range:[1,12]}
        },
        messages: {
            nombre:{required:"El nombre es necesario"},
            costo: {required: "El monto es necesario",number:"Tiene que ser un valor numerico"},
            duracion:{required:"La duracion es necesaria",range:"Numero de meses invalido"}
        }
    });
    
    $("#seguros_crear").validate({        
        rules: {
            nombre :{required:true},
            costo :{required:true,number:true},  
            descripcion :{required:true},  
            duracion:{required:true,range:[1,12]}
        },
        messages: {
            nombre:{required:"El nombre es necesario"},
            costo: {required: "El monto es necesario",number:"Tiene que ser un valor numerico"},
            descripcion :{required:"Este campo es necesario"},  
            duracion:{required:"La duracion es necesaria",range:"Numero de meses invalido"}
        }
    });
});