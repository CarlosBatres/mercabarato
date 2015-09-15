<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>INFOCOMPRAS - GENERALES</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Mi Cuenta</li>                    
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content" class="clearfix">

    <div class="container">
        <div class="row">
            <?php echo form_open('usuario/infocompras-general/enviar_pregunta'); ?>
            <div class="col-md-9">                                 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                                                        
                            <h3>Mensaje a Enviar</h3>                    
                            <textarea class="form-control" id="pregunta" name="pregunta" rows="10"></textarea>                                        
                            <?php echo display_ckeditor($ckeditor); ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-4">                        
                        <input type="hidden" name="solicitud_id" value="<?php echo $solicitud_id ?>">
                        <button type="submit" class="btn btn-lg btn-primary"> Enviar</button>
                    </div>                                        
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-md-3">                       
                <?php echo $html_options; ?>                        
            </div> 
        </div>
    </div>
</div>