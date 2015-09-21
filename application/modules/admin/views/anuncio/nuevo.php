<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Anuncio
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/anuncios'); ?>">Anuncios</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Anuncio Nuevo
                </li>
            </ol>
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
                <?php echo form_open('admin/anuncios/crear', 'id="admin_crear_form"'); ?>                 
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" class="form-control" name="titulo">
                </div>
                <div class="form-group">
                    <label>Contenido</label>                    
                    <textarea class="form-control" name="contenido" rows="10"></textarea>
                </div>                                               
                <hr>
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong>                    
                    <p> Para poder agregar un anuncio al sistema por esta via debe existir al menos un Usuario Vendedor para asociar con este anuncio.</p>                    
                </div>
                <div class="form-group">
                    <label>Vendedor / Empresa</label>
                    <input type="text" class="form-control" name="vendedor">                                        
                    <input type="hidden" name="vendedor_id" id="vendedor_id" value="">                                        
                </div>
                <hr>
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-default"> Crear Anuncio</button>
                </div>
                <input type="hidden" name="accion" value="item-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>