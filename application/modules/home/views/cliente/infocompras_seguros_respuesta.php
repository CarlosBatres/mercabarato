<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Respuesta del vendedor</h4>    
</div>
<div class="modal-body">
    <div class="row box">
        <div class="col-md-10 col-md-offset-1">                                                

            <div class="col-md-12">                      
                <?php echo $seguro->respuesta ?>
            </div>  
            <br>
            <hr>
            <?php if ($seguro->link_file!=null): ?>
                <div class="col-md-12">
                    <a title="Click para Descargar" href="<?php echo site_url('usuario/infocompras-seguros/descargar_respuesta/') . '/' . $seguro->link_file; ?>" >Descargar Adjunto</a>
                </div>
            <?php endif; ?>
        </div>              
    </div>
</div>
<div class="modal-footer">
    <!--                    <button type="submit" class="btn btn-template-main">Enviar</button>-->
    <button type="button" class="btn btn-template-main" data-dismiss="modal">Volver</button>                    
</div>
