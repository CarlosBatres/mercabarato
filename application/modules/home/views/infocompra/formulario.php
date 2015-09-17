<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Infocompras - General</h1>
            </div>

        </div>
    </div>
</div>

<div id="content" class="clearfix">
    <div class="container">
        <div class="col-md-12">
            <?php echo form_open('infocompras/paso-1','id="infocompras-general"'); ?>                             
            <div class="row">            
                <h3>Datos de Contacto</h3>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" class="form-control" name="nombres" value="<?php echo (isset($datos_contacto)) ? $datos_contacto->cliente->nombres : "" ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" value="<?php echo (isset($datos_contacto)) ? $datos_contacto->cliente->apellidos : "" ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefono de Contacto ( Opcional )</label>
                        <input type="text" class="form-control" name="telefono_contacto" value="<?php echo (isset($datos_contacto)) ? $datos_contacto->cliente->telefono_fijo : "" ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Correo Electronico</label>
                        <input type="text" class="form-control" name="email" value="<?php echo (isset($datos_contacto)) ? $datos_contacto->usuario->email : "" ?>" <?php echo (isset($datos_contacto)) ? "disabled" : "" ?>>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="comment">Comentario</label>
                        <textarea class="form-control" rows="4" name="comentario"></textarea>
                    </div>
                </div>                                                                
            </div>
            <br>
            <div class="row">
                <h4>Solamente presupuesto que se ajusten a un precio:</h4>
                <div class="col-md-6">
                    <div class="precios-productos">                                
                        <div class="input-group pull-left">                                                
                            <input type="text" class="form-control" name="precio_desde" placeholder="Desde">                                                                
                        </div>                           

                        <div class="input-group pull-right">                                                                                    
                            <input type="text" class="form-control" name="precio_hasta" placeholder="Hasta">                                                                
                        </div> 
                    </div>   
                </div>
            </div>
            <br>
            <div class="row">
                <h4>Seleccione uno a continuación:</h4>
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" name="tipo" id="regalos" value="1"> Regalos
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" name="tipo" id="servicios" value="2"> Servicios
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="radio-inline">
                                    <input type="radio" name="tipo" id="compra_ocasional" value="3"> Compra Ocasional
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" name="tipo" id="ocio" value="4"> Ocio
                                </label>
                            </div>
                            <div class="col-md-3">
                                <label class="radio-inline">
                                    <input type="radio" name="tipo" id="otras_compras" value="5"> Otras Compras
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row tipo-regalo" style="display:none;">
                <div class="col-md-12">
                    <div class="panel panel-primary infocompras-radios">
                        <div class="panel-body">                            
                            <div class="row">                                

                                <div class="col-md-3 col-md-offset-1">                                    
                                    <label><strong>Tipo</strong></label>
                                    <div class="radio">
                                        <label class="radio">
                                            <input type="radio" name="regalo_tipo" value="1"> Aniversario
                                        </label>                                                        
                                        <label class="radio">
                                            <input type="radio" name="regalo_tipo" value="2"> Familiares
                                        </label>

                                        <label class="radio">
                                            <input type="radio" name="regalo_tipo" value="3"> Amigos
                                        </label>

                                        <label class="radio">
                                            <input type="radio" name="regalo_tipo" value="4"> Niños / Bebes
                                        </label>

                                        <label class="radio">
                                            <input type="radio" name="regalo_tipo" value="5"> Romantico
                                        </label>
                                    </div>
                                </div>                            
                                <div class="col-md-4">
                                    <label><strong>Sexo</strong></label>
                                    <div class="radio">
                                        <label class="radio">
                                            <input type="radio" name="sexo" value="1"> Hombre
                                        </label>                                                        
                                        <label class="radio">
                                            <input type="radio" name="sexo" value="2"> Mujer
                                        </label>                                    
                                        <label class="radio">
                                            <input type="radio" name="sexo" value="3"> Indistintamente
                                        </label>
                                    </div>
                                </div> 
                                <div class="col-md-4"> 
                                    <label><strong>Edad comprendida entre</strong></label>
                                    <div class="radio">
                                        <label class="radio">
                                            <input type="radio" name="edad" value="1"> 10-15 Años
                                        </label>                                                        
                                        <label class="radio">
                                            <input type="radio" name="edad" value="2"> 15-20 Años
                                        </label>                                                 
                                        <label class="radio">
                                            <input type="radio" name="edad" value="3"> 20-30 Años
                                        </label>                                            
                                        <label class="radio">
                                            <input type="radio" name="edad" value="4"> 30-50 Años
                                        </label>                                            
                                        <label class="radio">
                                            <input type="radio" name="edad" value="5"> 50-65 Años
                                        </label>                                           
                                        <label class="radio">
                                            <input type="radio" name="edad" value="6"> +65 Años
                                        </label>                      
                                    </div>
                                </div> 
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Gustos o Aficiones</strong></label>
                                        <input type="text" class="form-control" name="gustos" value="">
                                    </div>
                                </div>
                            </div>
                            <br>                            
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row tipo-ocio" style="display:none;">
                <div class="col-md-6">
                    <div class="panel panel-primary infocompras-radios">
                        <div class="panel-body">                            
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="radio">
                                        <label class="radio">
                                            <input type="radio" name="tipo-ocio" value="1"> <strong>Restaurantes</strong>
                                        </label> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="radio">
                                        <label class="radio">
                                            <input type="radio" name="comida" value="1"> Almuerzo
                                        </label> 
                                        <label class="radio">
                                            <input type="radio" name="comida" value="2"> Desayuno
                                        </label> 
                                        <label class="radio">
                                            <input type="radio" name="comida" value="3"> Cena
                                        </label> 
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Fecha comprendida</strong></label>
                                        <input type="text" class="form-control datepicker" name="fecha_inicio_restaurante" placeholder="Desde">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input type="text" class="form-control datepicker" name="fecha_fin_restaurante" placeholder="Hasta">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Cantidad de personas</strong></label>
                                        <input type="text" class="form-control" name="cantidad_personas">
                                    </div>
                                </div>


                            </div>                                                                                  
                        </div>
                    </div>
                </div>                
                <div class="col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-body">                            
                            <div class="row">                                
                                <div class="col-md-12">
                                    <div class="radio">
                                        <label class="radio">
                                            <input type="radio" name="tipo-ocio" value="1"> <strong>Hoteles</strong>
                                        </label> 
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Habitaciones</strong></label>
                                        <input type="text" class="form-control" name="habitaciones">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Fecha comprendida</strong></label>
                                        <input type="text" class="form-control datepicker" name="fecha_inicio_hoteles" placeholder="Desde">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <input type="text" class="form-control datepicker" name="fecha_fin_hoteles" placeholder="Hasta">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Cantidad de personas</strong></label>
                                        <input type="text" class="form-control" name="cantidad_personas">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Alguna Exigencia</strong></label>
                                        <input type="text" class="form-control" name="exigencia">
                                    </div>
                                </div>


                            </div>                                                                                  
                        </div>
                    </div>
                </div> 
            </div>

            <br>
            <hr>
            <div class="row">
                <div class="col-md-12 text-right">
                    <p>Al presionar siguiente confirmas que has leído y aceptas los <a href="<?php echo site_url("site/terminos-de-uso") ?>">Términos del Servicio y Condiciones de Uso</a></p>
                </div>
            </div>

            <br>
            <div class="pull-right">
                <button type="submit" class="btn btn-template-primary"> Siguiente</button>
            </div>                    
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
