<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Infocompras - General</h1>
            </div>
            <div class='col-md-5 text-right'>
                <img class="infocompras-general-icono" src="<?php echo assets_url('imgs/icono-infocompras.png')?>"/>
            </div>
        </div>
    </div>
</div>

<div id="content" class="clearfix">
    <div class="container">

        <div class='row'>
            <div class='col-md-12'>
                <div class="panel panel-primary">
                    <div class="panel-heading"> Pasos a seguir a continuación...</div>
                    <div class="panel-body">
                        <p class='lead'>- Cuando el vendedor responda a su solicitud recibirás un email con la información necesaria.<br>
                            - Luego de respondida una solicitud se podrá realizar una pregunta, solicitar mas información o pedir un mejor precio. <br>
                        - Es importante destacar que se debe estar registrado para poder interactuar con el vendedor. </p>

                        <div class='row'>
                            <div class="col-md-3 pull-right">
                                <div class="pull-right terminar-btn">                        
                                    <a href="<?php echo site_url('infocompras/finalizar') ?>" class="btn btn-lg btn-template-primary"> Finalizar</a>
                                </div>                
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class='row'>
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Información suministrada</div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">            
                                <div class="row">            
                                    <h3>Datos de Contacto</h3>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input type="text" class="form-control" name="nombres" disabled value="<?php echo $informacion["datos_contacto"]["nombres"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Apellidos</label>
                                            <input type="text" class="form-control" name="apellidos" disabled value="<?php echo $informacion["datos_contacto"]["apellidos"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Teléfono de Contacto ( Opcional )</label>
                                            <input type="text" class="form-control" name="telefono_contacto" disabled value="<?php echo $informacion["datos_contacto"]["telefono_contacto"] ?>">
                                        </div>
                                    </div>                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Comentario</label>
                                            <textarea class="form-control" rows="4" disabled name="comentario"><?php echo $informacion["datos_contacto"]["comentario"] ?></textarea>
                                        </div>
                                    </div>                                                                
                                </div>
                                <br>
                                <div class="row">
                                    <h4>Solamente presupuesto que se ajusten a un precio:</h4>
                                    <div class="col-md-6">
                                        <div class="precios-productos">                                
                                            <div class="input-group pull-left">                                                
                                                <input type="text" class="form-control" name="precio_desde" disabled value='<?php echo $informacion["informacion"]["precio_desde"] ?>'>                                                                
                                            </div>                           

                                            <div class="input-group pull-right">                                                                                    
                                                <input type="text" class="form-control" name="precio_hasta" disabled value='<?php echo $informacion["informacion"]["precio_hasta"] ?>'>                                                                
                                            </div> 
                                        </div>   
                                    </div>
                                </div>
                                <br>
                                <div class="row">                                
                                    <div class="col-md-12">
                                        <div class="panel panel-primary">
                                            <div class="panel-body">
                                                <div class="col-md-2">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="tipo" disabled id="regalos" value="1" <?php echo ($informacion["informacion"]["tipo"] == "1") ? "checked" : "" ?>> Regalos
                                                    </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="tipo" disabled id="servicios" value="2" <?php echo ($informacion["informacion"]["tipo"] == "2") ? "checked" : "" ?>> Servicios
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="tipo" disabled id="compra_ocasional" value="3" <?php echo ($informacion["informacion"]["tipo"] == "3") ? "checked" : "" ?>> Compra Ocasional
                                                    </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="tipo" disabled  id="ocio" value="4" <?php echo ($informacion["informacion"]["tipo"] == "4") ? "checked" : "" ?>> Ocio
                                                    </label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="tipo" disabled id="otras_compras" value="5" <?php echo ($informacion["informacion"]["tipo"] == "5") ? "checked" : "" ?>> Otras Compras
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php if ($informacion["informacion"]["tipo"] == "1"): ?>
                                    <div class="row tipo-regalo">
                                        <div class="col-md-12">
                                            <div class="panel panel-primary infocompras-radios">
                                                <div class="panel-body">                            
                                                    <div class="row">                                

                                                        <div class="col-md-3 col-md-offset-1">                                    
                                                            <label><strong>Tipo</strong></label>
                                                            <div class="radio">
                                                                <label class="radio">
                                                                    <input type="radio" name="regalo_tipo" disabled value="1" <?php echo ($informacion["informacion"]["regalo_tipo"] == "1") ? "checked" : "" ?>> Aniversario
                                                                </label>                                                        
                                                                <label class="radio">
                                                                    <input type="radio" name="regalo_tipo" disabled value="2" <?php echo ($informacion["informacion"]["regalo_tipo"] == "2") ? "checked" : "" ?>> Familiares
                                                                </label>

                                                                <label class="radio">
                                                                    <input type="radio" name="regalo_tipo" disabled value="3" <?php echo ($informacion["informacion"]["regalo_tipo"] == "3") ? "checked" : "" ?>> Amigos
                                                                </label>

                                                                <label class="radio">
                                                                    <input type="radio" name="regalo_tipo" disabled value="4" <?php echo ($informacion["informacion"]["regalo_tipo"] == "4") ? "checked" : "" ?>> Niños / Bebes
                                                                </label>

                                                                <label class="radio">
                                                                    <input type="radio" name="regalo_tipo" disabled value="5" <?php echo ($informacion["informacion"]["regalo_tipo"] == "5") ? "checked" : "" ?>> Romantico
                                                                </label>
                                                            </div>
                                                        </div>                            
                                                        <div class="col-md-4">
                                                            <label><strong>Sexo</strong></label>
                                                            <div class="radio">
                                                                <label class="radio">
                                                                    <input type="radio" name="sexo" value="1" disabled <?php echo ($informacion["informacion"]["sexo"] == "1") ? "checked" : "" ?>> Hombre
                                                                </label>                                                        
                                                                <label class="radio">
                                                                    <input type="radio" name="sexo" value="2" disabled <?php echo ($informacion["informacion"]["sexo"] == "2") ? "checked" : "" ?>> Mujer
                                                                </label>                                    
                                                                <label class="radio">
                                                                    <input type="radio" name="sexo" value="3" disabled <?php echo ($informacion["informacion"]["sexo"] == "3") ? "checked" : "" ?>> Indistintamente
                                                                </label>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-4"> 
                                                            <label><strong>Edad comprendida entre</strong></label>
                                                            <div class="radio">
                                                                <label class="radio">
                                                                    <input type="radio" name="edad" value="1" disabled <?php echo ($informacion["informacion"]["edad"] == "1") ? "checked" : "" ?>> 10-15 Años
                                                                </label>                                                        
                                                                <label class="radio">
                                                                    <input type="radio" name="edad" value="2" disabled <?php echo ($informacion["informacion"]["edad"] == "2") ? "checked" : "" ?>> 15-20 Años
                                                                </label>                                                 
                                                                <label class="radio">
                                                                    <input type="radio" name="edad" value="3" disabled <?php echo ($informacion["informacion"]["edad"] == "3") ? "checked" : "" ?>> 20-30 Años
                                                                </label>                                            
                                                                <label class="radio">
                                                                    <input type="radio" name="edad" value="4" disabled <?php echo ($informacion["informacion"]["edad"] == "4") ? "checked" : "" ?>> 30-50 Años
                                                                </label>                                            
                                                                <label class="radio">
                                                                    <input type="radio" name="edad" value="5" disabled <?php echo ($informacion["informacion"]["edad"] == "5") ? "checked" : "" ?>> 50-65 Años
                                                                </label>                                           
                                                                <label class="radio">
                                                                    <input type="radio" name="edad" value="6" disabled <?php echo ($informacion["informacion"]["edad"] == "6") ? "checked" : "" ?>> +65 Años
                                                                </label>                      
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label><strong>Gustos o Aficiones</strong></label>
                                                                <input type="text" class="form-control" name="gustos" disabled value="<?php echo $informacion["informacion"]["gustos"] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>                            
                                                </div>
                                            </div>
                                        </div>                
                                    </div>
                                <?php endif; ?>

                                <?php if ($informacion["informacion"]["tipo"] == "4"): ?>
                                    <div class="row tipo-ocio">
                                        <div class="col-md-6">
                                            <div class="panel panel-primary infocompras-radios">
                                                <div class="panel-body">                            
                                                    <div class="row"> 
                                                        <div class="col-md-12">
                                                            <div class="radio">
                                                                <label class="radio">
                                                                    <input type="radio" name="tipo-ocio" disabled value="1" <?php echo ($informacion["informacion"]["tipo-ocio"] == "1") ? "checked" : "" ?>> <strong>Restaurantes</strong>
                                                                </label> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="radio">
                                                                <label class="radio">
                                                                    <input type="radio" name="comida" disabled value="1" <?php echo ($informacion["informacion"]["comida"] == "1") ? "checked" : "" ?>> Almuerzo
                                                                </label> 
                                                                <label class="radio">
                                                                    <input type="radio" name="comida" disabled value="2" <?php echo ($informacion["informacion"]["comida"] == "2") ? "checked" : "" ?>> Desayuno
                                                                </label> 
                                                                <label class="radio">
                                                                    <input type="radio" name="comida" disabled value="3" <?php echo ($informacion["informacion"]["comida"] == "3") ? "checked" : "" ?>> Cena
                                                                </label> 
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Fecha comprendida</strong></label>
                                                                <input type="text" class="form-control datepicker" disabled name="fecha_inicio_restaurante" value='<?php echo $informacion["informacion"]["fecha_inicio_restaurante"] ?>'>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <input type="text" class="form-control datepicker" disabled name="fecha_fin_restaurante" value='<?php echo $informacion["informacion"]["fecha_fin_restaurante"] ?>'>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label><strong>Cantidad de personas</strong></label>
                                                                <input type="text" class="form-control" disabled name="cantidad_personas" value='<?php echo $informacion["informacion"]["cantidad_personas"] ?>'>
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
                                                                    <input type="radio" name="tipo-ocio" disabled value="1" <?php echo ($informacion["informacion"]["tipo-ocio"] == "1") ? "checked" : "" ?>> <strong>Hoteles</strong>
                                                                </label> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label><strong>Habitaciones</strong></label>
                                                                <input type="text" class="form-control" disabled name="habitaciones" value='<?php echo $informacion["informacion"]["habitaciones"] ?>'>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label><strong>Fecha comprendida</strong></label>
                                                                <input type="text" class="form-control datepicker" disabled name="fecha_inicio_hoteles" value='<?php echo $informacion["informacion"]["fecha_inicio_hoteles"] ?>'>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <input type="text" class="form-control datepicker" disabled name="fecha_fin_hoteles" value='<?php echo $informacion["informacion"]["fecha_fin_hoteles"] ?>'>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label><strong>Cantidad de personas</strong></label>
                                                                <input type="text" class="form-control" disabled name="cantidad_personas" value='<?php echo $informacion["informacion"]["cantidad_personas"] ?>'>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label><strong>Alguna Exigencia</strong></label>
                                                                <input type="text" class="form-control" disabled name="exigencia" value='<?php echo $informacion["informacion"]["exigencia"] ?>'>
                                                            </div>
                                                        </div>


                                                    </div>                                                                                  
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class='row'>
                            <div class="col-md-8 col-md-offset-2"> 
                                <h4>Localización usada:</h4>
                                <div class="col-md-6">
                                    <div class="form-group">                                
                                        <select name="provincia" disabled class="form-control">
                                            <?php if ($informacion["provincia"]): ?>
                                                <option value="0"><?php echo $informacion["provincia"]->nombre ?></option>
                                            <?php else: ?>
                                                <option value="0">Todas las provincias</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">                        
                                        <select name="poblacion" disabled class="form-control">                                        
                                            <?php if ($informacion["poblacion"]): ?>
                                                <option value="0"><?php echo $informacion["poblacion"]->nombre ?></option>
                                            <?php else: ?>
                                                <option value="0">Todas las poblaciones</option>                        
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            

                <div class="panel panel-primary">                    
                    <div class="panel-body">
                        <div class='row'>                
                            <?php echo form_open('', 'id="form_buscar"'); ?>
                            <input type='hidden' name='pagina' id='pagina' value='1'>
                            <?php echo form_close(); ?>
                            <div class="col-md-8 col-md-offset-2">
                                <div class="row">
                                    <h4>Estos son los vendedores a los que enviaste solicitud:</h4>
                                </div>
                                <div class="row">
                                    <div id="tabla-resultados"></div>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </div>

            </div>
        </div>
        <div id="throbber" style="display:none;">
            <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento."/>
        </div>
    </div>
</div>
