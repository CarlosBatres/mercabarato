<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Pagina del Usuario</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Mi Cuenta</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content" class="clearfix">

    <div class="container">

        <div class="row">

            <!-- *** LEFT COLUMN ***
                 _________________________________________________________ -->

            <div class="col-md-9 clearfix" id="customer-account">                                                
                <div class="box clearfix">
                    <div class="heading">
                        <h3 class="text-uppercase">Datos Personales</h3>
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

                    <?php echo form_open('usuario/datos-personales/modificar', 'id="form_datos_1"'); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">     
                                <label class="label-datos">Nombres</label>
                                <div class="input-group">                                    
                                    <input type="text" class="form-control" name="nombres" placeholder="Vacio" value="<?php echo $cliente->nombres ?>">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">                                    
                                <label class="label-datos">Apellidos</label>
                                <div class="input-group">                                    
                                    <input type="text" class="form-control" name="apellidos" placeholder="Vacio" value="<?php echo $cliente->apellidos ?>">
                                    <span class="input-group-addon"><i class="fa fa-users fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class="row">                    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="label-datos">Fecha de Nacimiento</label>
                                <div class="input-group">                                                                        
                                    <input type="text" id="datepicker" class="form-control" name="fecha_nacimiento" placeholder="Vacio" value="<?php echo ($cliente->fecha_nacimiento != null) ? date("d-m-Y", strtotime($cliente->fecha_nacimiento)) : ''; ?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                    
                        <div class="col-md-3">
                            <div class="form-group">   
                                <label class="label-datos">Código Postal</label>
                                <div class="input-group">                                                                                                            
                                    <input type="text" class="form-control" name="codigo_postal" placeholder="Vacio" value="<?php echo $cliente->codigo_postal; ?>">
                                    <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="label-datos">Sexo</label>
                                <select name="sexo" class="form-control">                        
                                    <option value="X">Seleccione Uno</option>
                                    <option value="H" <?php echo ($cliente->sexo == 'H') ? 'selected' : '' ?>>Hombre</option>
                                    <option value="M" <?php echo ($cliente->sexo == 'M') ? 'selected' : '' ?>>Mujer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class='row'>
                        <div class="col-md-12">
                            <div class="form-group">  
                                <label class="label-datos">Dirección</label>
                                <div class="input-group">                                    
                                    <input type="text" class="form-control" name="direccion" placeholder="Vacio" value="<?php echo $cliente->direccion; ?>"> 
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">     
                                <label class="label-datos">Teléfono Fijo</label>
                                <div class="input-group">                                                                        
                                    <input type="text" class="form-control" name="telefono_fijo" placeholder="Vacio" value="<?php echo $cliente->telefono_fijo; ?>">
                                    <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">   
                                <label class="label-datos">Teléfono Movil</label>
                                <div class="input-group">                                                                        
                                    <input type="text" class="form-control" name="telefono_movil" placeholder="Vacio" value="<?php echo $cliente->telefono_movil; ?>">
                                    <span class="input-group-addon"><i class="fa fa-mobile-phone fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="col-md-12">
                            <p class="lead">Modifica a continuación tus intereses.</p>
                            <?php
                            foreach ($keywords as $keyword):
                                if (in_array($keyword, $mis_intereses)) {
                                    $class = "checked";
                                } else {
                                    $class = "";
                                }
                                ?>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="keywords[]" <?php echo $class ?> value="<?php echo $keyword ?>"><?php echo $keyword ?></label>
                                    </div>
                                </div> 
                            <?php endforeach; ?>
                        </div>                            
                    </div> 
                    <br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-template-main"><i class="fa fa-save"></i> Guardar Cambios</button>
                        </div>
                    </div>                   

                    <input type="hidden" name="accion" value="form-editar">
                    <?php echo form_close(); ?>                    
                    <?php if (!$es_vendedor): ?>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="heading">
                                    <h3 class="text-uppercase">Deseas ofertar sus productos en este Sitio?</h3>
                                </div>                                                
                                <p class="lead">Si desea afiliarse a nuestro sitio y ofertar sus productos aqui, acceda al siguiente apartado y sigua los pasos:</p>                            
                                <br>
                                <a href="<?php echo site_url('usuario/afiliacion') ?>" class="btn btn-template-main" ><i class="fa fa-money"></i> Hazte Vendedor</a>                            
                            </div>
                        </div>
                    <?php endif; ?>

                </div>                 
            </div>                    

            <div class="col-md-3">                       
                <?php echo $html_options; ?>                       
            </div>                    

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>
<!-- /#content -->