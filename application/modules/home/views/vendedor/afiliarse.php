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
                    <p class="lead">Complete el formulario a continuación, esta informacion sera la que veran los clientes que visiten sus productos y su apartado personal.</p>                    
                    <?php echo form_open('usuario/afiliacion/registrar','id="form_afiliarse"'); ?>                 
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">                                
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nombre_empresa" placeholder="Nombre de la Empresa">
                                    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea class="form-control" name="descripcion" rows="4" cols="20"></textarea>                    
                            </div>
                            <div class="form-group"> 
                                <?php echo form_dropdown('actividad', vendedor_actividad_dropdown(), null, 'id="actividad" class="form-control"') ?>
                            </div>
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
                    <div class="box-footer">
                        <div class="pull-left">

                        </div>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-template-main">Registrar Informacion y Continuar<i class="fa fa-chevron-right"></i>
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