<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Anuncio
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Información del Anuncio</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('panel_vendedor/anuncio/agregar', 'id="admin_crear_form" rel="preventDoubleSubmission"'); ?>                 
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" class="form-control" name="titulo">
                </div>
                <div class="form-group">
                    <label>Contenido</label>                    
                    <textarea class="form-control" id="content" name="contenido" rows="10"></textarea>                                        
                    <?php echo display_ckeditor($ckeditor); ?>
                </div>
                <div class="col-xs-12 pull-left">
                    <p class="lead"><a href="<?php echo assets_url("files/Tutorial_subir_imagenes_con_ckeditor.pdf") ?>" target="_blank"><strong>Como subir imagenes?</strong></a></p>                    
                </div>

                <hr>
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Siguiente</button>
                </div>
                <input type="hidden" name="accion" value="item-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>