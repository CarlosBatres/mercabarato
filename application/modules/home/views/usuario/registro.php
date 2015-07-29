<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Registro</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Registro</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="container">            
        <div class="row row_registro_comprador">        
            <div class="col-md-9 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="heading">
                            <h3 class="text-uppercase">Informacion de la Cuenta</h3>
                        </div>
                        <hr>                
                        <?php echo form_open('registrar_cliente', 'id="form_crear"'); ?>                 
                        <div class="row">  
                            <div class="col-md-12">
                                <div class="form-group">                    
                                    <div class="input-group">                                                
                                        <input type="text" class="form-control" name="email" placeholder="Email" autofocus="">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    </div>                    
                                </div>
                                <div class="form-group">                    
                                    <div class="input-group">                   
                                        <input type="password" class="form-control" name="password" placeholder="Contraseña" autocomplete="off">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">                                           
                                        <input type="password" class="form-control" name="password_confirmar" placeholder="Confirme su Contraseña" autocomplete="off">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>                    
                        <br>
                        <!--                        <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="nickname" placeholder="Nombre de Usuario">
                                                                <span class="input-group-addon"><i class="fa fa-user-secret fa-fw"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">                                    
                                                            <div class="col-sm-10">
                                                                <p class="form-control-static">Se usara para identificarte en el sitio</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nombres" placeholder="Nombres">
                                        <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                    
                                        <input type="text" class="form-control" name="apellidos" placeholder="Apellidos">
                                        <span class="input-group-addon"><i class="fa fa-users fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>                 
                        <div class="row">                    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                                                        
                                        <input type="text" id="datepicker" class="form-control" name="fecha_nacimiento" placeholder="Fecha de Nacimiento">
                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>                    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                                                                                            
                                        <input type="text" class="form-control" name="codigo_postal" placeholder="Código Postal">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>                        
                        </div>                  
                        <div class='row'>
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <div class="input-group">                                                                                                            
                                        <label>Hombre<input type="radio" name="sexo" value="H" class="radioInput"></label>
                                        <label>Mujer<input type="radio" name="sexo" value="F" class="radioInput"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group">                                    
                                        <input type="text" class="form-control" name="direccion" placeholder="Dirección">
                                        <span class="input-group-addon"><i class="fa fa-street-view fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                                                        
                                        <input type="text" class="form-control" name="telefono_fijo" placeholder="Teléfono">
                                        <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">                                                                        
                                        <input type="text" class="form-control" name="telefono_movil" placeholder="Teléfono Móvil">
                                        <span class="input-group-addon"><i class="fa fa-mobile-phone fa-fw"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">                                
                                    <select name="pais" class="form-control">
                                        <option value="0">País</option>
                                        <?php
                                        foreach ($paises as $pais):
                                            $class = "";
                                            if ($pais->nombre == "España") {
                                                $class = "selected";
                                            }
                                            ?>                                        
                                            <option value="<?php echo $pais->id ?>" <?php echo $class ?>><?php echo $pais->nombre ?></option>
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
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="lead">Indica a continuación lo que te interesaria comprar.</p>
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
                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>Al crear una cuenta confirmas que has leído y aceptas los <a href="<?php echo site_url("site/terminos-de-uso") ?>">Términos del Servicio y Condiciones de Uso</a></p>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-template-main"><i class="fa fa-user-md"></i> Registrarse</button>
                        </div>                    
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>          

        </div>            
    </div>
    <!-- /.container -->
</div>


