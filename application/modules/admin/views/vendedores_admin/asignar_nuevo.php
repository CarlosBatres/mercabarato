<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Asignar nuevo Vendedor/Administrador
            </h1>            
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
                <?php echo form_open('admin/vendedores_admin/asignar/' . $usuario->id, 'id="form_crear"'); ?>                 
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control" readonly name="id" value="<?php echo $usuario->id; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="titulo" readonly value="<?php echo $usuario->email; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre Completo</label>
                            <input type="text" class="form-control" name="titulo" readonly value="<?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?>">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <p> Si deseas restringir a este vendedor a un area especifica indicalo a continuacion:</p>
                            <p> Una vez restringido solo podra ver a vendedores en su area y aceptar sus paquetes .</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">                                
                            <select name="pais" class="form-control">
                                <option value="0">País</option>
                                <?php foreach ($paises as $pais): ?>
                                    <option value="<?php echo $pais->id ?>"><?php echo $pais->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">                                
                            <select name="provincia" class="form-control">
                                <option value="0">Provincia</option>                        
                            </select>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                        
                            <select name="poblacion" class="form-control">
                                <option value="0">Población</option>                        
                            </select>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <p> Si estas seguro y deseas convertir a este usuario en Vendedor/Administrador presiona continuar</p>                            
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-success"> Continuar</button>
                </div>
                <input type="hidden" name="accion" value="item-editar">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <br>

</div>