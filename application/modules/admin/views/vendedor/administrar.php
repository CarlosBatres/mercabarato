<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Administrar Usuario Vendedor
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="<?php echo site_url('admin'); ?>">Resumen</a>
                </li>
                <li>
                    <i class="fa fa-inbox"></i> <a href="<?php echo site_url('admin/vendedores'); ?>">Vendedores</a>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> Administrar Vendedor
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
                            <p><?php echo $identidad->vendedor->nombre ?></p>
                        </div>                     
                    </div>                    
                    <?php if ($identidad->vendedor->descripcion != null && $identidad->vendedor->descripcion != ""): ?>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <p> <strong>Descripcion:</strong></p>
                            </div>
                            <div class="col-md-10 text-left">
                                <p><?php echo $identidad->vendedor->descripcion ?></p>
                            </div>                     
                        </div>
                    <?php endif; ?>
                    <?php if ($identidad->vendedor->direccion != null && $identidad->vendedor->direccion != ""): ?>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <p> <strong>Direccion:</strong></p>
                            </div>
                            <div class="col-md-10 text-left">
                                <p><?php echo $identidad->vendedor->direccion ?></p>
                            </div>                     
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <p> <strong>NIF - CIF:</strong></p>
                        </div>
                        <div class="col-md-10 text-left">
                            <p><?php echo $identidad->vendedor->nif_cif ?></p>
                        </div>                     
                    </div>
                    <?php if ($identidad->vendedor->sitio_web != null && $identidad->vendedor->sitio_web != ""): ?>
                        <div class="row">
                            <div class="col-md-2 text-right">
                                <p> <strong>Sitio Web:</strong></p>
                            </div>
                            <div class="col-md-10 text-left">
                                <p><?php echo $identidad->vendedor->sitio_web ?></p>
                            </div>                                             
                        </div> 
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-2 text-right">
                            <p> <strong>Email:</strong></p>
                        </div>
                        <div class="col-md-10 text-left">
                            <p><?php echo $identidad->usuario->email ?></p>
                        </div>                     
                    </div>
                </div>
            </div>

            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('success') ?> 
                </div>
            <?php } ?>   
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('error') ?> 
                </div>
            <?php } ?>

            <?php
            if ($paquete_curso):
                /*
                 *  
                 *   PAQUETE EN CURSO
                 * 
                 */
                ?>                 
                <div class="panel panel-primary paquete">
                    <div class="panel-heading">                        
                        <h3 class="panel-title">
                            <strong>Informacion de paquete en curso</strong>
                        </h3>
                    </div>
                    <?php echo form_open('admin/vendedores/modificar'); ?>                    
                    <div class="panel-body">
                        <div class="col-md-12 info-header">
                            <p>A continuacion se muestra la informacion referente al paquete.</p>
                            <p>- Si quieres modificar algun parametro has click en  <i class="glyphicon glyphicon-edit"></i> y luego guarda los cambios</p>
                        </div>                        
                        <div class="col-md-12">
                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Nombre:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="nombre" value="<?php echo $paquete_curso->nombre_paquete ?>" disabled="">
                                    </div>
                                </div> 
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Fecha Comprado:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="fecha_comprado" value="<?php echo date("d-M-Y", strtotime($paquete_curso->fecha_comprado)) ?>" disabled="">
                                    </div>
                                </div> 
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Fecha Inicio:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="fecha_inicio" value="<?php echo date("d-M-Y", strtotime($paquete_curso->fecha_inicio)) ?>" disabled="">
                                    </div>
                                </div> 
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Fecha Terminar:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="fecha_terminar" value="<?php echo date("d-M-Y", strtotime($paquete_curso->fecha_terminar)) ?>" disabled="">
                                    </div>
                                </div> 
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Limite Productos:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="limite_productos" value="<?php echo $paquete_curso->limite_productos ?>" disabled="">
                                    </div>
                                </div>
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div> 

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Limite Anuncios:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="limite_anuncios" value="<?php echo $paquete_curso->limite_anuncios ?>" disabled="">
                                    </div>
                                </div>
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Infocompras / Seguros</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group"> 
                                        <select name="infocompra" class="form-control" disabled>
                                            <?php if ($paquete_curso->infocompra == "1"): ?>
                                                <option selected value="1"> Si</option>
                                                <option value="0"> No</option>
                                            <?php else: ?>    
                                                <option value="1"> Si</option>
                                                <option selected value="0"> No</option>
                                            <?php endif; ?>                                                                                
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <p>Deseas asignar a un <strong>Vendedor/Administrador</strong> para que quede encargado de manejar a este vendedor y todos sus productos?</p>
                                    <br>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Administrado Por:</label>                                   
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">                                         
                                        <select name="autorizado_por" class="form-control" disabled>
                                            <option value="0"> Seleccione Uno</option>                                    
                                            <?php foreach ($vendedor_administrador as $vend): 
                                                $class="";
                                                if($paquete_curso->autorizado_por==$vend->id){
                                                    $class="selected";
                                                }
                                                ?>                                            
                                                <option <?php echo $class;?> value="<?php echo $vend->id ?>"> <?php echo $vend->email ?></option>                                    
                                            <?php endforeach; ?>
                                        </select>                                    
                                    </div>
                                </div>                       
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div>
                            <br>                        
                            <div class="row">                                                
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                                    <button type="button" class="btn btn-danger" id="eliminar-paquete-curso">Eliminar paquete</button>
                                </div>
                            </div>                             
                        </div>
                    </div>
                    <input type="hidden" name="accion" value="modificar-paquete-curso">
                    <input type="hidden" name="vendedor_id" value="<?php echo $identidad->vendedor->id ?>">                    
                </div>                
                <?php echo form_close(); ?>

                <?php
            elseif ($paquete_pendiente):
                /*
                 *  
                 *  PAQUETE PENDIENTE
                 * 
                 */
                ?>                   
                <div class="panel panel-warning paquete">
                    <div class="panel-heading">                        
                        <h3 class="panel-title">
                            <strong>Informacion de paquete pendiente por aprobación</strong>
                        </h3>
                    </div>
                    <?php echo form_open('admin/vendedores/modificar'); ?>                    
                    <div class="panel-body">
                        <div class="col-md-12 info-header">
                            <p>A continuacion se muestra la informacion referente al paquete.</p>
                            <p>- Si quieres modificar algun parametro has click en  <i class="glyphicon glyphicon-edit"></i> y luego guarda los cambios</p>
                            <p>- Tambien si lo deseas puedes aprobar el paquete desde aqui pero no se enviara ningun correo.</p>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Nombre:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="nombre" value="<?php echo $paquete_pendiente->nombre_paquete ?>" disabled="">
                                    </div>
                                </div> 
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Fecha Comprado:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="fecha_comprado" value="<?php echo date("d-M-Y", strtotime($paquete_pendiente->fecha_comprado)) ?>" disabled="">
                                    </div>
                                </div> 
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Limite Productos:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="limite_productos" value="<?php echo $paquete_pendiente->limite_productos ?>" disabled="">
                                    </div>
                                </div>
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div> 

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Limite Anuncios:</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group">                                                                
                                        <input type="text" class="form-control" name="limite_anuncios" value="<?php echo $paquete_pendiente->limite_anuncios ?>" disabled="">
                                    </div>
                                </div>
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div>

                            <div class="row">                            
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Infocompras / Seguros</label>                                   
                                    </div>
                                </div> 
                                <div class="col-xs-6">
                                    <div class="form-group"> 
                                        <select name="infocompra" class="form-control" disabled>
                                            <?php if ($paquete_pendiente->infocompra == "1"): ?>
                                                <option selected value="1"> Si</option>
                                                <option value="0"> No</option>
                                            <?php else: ?>    
                                                <option value="1"> Si</option>
                                                <option selected value="0"> No</option>
                                            <?php endif; ?>                                                                                
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div>                                                 
                            <div class="row">
                                <div class="col-xs-12">
                                    <p>Deseas asignar a un <strong>Vendedor/Administrador</strong> para que quede encargado de manejar a este vendedor y todos sus productos?</p>
                                    <br>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group text-right">                            
                                        <label>Administrado Por:</label>                                   
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">                                         
                                        <select name="autorizado_por" class="form-control" disabled>
                                            <option value="0"> Seleccione Uno</option>                                    
                                            <?php foreach ($vendedor_administrador as $vend): 
                                                $class="";
                                                if($paquete_pendiente->autorizado_por==$vend->id){
                                                    $class="selected";
                                                }
                                                ?>                                            
                                                <option <?php echo $class;?> value="<?php echo $vend->id ?>"> <?php echo $vend->email ?></option>                                    
                                            <?php endforeach; ?>
                                        </select>                                    
                                    </div>
                                </div>                       
                                <div class="col-xs-2 side_botones">
                                    <a class="modificar" href="" data-toogle="tooltip"  title="Modificar"><i class="glyphicon glyphicon-edit"></i></a>
                                </div>
                            </div>
                            <br>                             
                            <div class="row">                                                
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info" id="aprobar-paquete-pendiente">Aprobar</button>
                                    <button type="submit" class="btn btn-success" id="modificar-paquete-pendiente">Guardar cambios</button>
                                    <button type="button" class="btn btn-danger" id="eliminar-paquete-pendiente">Eliminar paquete</button>
                                </div>
                            </div>                             
                        </div>
                    </div>
                    <input type="hidden" name="accion" value="modificar-paquete-pendiente">
                    <input type="hidden" name="vendedor_id" value="<?php echo $identidad->vendedor->id ?>">
                    <?php echo form_close(); ?>
                </div>                        

                <?php
            else:
                /*
                 *  SIN PAQUETE
                 * 
                 * 
                 */
                ?>
                <div class="panel panel-danger paquete">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <strong>Sin paquetes</strong>
                        </h3>
                    </div>
                    <?php echo form_open('admin/vendedores/modificar'); ?>
                    <div class="panel-body">
                        <div class="col-xs-12">
                            <div class="row info-header">                                                        
                                <p> Este vendedor no tiene paquetes ( en curso ni pendientes)...</p>
                                <p> - Si desea asignarle un nuevo paquete manualmente puede hacerlo a continuacion:</p>
                            </div>
                            <div class="row">                                                        
                                <div class="col-xs-6 col-xs-offset-2">
                                    <div class="form-group"> 
                                        <label>Paquetes Disponibles</label>                                   
                                        <select name="paquete" class="form-control">                                        
                                            <option value="0"> Seleccione Uno </option>                                            
                                            <?php foreach ($paquetes as $paquete): ?>
                                                <option value="<?php echo $paquete->id ?>"> <?php echo $paquete->nombre ?></option>                                            
                                            <?php endforeach; ?>
                                        </select>                                    
                                    </div>
                                </div>                            
                                <div class="col-xs-8 text-right">                                    
                                    <button type="submit" class="btn btn-success">Asignar Paquete</button>                                    
                                </div>
                            </div>
                            <br>                        
                        </div>
                    </div>
                    <input type="hidden" name="accion" value="asignar-paquete">
                    <input type="hidden" name="vendedor_id" value="<?php echo $identidad->vendedor->id ?>">
                    <?php echo form_close(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <br>

</div>