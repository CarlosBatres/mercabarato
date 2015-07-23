$(document).ready(function() {    
    
    $('#fileupload').fileupload({
        dataType: 'json',
        replaceFileInput: false,
        method: "post",
        autoUpload: "false",
        singleFileUploads: false,
        add: function(e, data) {
            $("#admin_producto_submit").off('click').on('click', function(e) {
                e.preventDefault();
                data.submit();
            });           
        },
        start: function(e, data) {
            $.blockUI({
                message: $('#throbber'),
                css: {border: '0'}});
        },
        done: function(e, data) {
            var files="";
            $.each(data.result.files, function(index, file) {                
                files=files+file.name;
                files=files+";;";                
            });
            files=files.slice(0,-2);
            $('#file_name').val(files);
            $.unblockUI();
            $('#admin_producto_form').submit();
        }
    });

    $('#cambiar_imagen').on('click', function(e) {
        e.preventDefault();
        $('.fileupload_button').css('display', 'block');
        $('.preview_imagen').html('');
        $('.preview_imagen').css('display', 'none');
        $(this).css('display', 'none');
    });

    $('#categorias_jtree').jstree({expand_selected_onload: true});

    $('#categorias_jtree').bind("select_node.jstree", function(event, data) {
        var obj = data.instance.get_node(data.node, true);
        if (obj) {
            obj.siblings(".jstree-open").each(function() {
                data.instance.close_node(this, 0);
            });
        }
    });

    $('#categorias_jtree').on("changed.jstree", function(e, data) {
        var categoria_id = $('#categorias_jtree').find('#' + data.selected).data('id');
        $('input[name="categoria_id"]').val(categoria_id);
    });

    validateForms();
});

function validateForms() {
    $("#admin_producto_form").validate({
        submitHandler: function(form) {
            if ($('input[name="categoria_id"]').val() !== "") {
                form.submit();
            } else {
                $('#seleccionar-categoria_alert').css('display', 'block');
                return false;
            }
        },
        rules: {
            nombre: {required: true},
            precio: {required: true, number: true}
        },
        messages: {
            nombre: {
                required: "El nombre del producto es necesario."
            },
            precio: {
                required: "Ingrese un monto.",
                number: "Ingrese un numero"
            }
        }
    });

}