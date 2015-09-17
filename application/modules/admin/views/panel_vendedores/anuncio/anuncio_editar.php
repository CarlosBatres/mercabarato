<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Anuncio
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del Anuncio</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('panel_vendedor/anuncio/editar/' . $anuncio->id, 'id="admin_edit_form" rel="preventDoubleSubmission"'); ?>                                 
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" class="form-control" name="titulo" value="<?php echo $anuncio->titulo; ?>">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>                                                            
                    <textarea class="form-control" id="content" name="contenido" rows="10"><?php echo $anuncio->contenido; ?></textarea>                                        
                    <?php echo display_ckeditor($ckeditor); ?>
                </div>                                                                                             
                <div class="text-center">
                    <button type="submit" id="admin_submit" class="btn btn-lg btn-primary"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="item-editar">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>