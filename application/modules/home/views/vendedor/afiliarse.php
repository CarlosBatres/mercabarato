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
                    <p class="lead">Complete el formulario a continuación, esta información sera la que vean los clientes que visiten sus productos y su apartado personal.</p>                    
                    <?php echo form_open('usuario/afiliacion/registrar', 'id="form_afiliarse"'); ?>                 

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nickname" placeholder="Apodo o Nickname">
                                    <span class="input-group-addon"><i class="fa fa-user-secret fa-fw"></i></span>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <p class="lead">Solo permite letras, números y guiones.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nombre_empresa" placeholder="Nombre Comercial de la Empresa">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="4" cols="20"></textarea>                    
                            </div>
                        </div>
                    </div>
                    <div class="row">                       
                        <div class="col-md-6">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nif_cif" placeholder="N.I.F / C.I.F">
                                    <span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="sitio_web" placeholder="Sitio Web">
                                    <span class="input-group-addon"><i class="fa fa-sitemap fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <div class='row'>
                        <div class="col-md-12">
                            <div class="form-group">                                
                                <div class="input-group">                                    
                                    <input type="text" class="form-control" name="direccion" placeholder="Dirección Fiscal" value='<?php echo $cliente->direccion ?>'>
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
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="lead">Si quieres que tus productos estén restringidos a una zona en particular indicarlo a continuación, de lo contrario aparecerán en búsquedas en toda España.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">                                
                                <select name="provincia" class="form-control">
                                    <option value="0">Provincias</option>
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
                                <select name="poblacion" class="form-control">
                                    <option value="0">Población</option>                        
                                    <?php foreach ($poblaciones as $poblacion): 
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
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="lead">Indica a continuación de manera general que tipos de productos vas a vender.</p>
                            <?php foreach ($keywords as $keyword): ?>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="keywords[]" value="<?php echo $keyword ?>"><?php echo $keyword ?></label>
                                    </div>
                                </div> 
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class='col-md-12'>
                            <p class="lead">Indica a continuación tus puntos de venta registrados. ( Opcionales )</p>
                        </div>
                        <div class='col-md-12'>
                            <p><strong>Punto de Venta 1.</strong></p>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nombre_punto_venta_1" placeholder="Nombre">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="direccion_punto_venta_1" placeholder="Dirección">
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                            
                        <div class='col-md-12'>
                            <p><strong>Punto de Venta 2.</strong></p>
                        </div>                       
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nombre_punto_venta_2" placeholder="Nombre">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="direccion_punto_venta_2" placeholder="Dirección">
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                            
                        <div class='col-md-12'>
                            <p><strong>Punto de Venta 3.</strong></p>
                        </div>                        
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nombre_punto_venta_3" placeholder="Nombre">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="direccion_punto_venta_3" placeholder="Dirección">
                                    <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                </div>
                            </div>
                        </div>                            

                    </div>
                    <div class="box-footer">
                        <div class="pull-left">

                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-template-main">Registrar información y Continuar<i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="accion" value="form-editar">
                    <?php echo form_close(); ?>
                    <hr>                    
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