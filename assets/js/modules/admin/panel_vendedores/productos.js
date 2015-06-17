$(document).ready(function() {    
    
    $('#fileupload').fileupload({
        dataType: 'json',
        replaceFileInput: false,
        method: "post",
        autoUpload: "false",        
        add: function(e, data) {                                    
            $("#admin_producto_submit").off('click').on('click', function(e) {
                e.preventDefault();
                data.submit();
            });
        },
        done: function(e, data) {            
            $.each(data.result.files, function(index, file) {
                $('#file_name').val(file.name);                
            });
            $('#admin_producto_form').submit();
        }
    });
    
    $('#cambiar_imagen').on('click',function(e){
        e.preventDefault();
        $('.fileupload_button').css('display','block');
        $('.preview_imagen').html('');
        $('.preview_imagen').css('display','none');
        $(this).css('display','none');
    });
});