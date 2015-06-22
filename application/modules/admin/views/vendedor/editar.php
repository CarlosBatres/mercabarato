<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Editar Usuario Vendedor
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/vendedores'); ?>">Vendedores</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Editar Usuario - <?php echo $vendedor->nombre ?>
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del Vendedor</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open('admin/vendedor/editar/' . $vendedor->id, 'id="admin_edit_form"'); ?>                
                
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" class="form-control" readonly name="id" value="<?php echo $vendedor->id; ?>">
                </div>                
                <div class="form-group">
                    <label>Nombre de la Empresa</label>
                    <input type="text" class="form-control" name="nombre_empresa" value="<?php echo $vendedor->nombre; ?>">
                </div>
                <div class="form-group">
                    <label>Descripcion</label>
                    <textarea class="form-control" name="descripcion" rows="4" cols="20"><?php echo $vendedor->descripcion; ?></textarea>                    
                </div>
                <div class="form-group">
                    <label>Actividad</label>
                    <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), $vendedor->actividad, 'id="actividad" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Sitio Web</label>
                    <input type="text" class="form-control" name="sitio_web" value="<?php echo $vendedor->sitio_web; ?>">
                </div>
                <div class='row'>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="<?php echo $vendedor->direccion; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" class="form-control" name="telefono_fijo" value="<?php echo $vendedor->telefono_fijo; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefono Movil</label>
                            <input type="text" class="form-control" name="telefono_movil" value="<?php echo $vendedor->telefono_movil; ?>">
                        </div>
                    </div>
                </div>
                
                
                <hr>                
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong>                    
                    <p> No se deberian modificar estos campos, solo de ser totalmente necesario.</p>
                    <p> El email es el <strong>username</strong> de la cuenta si lo modificas puede que la persona no pueda acceder de nuevo.</p>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" disabled name="email" value="<?php echo $vendedor->email; ?>">
                </div>
                <div class="text-center">
                    <button type="submit" id="admin_form_submit" class="btn btn-lg btn-primary"> Confirmar Cambios</button>
                </div>
                <input type="hidden" name="accion" value="form-editar">                
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>