<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Infocompras - Seguros</h1>
            </div>

        </div>
    </div>
</div>

<div id="content" class="clearfix">
    <div class="container">
        <div class="row">              
            <h3>Seleccione el tipo de seguro</h3>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#hogar" role="tab" data-toggle="tab">Hogar</a></li>
                <li><a href="#riesgo" role="tab" data-toggle="tab">Riesgo</a></li>
                <li><a href="#salud" role="tab" data-toggle="tab">Salud</a></li>
                <li><a href="#vehiculos" role="tab" data-toggle="tab">Vehiculos</a></li>
                <li><a href="#otros" role="tab" data-toggle="tab">Otros</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- 
                
                ***** HOGAR *****
                
                -->
                <div class="tab-pane active" id="hogar">                    
                    <div class="row">        
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">                                                                        
                                    <?php echo form_open('seguros/registrar', 'id="seguro_hogar"'); ?>                 
                                    <input type="hidden" name="tipo" value="seguro_hogar">
                                    <div class="row">
                                        <h3>Tipo de Vivienda</h3>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Edificio (Piso / Apartamento )</label>
                                                <select class="form-control" name="edificio_apartamento">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Intermedio">Intermedio</option>
                                                    <option value="Atico">Atico</option>
                                                    <option value="Bajo">Bajo</option>
                                                    <option value="Primer Piso">Primer Piso</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Edificio (Vivienda unifamiliar)</label>
                                                <select class="form-control" name="edificio_vivienda">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Adosada">Adosada</option>
                                                    <option value="Individual">Individual</option>
                                                    <option value="Pareada">Pareada</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Metros Construidos</label>
                                                <input type="text" class="form-control" name="metros_construidos">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>N° Habitantes</label>
                                                <input type="text" class="form-control" name="numero_habitantes">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Uso</label>
                                                <select class="form-control" name="uso">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Habitual">Habitual</option>
                                                    <option value="Temporada">Temporada</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Régimen de Vivienda</label>
                                                <select class="form-control" name="regimen_vivienda">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Inquilino Alquiler">Inquilino Alquiler</option>
                                                    <option value="Propiedad en Alquiler">Propiedad en Alquiler</option>
                                                    <option value="Propiedad / Propietario">Propiedad / Propietario</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Número de Baños</label>
                                                <input type="text" class="form-control" name="numero_banos">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <h3>Construcción</h3>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Vivienda de construcción estandar</label>
                                                <select class="form-control" name="construccion_estandar">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Calidad de construcción</label>
                                                <select class="form-control" name="calidad_construccion">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Media">Media</option>
                                                    <option value="Alta">Alta</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Año de construcción</label>
                                                <input type="text" class="form-control" name="year_construccion">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Año última reforma (si procede)</label>
                                                <input type="text" class="form-control" name="year_ultima_reforma">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <h3>Seguridad</h3>
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="sistema_seguridad" value="true">Sistema de alarmas conectado a central de alarmas</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="rejas_ventana" value="true">Rejas en ventanas</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="puerta_acorazada" value="true">Puerta acorazada</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="prestamo_hipotecario" value="true">Marque si tiene un prestamo hipotecario</label>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <h3>Cantidades aseguradas</h3>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Contiene</label>
                                                <input type="text" class="form-control" name="contiene">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Contenido (mobiliario)</label>
                                                <input type="text" class="form-control" name="contenido_mobiliario">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Joyas (cuyo valor unitario supere los 3.010€)</label>
                                                <input type="text" class="form-control" name="joyas">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Objetos de valor especial (valor unitario + 3.010€)</label>
                                                <input type="text" class="form-control" name="valor_especial">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Daños estéticos</label>
                                                <input type="text" class="form-control" name="danos_esteticos">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Responsabilidad civil</label>
                                                <input type="text" class="form-control" name="responsibilidad_civil">
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

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
                                                <label>Telefono de Contacto</label>
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
                                                <label for="comment">Observaciones</label>
                                                <textarea class="form-control" rows="8" name="observaciones"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
                    </div> 
                </div>
                <!-- 
                
                ***** RIESGO *****
                
                -->
                <div class="tab-pane" id="riesgo">
                    <div class="row">        
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">                                                                        
                                    <?php echo form_open('seguros/registrar', 'id="seguro_riesgo"'); ?>                 
                                    <input type="hidden" name="tipo" value="seguro_riesgo">
                                    <div class="row">
                                        <h3>Datos Personales</h3>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>NIF - NIE</label>
                                                <input type="text" class="form-control" name="nif_nie">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sexo</label>
                                                <select class="form-control" name="sexo">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Hombre">Hombre</option>
                                                    <option value="Mujer">Mujer</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha de Nacimiento</label>
                                                <input type="text" class="form-control" name="fecha_nacimiento">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profesión o dedicación</label>
                                                <input type="text" class="form-control" name="profesion">
                                            </div>
                                        </div>                                       
                                    </div>
                                    <hr>
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
                                                <label>Telefono de Contacto</label>
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
                                                <label for="comment">Observaciones</label>
                                                <textarea class="form-control" rows="8" name="observaciones"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
                    </div> 
                </div>
                <!-- 
               
               ***** SALUD *****
               
                -->

                <div class="tab-pane" id="salud">                    
                    <div class="row">        
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">                                                                        
                                    <?php echo form_open('seguros/registrar', 'id="seguro_salud"'); ?>                 
                                    <input type="hidden" name="tipo" value="seguro_salud">
                                    <div class="row">
                                        <h3>Datos de los Asegurados</h3>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Provincia del grupo familiar</label>
                                                <input type="text" class="form-control" name="provincia_grupo_familiar">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Numero de Personas</label>
                                                <select class="form-control" name="numero_personas">
                                                    <option value="">Seleccione Uno</option>
                                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                                        <option value="<?php echo $i ?>"><?php echo $i; ?></option>
                                                    <?php endfor; ?>                                                                                                        
                                                </select>
                                            </div>
                                        </div>                                                                               
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <h3>Asegurados (titular del seguro)</h3>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nombres</label>
                                                <input type="text" class="form-control" name="nombres_titular">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Apellidos</label>
                                                <input type="text" class="form-control" name="apellidos_titular">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fecha de Nacimiento</label>
                                                <input type="text" class="form-control" name="fecha_nacimiento">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Sexo</label>
                                                <select class="form-control" name="sexo">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Hombre">Hombre</option>
                                                    <option value="Mujer">Mujer</option>                                                   
                                                </select>
                                            </div>
                                        </div>                                       
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tiene trabajo remunerado?</label>
                                                <select class="form-control" name="trabajo_remunerado">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Si">Si</option>
                                                    <option value="No">No</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3>Modalidad de contratación</h3>
                                        <div class="col-md-12">
                                            <div class="radio">
                                                <label><input type="radio" name="modalidad_contratacion" value="extrahospitalaria">Reembolso Extrahospitalaria</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="modalidad_contratacion" value="hospitalaria">Reembolso Hospitalaria</label>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <hr>
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
                                                <label>Telefono de Contacto</label>
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
                                                <label for="comment">Observaciones</label>
                                                <textarea class="form-control" rows="8" name="observaciones"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
                    </div> 
                </div>
                <!-- 
               
               ***** VEHICULOS *****
               
                -->
                <div class="tab-pane" id="vehiculos">
                    <div class="row">        
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">                                                                        
                                    <?php echo form_open('seguros/registrar', 'id="seguro_vehiculos"'); ?>                 
                                    <input type="hidden" name="tipo" value="seguro_vehiculos">
                                    <div class="row">
                                        <h3>Tipo de Vehiculo</h3>                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tipo de vehiculo</label>
                                                <select class="form-control" name="tipo_vehiculo">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Turismo">Turismo</option>
                                                    <option value="Motocicleta Ciclomotor">Motocicleta Ciclomotor</option>
                                                    <option value="Camión">Camión</option>
                                                    <option value="Tractor">Tractor</option>
                                                    <option value="Maquinaría">Maquinaría</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Marca</label>
                                                <input type="text" class="form-control" name="marca">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Modelo</label>
                                                <input type="text" class="form-control" name="modelo">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Combustible</label>
                                                <select class="form-control" name="vehiculo_combustible">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="Gasoil-Diesel">Gasoil-Diesel</option>
                                                    <option value="Gasolina">Gasolina</option>
                                                    <option value="Electricidad">Electricidad</option>
                                                    <option value="Gas">Gas</option>
                                                    <option value="Etenol">Etenol</option>
                                                    <option value="Híbrido Gasolina">Híbrido Gasolina</option>
                                                    <option value="Híbrido Diesel">Híbrido Diesel</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Combustible</label>
                                                <select class="form-control" name="vehiculo_nro_puertas">
                                                    <option value="">Seleccione Uno</option>
                                                    <option value="0">Sin puertas</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Fecha 1ª Matriculación</label>
                                                <input type="text" class="form-control" name="fecha_matriculacion">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Matricula</label>
                                                <input type="text" class="form-control" name="matricula">
                                            </div>
                                        </div>
                                    </div>                                                                                                            
                                    <hr>
                                    <div class="row">
                                        <h3>Conductor habitual</h3> 
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha nacimiento</label>
                                                        <input type="text" class="form-control" name="fecha_nacimiento">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Sexo</label>
                                                        <select class="form-control" name="sexo">
                                                            <option value="">Seleccione Uno</option>
                                                            <option value="Hombre">Hombre</option>
                                                            <option value="Mujer">Mujer</option>                                                   
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado civil</label>
                                                        <select class="form-control" name="estado_civil">
                                                            <option value="">Seleccione Uno</option>
                                                            <option value="Soltero/a">Soltero/a</option>
                                                            <option value="Casado/a">Casado/a</option>
                                                            <option value="Divorciado/a">Divorciado/a</option>
                                                            <option value="Separado/a">Separado/a</option>
                                                            <option value="Viudo/a">Viudo/a</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Tipo de documento</label>
                                                        <select class="form-control" name="tipo_documento">
                                                            <option value="">Seleccione Uno</option>
                                                            <option value="NIF">NIF</option>
                                                            <option value="DNI (Otros Paises)">DNI (Otros Paises)</option>
                                                            <option value="NIE">NIE</option>                                                    
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>N° Documento</label>
                                                        <input type="text" class="form-control" name="numero_documento">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Fecha de permiso</label>
                                                        <input type="text" class="form-control" name="fecha_permiso">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Clase</label>
                                                        <select class="form-control" name="conductor_clase">
                                                            <option value="">Seleccione Uno</option>
                                                            <option value="LCC">LCC</option>
                                                            <option value="A1">A1</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="A2">A2</option>
                                                            <option value="AM">AM</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Codigo postal</label>
                                                        <input type="text" class="form-control" name="codigo_postal">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Provincia</label>
                                                        <input type="text" class="form-control" name="provincia">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>                                                                      
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
                                                <label>Telefono de Contacto</label>
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
                                                <label for="comment">Observaciones</label>
                                                <textarea class="form-control" rows="8" name="observaciones"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
                    </div>
                </div>
                <!-- 
               
               ***** Otros *****
               
                -->
                <div class="tab-pane" id="otros">
                    <div class="row">        
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">                                                                        
                                    <?php echo form_open('seguros/registrar', 'id="seguro_otros"'); ?>                 
                                    <input type="hidden" name="tipo" value="seguro_otros">
                                    <div class="row">
                                        <h3>Seleccione el tipo</h3>                                        
                                        <div class="col-md-12">
                                            <div class="radio">
                                                <label><input type="radio" name="otros" value="ahorro">Ahorro</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="otros" value="agropecuaria">Agropecuaria</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="otros" value="caza_pesca">Caza y Pesca</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="otros" value="agroseguro">Agroseguro</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="otros" value="maquinaria">Maquinaria</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="otros" value="otros">Otros</label>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <hr>                                                                      
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
                                                <label>Telefono de Contacto</label>
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
                                                <label for="comment">Observaciones</label>
                                                <textarea class="form-control" rows="8" name="observaciones"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>