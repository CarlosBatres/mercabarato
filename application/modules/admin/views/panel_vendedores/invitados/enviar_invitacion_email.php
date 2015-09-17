<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Enviar Invitacion
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php echo form_open('panel_vendedor/invitaciones/envio_email', 'id="email_form" rel="preventDoubleSubmission"'); ?>                                                 
            <div class="row">                
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>                
                <div class="col-md-12">
                    <div class="form-group">                    
                        <label> Email</label>
                        <input type="text" class="form-control" name="email" autofocus="">                            
                    </div>
                </div>                
            </div>
            
            <hr>
            
            <div class="row">                
                <div class="box box_registro">
                    <div class="col-md-12">
                        <div class="form-group">                                                                    
                            <label> Titulo del Mensaje</label>
                            <input type="text" class="form-control" name="titulo">                                                    
                        </div>
                    </div>                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Mensaje</label>                    
                            <textarea class="form-control" id="content" name="contenido" rows="25"></textarea>                        
                            <?php echo display_ckeditor($ckeditor); ?>
                        </div>                                                                               
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-primary"> Enviar</button>
                        </div>
                    </div>
                    <input type="hidden" name="accion" value="send-invitacion">                
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php echo form_close(); ?>            
        </div>
    </div>
    <br>

</div>
