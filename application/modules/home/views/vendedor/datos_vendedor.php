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
                        <?php echo form_open('usuario/datos-vendedor/modificar', 'id="form_datos_2"'); ?>                                                                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="label-datos">Nombre de la Empresa</label>
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
                            <div class="col-md-6">
                                <label class="label-datos">Actividad</label>
                                <div class="form-group"> 
                                    <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), $vendedor->actividad, 'id="actividad" class="form-control"') ?>
                                </div>
                            </div>
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
                                <label class="label-datos">Dirección</label>
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
                                <label class="label-datos">Teléfono Movil</label>
                                <div class="form-group">
                                    <div class="input-group">                                                                        
                                        <input type="text" class="form-control" name="telefono_movil" placeholder="Vacio" value='<?php echo $vendedor->telefono_movil ?>'>
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
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-save"></i> Guardar Cambios</button>
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