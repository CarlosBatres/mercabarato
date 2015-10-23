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
                    <?php if ($this->session->flashdata('warning')) { ?>
                        <div class="alert alert-warning"> 
                            <a class="close" data-dismiss="alert">×</a>
                            <?= $this->session->flashdata('warning') ?> 
                        </div>
                    <?php } ?>                                          
                    <div class="heading">
                        <h3 class="text-uppercase">Datos del Vendedor</h3>
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
                    <?php echo form_open('usuario/datos-vendedor/modificar', 'id="form_datos_2" rel="preventDoubleSubmission"'); ?>                                                                        
                    <?php if ($usuario->nickname==null): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="label-datos">Apodo o Nickname</label>
                                <div class="form-group">                                
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nickname" placeholder="Vacio" value="<?php echo $usuario->nickname ?>">
                                        <span class="input-group-addon"><i class="fa fa-user-secret fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br><p class="lead">Solo permite letras, números y guiones.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="label-datos">Nombre Comercial de la Empresa</label>
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nombre_empresa" placeholder="Vacio" value="<?php echo $vendedor->nombre ?>">
                                    <span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="label-datos">Breve Descripción</label>
                            <div class="form-group">                                    
                                <textarea class="form-control" name="descripcion" rows="4" cols="20"><?php echo $vendedor->descripcion ?></textarea>                    
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--                            <div class="col-md-6">
                                                        <label class="label-datos">Actividad</label>
                                                        <div class="form-group"> 
                        <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), $vendedor->actividad, 'id="actividad" class="form-control"') ?>
                                                        </div>
                                                    </div>-->
                        <div class="col-md-6">
                            <label class="label-datos">N.I.F / C.I.F</label>
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nif_cif" placeholder="Vacio" value="<?php echo $vendedor->nif_cif ?>">
                                    <span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="label-datos">Sitio Web</label>
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="sitio_web" placeholder="Vacio" value="<?php echo $vendedor->sitio_web ?>">
                                    <span class="input-group-addon"><i class="fa fa-sitemap fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class='row'>
                        <div class="col-md-12">
                            <label class="label-datos">Dirección Fiscal ( Factura )</label>
                            <div class="form-group">
                                <div class="input-group">                                    
                                    <input type="text" class="form-control" name="direccion" placeholder="Vacio" value='<?php echo $vendedor->direccion ?>'>
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="label-datos">Teléfono</label>
                            <div class="form-group">
                                <div class="input-group">                                                                        
                                    <input type="text" class="form-control" name="telefono_fijo" placeholder="Vacio" value='<?php echo $vendedor->telefono_fijo ?>'>
                                    <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="label-datos">Teléfono móvil</label>
                            <div class="form-group">
                                <div class="input-group">                                                                        
                                    <input type="text" class="form-control" name="telefono_movil" placeholder="Vacio" value='<?php echo $vendedor->telefono_movil ?>'>
                                    <span class="input-group-addon"><i class="fa fa-mobile-phone fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                           
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="lead">Modifica a continuación las categorías a la que pertenecen tus productos.</p>
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
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="lead">Modifica a continuación tu localidad.</p>
                            <p>Si quieres que tus productos estén restringidos a una zona en particular indicarlo a continuación, de lo contrario aparecerán en búsquedas en toda España.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">    
                                <label class="label-datos">Provincia</label>
                                <select name="provincia" class="form-control">
                                    <option value="0">Seleccione una</option>
                                    <?php
                                    foreach ($provincias as $provincia):
                                        $class = "";
                                        if ($provincia_id == $provincia->id) {
                                            $class = "selected";
                                        }
                                        ?>
                                        <option <?php echo $class; ?> value="<?php echo $provincia->id ?>"><?php echo $provincia->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">    
                                <label class="label-datos">Población</label>
                                <select name="poblacion" class="form-control">
                                    <option value="0">Seleccione una</option>                        
                                    <?php
                                    foreach ($poblaciones as $poblacion):
                                        $class = "";
                                        if ($poblacion_id == $poblacion->id) {
                                            $class = "selected";
                                        }
                                        ?>
                                        <option <?php echo $class; ?> value="<?php echo $poblacion->id ?>"><?php echo $poblacion->nombre ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div> 
                    <hr>
                    <div class="row">
                        <div class='col-md-12'>
                            <p class="lead">Modifica a continuación tus puntos de venta registrados.</p>
                        </div>
                        <div class='col-md-12'>
                            <p><strong>Punto de Venta 1.</strong></p>
                        </div>
                        <?php
                        if (isset($puntos_venta["0"])) {
                            $text_nombre = $puntos_venta["0"]->nombre;
                            $text_direccion = $puntos_venta["0"]->direccion;
                            $id = $puntos_venta["0"]->id;
                        } else {
                            $text_nombre = "";
                            $text_direccion = "";
                            $id = "";
                        }
                        ?>
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <div class="input-group">  
                                    <input type="hidden" name="id_punto_venta_1" value='<?php echo $id ?>'>
                                    <input type="text" class="form-control" name="nombre_punto_venta_1" placeholder="Nombre" value='<?php echo $text_nombre ?>'>
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">                                
                                <div class="input-group">                                    
                                    <input type="text" class="form-control" name="direccion_punto_venta_1" placeholder="Dirección" value='<?php echo $text_direccion ?>'>
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                            
                        <div class='col-md-12'>
                            <p><strong>Punto de Venta 2.</strong></p>
                        </div>  
                        <?php
                        if (isset($puntos_venta["1"])) {
                            $text_nombre = $puntos_venta["1"]->nombre;
                            $text_direccion = $puntos_venta["1"]->direccion;
                            $id = $puntos_venta["1"]->id;
                        } else {
                            $text_nombre = "";
                            $text_direccion = "";
                            $id = "";
                        }
                        ?>
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="hidden" name="id_punto_venta_2" value='<?php echo $id ?>'>
                                    <input type="text" class="form-control" name="nombre_punto_venta_2" placeholder="Nombre" value='<?php echo $text_nombre ?>'>
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="direccion_punto_venta_2" placeholder="Dirección" value='<?php echo $text_direccion ?>'>
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                            
                        <div class='col-md-12'>
                            <p><strong>Punto de Venta 3.</strong></p>
                        </div> 
                        <?php
                        if (isset($puntos_venta["2"])) {
                            $text_nombre = $puntos_venta["2"]->nombre;
                            $text_direccion = $puntos_venta["2"]->direccion;
                            $id = $puntos_venta["2"]->id;
                        } else {
                            $text_nombre = "";
                            $text_direccion = "";
                            $id = "";
                        }
                        ?>
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="hidden" name="id_punto_venta_3" value='<?php echo $id ?>'>
                                    <input type="text" class="form-control" name="nombre_punto_venta_3" placeholder="Nombre" value='<?php echo $text_nombre ?>'>
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="direccion_punto_venta_3" placeholder="Dirección" value='<?php echo $text_direccion ?>'>
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                            

                    </div>
                    <br>
                    <hr>
                    <div class="row">                        
                        <div class="col-xs-6">
                            <p class="lead"> Imagen representativa de la empresa.</p>
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
                                            <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('util/upload_vendedor_image') ?>">                                        
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <label><strong>Seleccione una imagen que lo represente.</strong></label>                    
                                    <input id="fileupload" type="file" name="files" data-url="<?php echo site_url('util/upload_vendedor_image') ?>">                                        
                                <?php endif; ?>
                                <input type="hidden" name="file_name" id="file_name" value="">                                                            
                            </div>                            
                        </div>
                        <div class="col-xs-12">
                            <div class="alert alert-danger" id="fileupload_alert" style="display:none;"> 
                                <a class="close" data-dismiss="alert">×</a>
                                <span>Error</span>
                            </div>
                        </div>
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-template-primary"><i class="fa fa-save"></i> Guardar Cambios</button>
                        </div>
                    </div>




                    <input type="hidden" name="accion" value="form-editar">
                    <?php echo form_close(); ?>                                        

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