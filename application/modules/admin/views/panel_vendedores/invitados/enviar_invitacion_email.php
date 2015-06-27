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
        <div class="col-md-5 col-md-offset-3">
            <div class="box box_registro">
                <h2 class="text-uppercase">Invitación</h2>                              
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('panel_vendedor/invitaciones/envio_email', 'id="send_form"'); ?>                 
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email">
                </div>
                <hr>
                <div class="alert alert-success">
                    <strong>Recuerde:</strong>                    
                    <p> Si desea realizar una invitación personalizada llene los datos a continuación..</p>                    
                    <p> para enviar la invitacion presione <strong>enviar</strong></p>                    
                </div>
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" class="form-control" name="titulo" value="">
                </div>
                <div class="form-group">
                    <label>Comentario</label>                    
                    <textarea class="form-control" name="comentario" rows="5"></textarea>
                </div>                                                                               
                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-primary"> Enviar</button>
                </div>
                <input type="hidden" name="accion" value="send-invitacion">                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>