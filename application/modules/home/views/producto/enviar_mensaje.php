<script>
    $(document).ready(function() {
        $("#submit").click(function() {
            if ($("#producto-enviar-mensaje").valid()) {
                $.ajax({
                    type: "POST",
                    url: SITE_URL + "productos/enviar_mensaje/<?php echo $producto->id ?>",
                    data: $('#producto-enviar-mensaje').serialize(),
                    success: function(msg) {
                        $("#myModal").modal('hide');
                    }
                });
            }
        });
        $("#producto-enviar-mensaje").validate({
            rules: {
                asunto: {required: true},
                mensaje: {required: true}
            },
            messages: {
                asunto: {
                    required: "Este campo es necesario."
                },
                mensaje: {
                    required: "Este campo es necesario."
                },
            }
        });
    });
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Mensaje a Vendedor</h4>
</div>
<div class="modal-body">
    <?php echo form_open('productos/enviar_mensaje/' . $producto->id, "id='producto-enviar-mensaje'"); ?>
    <div class="row">  
        <div class="col-md-12">                            
            <div class="form-group">                                                                
                <label><strong>Asunto</strong></label>                
                <input type="text" class="form-control" name="asunto">                                                
            </div>
        </div>
        <div class="col-md-12"> 
            <div class="form-group">
                <label><strong>Mensaje</strong></label>
                <textarea class="form-control" name="mensaje" rows="5" cols="20"></textarea>                    
            </div>                                                        
        </div>
    </div>    
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-template-main" id="submit">Enviar</button>
    <button type="button" class="btn btn-template-main" data-dismiss="modal">Cancelar</button>
    <?php echo form_close(); ?>
</div>