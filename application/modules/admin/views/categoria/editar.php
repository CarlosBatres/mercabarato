<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Categoria
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Dashboard</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/categorias'); ?>">Categorias</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Editar Categoria - <?php echo $categoria->nombre ?>
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion de la Categoria</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('admin/categorias/editar/' . $categoria->id, 'id="admin_edit_form"'); ?>                 
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control" readonly name="id" value="<?php echo $categoria->id; ?>">
                </div>                
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $categoria->nombre; ?>">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>
                    <textarea name="descripcion" rows="4" class="form-control" cols="20"><?php echo $categoria->descripcion; ?></textarea>
                </div>                
                <hr>    
                <div class="text-center">
                    <button type="submit" id="admin_form_submit" class="btn btn-lg btn-default"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="form-editar">
                <input type="hidden" name="padre_id" value="<?php echo $categoria->padre_id;?>">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>