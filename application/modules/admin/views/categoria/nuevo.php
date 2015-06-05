<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Nueva Categoria
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/categorias'); ?>">Categorias</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Nueva Categoria
                </li>
            </ol>
        </div>
    </div>    
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion de la Categoria</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('admin/categorias/crear', 'id="admin_categoria_form"'); ?>                 
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>
                    <textarea name="descripcion" class="form-control" rows="4" cols="20"></textarea>                    
                </div>
                <div class="form-group">
                    <label>Imagen para la Categoria</label>                    
                    <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('admin/categoria/upload_image') ?>">
                    <input type="hidden" name="file_name" id="file_name" value="">                                                            
                </div>  
                <hr>                
                <div class="text-center">
                    <button type="submit" id="admin_form_submit" class="btn btn-lg btn-default"> Crear Categoria</button>
                </div>
                <input type="hidden" name="accion" value="form-crear">
                <input type="hidden" name="padre_id" value="<?php echo $padre_id;?>">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>