<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Aprobar paquete
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li class="active">
                    <i class="fa fa-inbox"></i> Vendedor-Paquetes
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">

            <div class="panel panel-primary">
                <div class="panel-heading">                    
                    <h3 class="panel-title">
                        <strong>Información del vendedor</strong>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <p> <strong>Nombre:</strong></p>
                        </div>
                        <div class="col-md-10 text-left">
                            <p><?php echo $vendedor->nombre ?></p>
                        </div>                     
                    </div>                    
                    <?php if ($vendedor->descripcion != null && $vendedor->descripcion != ""): ?>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <p> <strong>Descripcion:</strong></p>
                            </div>
                            <div class="col-md-10 text-left">
                                <p><?php echo $vendedor->descripcion ?></p>
                            </div>                     
                        </div>
                    <?php endif; ?>
                    <?php if ($vendedor->direccion != null && $vendedor->direccion != ""): ?>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <p> <strong>Direccion:</strong></p>
                            </div>
                            <div class="col-md-10 text-left">
                                <p><?php echo $vendedor->direccion ?></p>
                            </div>                     
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <p> <strong>NIF - CIF:</strong></p>
                        </div>
                        <div class="col-md-10 text-left">
                            <p><?php echo $vendedor->nif_cif ?></p>
                        </div>                     
                    </div>
                    <?php if ($vendedor->sitio_web != null && $vendedor->sitio_web != ""): ?>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <p> <strong>Sitio Web:</strong></p>
                            </div>
                            <div class="col-md-10 text-left">
                                <p><?php echo $vendedor->sitio_web ?></p>
                            </div>                                             
                        </div> 
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <p> <strong>Email:</strong></p>
                        </div>
                        <div class="col-md-10 text-left">
                            <p><?php echo $usuario->email ?></p>
                        </div>                     
                    </div>
                </div>
            </div>
            <?php echo form_open('admin/vendedor_paquetes/do_aprobar'); ?>
            <div class="panel panel-info">
                <div class="panel-heading">                    
                    <h3 class="panel-title">
                        <strong>Vendedor / Administrador Encargado</strong>
                    </h3>
                </div>
                <div class="panel-body">
                    <p>Deseas asignar a un <strong>Vendedor/Administrador</strong> para que quede encargado de manejar a este vendedor y todos sus productos?</p>
                    <br>
                    <div class="row">                                                    
                        <div class="col-xs-6 col-xs-offset-2">
                            <div class="form-group"> 
                                <label>Administrado Por:</label>                                   
                                <select name="aprobado_por" class="form-control">
                                    <option value="0"> Seleccione Uno</option>                                    
                                    <?php foreach ($vendedor_administrador as $vend): ?>
                                        <option value="<?php echo $vend->id ?>"> <?php echo $vend->email ?></option>                                    
                                    <?php endforeach; ?>
                                </select>                                    
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">                    
                    <h3 class="panel-title">
                        <strong>Información del paquete</strong>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <p> <strong>Nombre:</strong></p>
                        </div>
                        <div class="col-md-10 text-left">
                            <p><?php echo $vendedor_paquete->nombre_paquete ?></p>
                        </div>                     
                    </div>                    
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <p> <strong>Costo:</strong></p>
                        </div>
                        <div class="col-md-10 text-left">
                            <p><?php echo $vendedor_paquete->monto_a_cancelar ?> EUR</p>
                        </div>                     
                    </div>
                    <div class="row">                            
                        <div class="col-xs-2">
                            <div class="form-group text-right">                            
                                <label>Fecha Comprado:</label>                                   
                            </div>
                        </div> 
                        <div class="col-xs-10">
                            <div class="form-group">                                                                
                                <p><?php echo date("d-M-Y", strtotime($vendedor_paquete->fecha_comprado)) ?>
                            </div>
                        </div> 
                    </div>
                    <br>                        
                    <div class="row">                                                
                        <div class="col-xs-6 col-xs-offset-2">
                            <button type="submit" class="btn btn-success">Aprobar</button>                            
                        </div>
                    </div>
                </div>
            </div>             
            <input type="hidden" name="vendedor_paquete_id" value="<?php echo $vendedor_paquete->id ?>">
            <?php echo form_close(); ?>

        </div>
    </div>    
</div>