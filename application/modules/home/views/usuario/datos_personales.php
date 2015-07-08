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
                    <?php if (!$es_vendedor): ?>
                        <div class="heading">
                            <h3 class="text-uppercase">Datos Personales</h3>
                        </div>
                    <?php else: ?>
                        <div class="heading">
                            <h3 class="text-uppercase">Datos Empresa</h3>
                        </div>
                    <?php endif; ?>

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
                    <?php if (!$es_vendedor): ?>
                        <?php echo form_open('usuario/datos-personales/modificar', 'id="form_datos_1"'); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">                                    
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nombres" placeholder="Nombres" value="<?php echo $cliente->nombres ?>">
                                        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">                                    
                                    <div class="input-group">                                    
                                        <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" value="<?php echo $cliente->apellidos ?>">
                                        <span class="input-group-addon"><i class="fa fa-users fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                        <div class="row">                    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                                                        
                                        <input type="text" id="datepicker" class="form-control" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" value="<?php echo ($cliente->fecha_nacimiento != null) ? date("d-m-Y", strtotime($cliente->fecha_nacimiento)) : ''; ?>">
                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>                    
                            <div class="col-md-3">
                                <div class="form-group">                                    
                                    <div class="input-group">                                                                                                            
                                        <input type="text" class="form-control" name="codigo_postal" placeholder="Código Postal" value="<?php echo $cliente->codigo_postal; ?>">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">                                    
                                    <select name="sexo" class="form-control">                        
                                        <option value="X">Sexo</option>
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
                                    <div class="input-group">                                    
                                        <input type="text" class="form-control" name="direccion" placeholder="Dirección" value="<?php echo $cliente->direccion; ?>"> 
                                        <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">                                    
                                    <div class="input-group">                                                                        
                                        <input type="text" class="form-control" name="telefono_fijo" placeholder="Teléfono" value="<?php echo $cliente->telefono_fijo; ?>">
                                        <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">                                    
                                    <div class="input-group">                                                                        
                                        <input type="text" class="form-control" name="telefono_movil" placeholder="Teléfono Móvil" value="<?php echo $cliente->telefono_movil; ?>">
                                        <span class="input-group-addon"><i class="fa fa-mobile-phone fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-save"></i> Guardar Cambios</button>
                            </div>
                        </div> 

                    <?php else: ?>  
                        <?php echo form_open('usuario/datos-personales/modificar', 'id="form_datos_2"'); ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">                                    
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nombre_empresa" placeholder="Nombre de la Empresa" value="<?php echo $vendedor->nombre ?>">
                                        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea class="form-control" name="descripcion" rows="4" cols="20"><?php echo $vendedor->descripcion ?></textarea>                    
                                </div>
                                <div class="form-group">                                    
                                    <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), $vendedor->actividad, 'id="actividad" class="form-control"') ?>
                                </div>
                                <div class="form-group">                                    
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="sitio_web" placeholder="Sitio Web" value="<?php echo $vendedor->sitio_web ?>">
                                        <span class="input-group-addon"><i class="fa fa-sitemap fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">                                    
                                        <input type="text" class="form-control" name="direccion" placeholder="Dirección" value='<?php echo $cliente->direccion ?>'>
                                        <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                                                        
                                        <input type="text" class="form-control" name="telefono_fijo" placeholder="Teléfono" value='<?php echo $cliente->telefono_fijo ?>'>
                                        <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                                                        
                                        <input type="text" class="form-control" name="telefono_movil" placeholder="Teléfono Móvil" value='<?php echo $cliente->telefono_movil ?>'>
                                        <span class="input-group-addon"><i class="fa fa-mobile-phone fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">                                    
                                    <?php if ($vendedor->filename != null): ?>
                                        <div class="row">
                                            <hr> 
                                            <div class="preview_imagen_empresa">                        
                                                <img class="thumbnail" src="<?php echo assets_url($this->config->item('vendedores_img_path')) . '/' . $vendedor->filename ?>"/>
                                            </div>                                        
                                        </div>
                                        <br>
                                        <div class="row">
                                            <button type="button" id="cambiar_imagen" class="btn btn-lg btn-default"> Cambiar Imagen</button>
                                            <div class='fileupload_button' style='display:none'>
                                                <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('home/vendedor/upload_image') ?>">                                        
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <label><strong>Seleccione una imagen que lo represente.</strong></label>                    
                                        <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('home/vendedor/upload_image') ?>">                                        
                                    <?php endif; ?>
                                    <input type="hidden" name="file_name" id="file_name" value="">                                                            
                                </div> 
                            </div>
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-save"></i> Guardar Cambios</button>
                            </div>
                        </div>


                    <?php endif; ?>

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
                                <a href="<?php echo site_url('usuario/afiliacion') ?>" class="btn btn-template-main" ><i class="fa fa-money"></i> Afiliación</a>                            
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