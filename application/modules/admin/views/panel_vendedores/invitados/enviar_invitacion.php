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
            <div class="box box_registro">                
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('panel_vendedor/invitaciones/enviar/' . $cliente->id, 'id="enviar_invitacion" rel="preventDoubleSubmission"'); ?>                                 
                <div class="col-md-12">
                    <div class="form-group"> 
                        <label> Titulo del Mensaje</label>
                        <input type="text" class="form-control" name="titulo">                            
                    </div>
                </div>                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Mensaje</label>                    
                        <textarea class="form-control" id="content" name="contenido" rows="15"></textarea>                        
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
    </div>
    <br>

</div>