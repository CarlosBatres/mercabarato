<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Pagina del Usuario</h1>
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

            <!-- *** LEFT COLUMN ***
                 _________________________________________________________ -->

            <div class="col-md-9 clearfix">
                <div class="col-md-12">
                    <div class="heading">
                        <h3>Enviar invitación</h3>
                    </div>                    
                    <?php echo form_open('usuario/contactos/enviar-invitacion', 'id="enviar_invitacion" rel="preventDoubleSubmission"'); ?>
                    
                    <div class="form-group">                    
                        <label><strong>Correo electrónico del Vendedor</strong></label>                        
                        <input type="text" class="form-control" name="email" autofocus="" autocomplete="off">                                    
                    </div>                            
                    <br>
                    <hr>
                    <p class="lead">A continuación escriba un mensaje para enviar al vendedor.</p>
                    <div class="form-group">                    
                        <label><strong>Titulo</strong></label>                        
                        <input type="text" class="form-control" name="titulo" autocomplete="off">                                    
                    </div>                            

                    <div class="form-group">                    
                        <label><strong>Mensaje</strong></label>
                        <textarea class="form-control" name="mensaje" rows="5" cols="20" style="resize: none;"></textarea>                    
                    </div> 
                    <input type="hidden" name="vendedor_id" value="">

                    <button type="submit" class="btn btn-template-primary">Enviar</button>
                    <a href="<?php echo site_url('usuario/contactos')?>" class="btn btn-danger">Cancelar</a>                

                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php echo $html_options; ?>
            </div>

        </div>
    </div>
</div>

