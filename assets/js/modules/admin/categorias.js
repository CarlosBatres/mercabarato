$(document).ready(function() {
   
    $('#fileupload').fileupload({
        dataType: 'json',
        replaceFileInput: false,
        method: "post",
        autoUpload: "false",        
        add: function(e, data) {            
            $("#admin_form_submit").off('click').on('click', function(e) {
                e.preventDefault();
                data.submit();
            });
        },
        done: function(e, data) {            
            $.each(data.result.files, function(index, file) {
                $('#file_name').val(file.name);                
            });
            $('#admin_categoria_form').submit();
        }
    });
});