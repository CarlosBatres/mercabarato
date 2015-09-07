<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar Paquete
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/paquetes'); ?>">Paquetes</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Paquete Nuevo
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">
                <h2 class="text-uppercase">Informacion del Paquete</h2>                                        
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>                           

                <h3>Seleccione el tipo de paquete</h3>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#productos" role="tab" data-toggle="tab"><strong>Paquete Tipo 1</strong></a></li>
                    <!--<li><a href="#seguros" role="tab" data-toggle="tab"><strong>Paquete Infocompras / Seguros</strong></a></li>-->                    
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="productos">                    
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">                                                                        
                                        <?php echo form_open('admin/paquetes/crear', 'id="productos_crear"'); ?>                 
                                        <!--<input type="hidden" name="tipo" value="productos">-->
                                        <div class="row">
                                            <div class="col-md-12">                                            
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" class="form-control" name="nombre">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Descripcion</label>                    
                                                    <textarea class="form-control" name="descripcion" rows="10"></textarea>
                                                </div>
                                            </div>       
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Costo</label>
                                                            <input type="text" class="form-control" name="costo">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Duracion ( En meses )</label>
                                                            <input type="text" class="form-control" name="duracion">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Desea que se muestre el paquete o quede oculto</label>
                                                    <select class="form-control" name="mostrar">
                                                        <option value="0">Oculto</option>
                                                        <option value="1">Mostrar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Orden en la que se presentan</label>
                                                    <input type="text" class="form-control" name="orden">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-12">
                                                <div class="alert alert-info">
                                                    <strong>Productos / Anuncios</strong>                    
                                                    <p> Si deseas que estos valores sean ilimitados dejalos vacios o de lo contrario ingresa un valor.</p>                    
                                                    <p> Se permite el valor <strong>0</strong> en ese caso no podran insertar productos o anuncios.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Limite Productos</label>
                                                    <input type="text" class="form-control" name="limite_productos">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Limite Anuncios</label>
                                                    <input type="text" class="form-control" name="limite_anuncios">
                                                </div> 
                                            </div>
                                            <div class="col-md-12">
                                                <div class="alert alert-info">
                                                    <strong>Seguros</strong>                    
                                                    <p> Deseas que este paquete pueda presupuestar seguros ?</p>                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Infocompras / Seguros</label>
                                                    <select class="form-control" name="infocompras_seguros">
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary"> Crear Paquete</button>
                                            </div>                    
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>          
                        </div> 
                    </div>
<!--                    <div class="tab-pane" id="seguros">                    
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">                                                                        
                                        <?php echo form_open('admin/paquetes/crear', 'id="seguros_crear"'); ?>                 
                                        <input type="hidden" name="tipo" value="seguros">
                                        <div class="row">
                                            <div class="col-md-12">                                            
                                                <div class="form-group">
                                                    <label>Nombre</label>
                                                    <input type="text" class="form-control" name="nombre">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Descripcion</label>                    
                                                    <textarea class="form-control" name="descripcion" rows="10"></textarea>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Costo</label>
                                                    <input type="text" class="form-control" name="costo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Duracion ( En meses )</label>
                                                    <input type="text" class="form-control" name="duracion">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Desea que se muestre el paquete o quede oculto</label>
                                                    <select class="form-control" name="mostrar">
                                                        <option value="0">Oculto</option>
                                                        <option value="1">Mostrar</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Orden en la que se presentan</label>
                                                    <input type="text" class="form-control" name="orden">
                                                </div>
                                            </div>                                            
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary"> Crear Paquete</button>
                                            </div>                    
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>          
                        </div> 
                    </div>-->
                </div>                                
            </div>
        </div>
    </div>
    <br>
</div>