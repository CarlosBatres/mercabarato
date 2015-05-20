$(document).ready(function() {
   $('.tipo_registro').find('a').on('click',function(e){
       e.preventDefault();
       var tipo_registro=$(this).attr('class');
       if(tipo_registro==="registro_comprador"){
           $('.row_registro_comprador').removeClass("hidden");
           $('.row_registro_vendedor').addClass("hidden");
       }else{
           $('.row_registro_comprador').addClass("hidden");
           $('.row_registro_vendedor').removeClass("hidden");
       }
   });
   
   $('#registrar_comprador').find('select[name="pais"]').on('change', function() {
       $('#registrar_comprador').find('select[name="provincia"]').html("<option value='0'>---</option>");
       $('#registrar_comprador').find('select[name="poblacion"]').html("<option value='0'>---</option>");       
        var pais_id=$(this).val();        
         $.ajax({
            type: "POST",
            url: SITE_URL + 'home/provincia/ajax_get_provincias_htmlselect',
            data: {pais_id:pais_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_comprador').find('select[name="provincia"]').html(response.html);
            }
        });
    });
    
    $('#registrar_comprador').find('select[name="provincia"]').on('change', function() {
        $('#registrar_comprador').find('select[name="poblacion"]').html("<option value='0'>---</option>");
        var provincia_id=$(this).val();
         $.ajax({
            type: "POST",
            url: SITE_URL + 'home/poblacion/ajax_get_poblaciones_htmlselect',
            data: {provincia_id:provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_comprador').find('select[name="poblacion"]').html(response.html);
            }
        });
    });
    
    $('#registrar_vendedor').find('select[name="pais"]').on('change', function() {
       $('#registrar_vendedor').find('select[name="provincia"]').html("<option value='0'>---</option>");
       $('#registrar_vendedor').find('select[name="poblacion"]').html("<option value='0'>---</option>");       
        var pais_id=$(this).val();        
         $.ajax({
            type: "POST",
            url: SITE_URL + 'home/provincia/ajax_get_provincias_htmlselect',
            data: {pais_id:pais_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_vendedor').find('select[name="provincia"]').html(response.html);
            }
        });
    });
    
    $('#registrar_vendedor').find('select[name="provincia"]').on('change', function() {
        $('#registrar_vendedor').find('select[name="poblacion"]').html("<option value='0'>---</option>");
        var provincia_id=$(this).val();
         $.ajax({
            type: "POST",
            url: SITE_URL + 'home/poblacion/ajax_get_poblaciones_htmlselect',
            data: {provincia_id:provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#registrar_vendedor').find('select[name="poblacion"]').html(response.html);
            }
        });
    });
    
});