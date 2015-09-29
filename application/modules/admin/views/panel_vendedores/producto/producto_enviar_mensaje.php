<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Enviar Mensaje
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <div class="box box_registro">                
                <hr>                
                <?php echo form_open("panel_vendedor/producto/responder-mensaje/".$code,"rel='preventDoubleSubmission'"); ?>
                <div class="col-md-12">
                    <div class="form-group"> 
                        <label>Asunto</label>
                        <input type="text" class="form-control" required name="titulo" placeholder="Asunto del Mensaje">
                    </div>
                </div>                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Mensaje</label>                    
                        <textarea class="form-control" required id="mensaje" name="mensaje" rows="15"></textarea>
                        <?php echo display_ckeditor($ckeditor); ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary"> Continuar</button>
                    </div>
                </div>                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>