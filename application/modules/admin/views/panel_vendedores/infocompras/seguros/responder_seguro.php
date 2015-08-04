<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Respuesta de Solicitud de Seguro
            </h1>            
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">            
            <?php if ($informacion["tipo"] == "seguro_otros"): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Seguro Otros / Datos de la Solicitud</h2>                        
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">                                                                                                                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Tipo de Seguro</h3>                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label><input type="radio" name="otros" value="" checked disabled><?php echo $informacion["informacion"]["otros"] ?></label>
                                        </div>                                    
                                    </div>
                                </div>
                                <hr>                                                                      
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Datos de Contacto</h3>
                                    </div>
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
                                            <label>Telefono de Contacto</label>
                                            <input type="text" class="form-control" name="telefono_contacto" disabled value="<?php echo $informacion["datos_contacto"]["telefono_contacto"] ?>">
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Observaciones</label>
                                            <textarea class="form-control" rows="8" disabled name="observaciones"><?php echo $informacion["datos_contacto"]["observaciones"] ?></textarea>
                                        </div>
                                    </div>
                                </div>                                                        
                            </div>
                        </div>
                    </div>          
                </div>
            <?php elseif ($informacion["tipo"] == "seguro_hogar"): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Seguro Hogar / Datos de la Solicitud</h2>                        
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Tipo de Vivienda</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Edificio (Piso / Apartamento )</label>
                                            <select class="form-control" name="edificio_apartamento" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["edificio_apartamento"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Edificio (Vivienda unifamiliar)</label>
                                            <select class="form-control" name="edificio_vivienda" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["edificio_vivienda"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Metros Construidos</label>
                                            <input type="text" class="form-control" disabled name="metros_construidos" value="<?php echo $informacion["informacion"]["metros_construidos"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>N° Habitantes</label>
                                            <input type="text" class="form-control" disabled name="numero_habitantes" value="<?php echo $informacion["informacion"]["numero_habitantes"] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">                                        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Uso</label>
                                            <select class="form-control" name="uso" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["uso"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Régimen de Vivienda</label>
                                            <select class="form-control" name="regimen_vivienda" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["regimen_vivienda"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Número de Baños</label>
                                            <input type="text" class="form-control" disabled name="numero_banos" value="<?php echo $informacion["informacion"]["numero_banos"] ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Construcción</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vivienda de construcción estandar</label>
                                            <select class="form-control" name="construccion_estandar" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["construccion_estandar"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Calidad de construcción</label>
                                            <select class="form-control" name="calidad_construccion" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["calidad_construccion"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Año de construcción</label>
                                            <input type="text" class="form-control" disabled name="year_construccion" value="<?php echo $informacion["informacion"]["año_construccion"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Año última reforma (si procede)</label>
                                            <input type="text" class="form-control" disabled name="year_ultima_reforma" value="<?php echo $informacion["informacion"]["año_ultima_reforma"] ?>">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Seguridad</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <?php if (isset($informacion["informacion"]["sistema_seguridad"])): ?>
                                            <div class="checkbox">
                                                <label><input type="checkbox" checked disabled name="sistema_seguridad" value="true">Sistema de alarmas conectado a central de alarmas</label>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($informacion["informacion"]["rejas_ventana"])): ?>
                                            <div class="checkbox">
                                                <label><input type="checkbox" checked disabled name="rejas_ventana" value="true">Rejas en ventanas</label>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($informacion["informacion"]["puerta_acorazada"])): ?>
                                            <div class="checkbox">
                                                <label><input type="checkbox" checked disabled name="puerta_acorazada" value="true">Puerta acorazada</label>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (isset($informacion["informacion"]["prestamo_hipotecario"])): ?>
                                            <div class="checkbox">
                                                <label><input type="checkbox" checked disabled name="prestamo_hipotecario" value="true">Marque si tiene un prestamo hipotecario</label>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Cantidades aseguradas</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Contiene</label>
                                            <input type="text" class="form-control" disabled name="contiene" <?php echo $informacion["informacion"]["contiene"] ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Contenido (mobiliario)</label>
                                            <input type="text" class="form-control" disabled name="contenido_mobiliario" <?php echo $informacion["informacion"]["contenido_mobiliario"] ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Joyas (cuyo valor unitario supere los 3.010€)</label>
                                            <input type="text" class="form-control" name="joyas" disabled value="<?php echo $informacion["informacion"]["joyas"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Objetos de valor especial (valor unitario + 3.010€)</label>
                                            <input type="text" class="form-control" name="valor_especial" disabled value="<?php echo $informacion["informacion"]["valor_especial"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Daños estéticos</label>
                                            <input type="text" class="form-control" name="danos_esteticos" disabled value="<?php echo $informacion["informacion"]["daños_esteticos"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Responsabilidad civil</label>
                                            <input type="text" class="form-control" name="responsibilidad_civil" disabled value="<?php echo $informacion["informacion"]["responsibilidad_civil"] ?>"> 
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Datos de Contacto</h3>
                                    </div>
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
                                            <label>Telefono de Contacto</label>
                                            <input type="text" class="form-control" name="telefono_contacto" disabled value="<?php echo $informacion["datos_contacto"]["telefono_contacto"] ?>">
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Observaciones</label>
                                            <textarea class="form-control" rows="8" disabled name="observaciones"><?php echo $informacion["datos_contacto"]["observaciones"] ?></textarea>
                                        </div>
                                    </div>
                                </div>                                                                                                
                            </div>
                        </div>
                    </div>          
                </div>   
            <?php elseif ($informacion["tipo"] == "seguro_riesgo"): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Seguro Riesgo / Datos de la Solicitud</h2>                        
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">                                 
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Datos Personales</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>NIF - NIE</label>
                                            <input type="text" class="form-control" name="nif_nie" disabled value="<?php echo $informacion["informacion"]["nif_nie"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sexo</label>
                                            <select class="form-control" name="sexo" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["sexo"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="text" class="form-control datepicker" name="fecha_nacimiento" disabled value="<?php echo $informacion["informacion"]["fecha_nacimiento"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Profesión o dedicación</label>
                                            <input type="text" class="form-control" name="profesion" disabled value="<?php echo $informacion["informacion"]["profesion"] ?>">
                                        </div>
                                    </div>                                       
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Datos de Contacto</h3>
                                    </div>
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
                                            <label>Telefono de Contacto</label>
                                            <input type="text" class="form-control" name="telefono_contacto" disabled value="<?php echo $informacion["datos_contacto"]["telefono_contacto"] ?>">
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Observaciones</label>
                                            <textarea class="form-control" rows="8" disabled name="observaciones"><?php echo $informacion["datos_contacto"]["observaciones"] ?></textarea>
                                        </div>
                                    </div>
                                </div>                                                                                  
                            </div>
                        </div>
                    </div>          
                </div>
            <?php elseif ($informacion["tipo"] == "seguro_salud"): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Seguro Salud / Datos de la Solicitud</h2>                        
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">                                                                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Datos de los Asegurados</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Provincia del grupo familiar</label>
                                            <input type="text" class="form-control" name="provincia_grupo_familiar" disabled value="<?php echo $informacion["informacion"]["provincia_grupo_familiar"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Numero de Personas</label>
                                            <select class="form-control" name="numero_personas" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["numero_personas"] ?></option>                                                
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
                                            <input type="text" class="form-control" disabled name="nombres_titular" value="<?php echo $informacion["informacion"]["nombres_titular"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Apellidos</label>
                                            <input type="text" class="form-control" disabled name="apellidos_titular" value="<?php echo $informacion["informacion"]["apellidos_titular"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="text" class="form-control datepicker" name="fecha_nacimiento" disabled value="<?php echo $informacion["informacion"]["fecha_nacimiento"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Sexo</label>
                                            <select class="form-control" name="sexo" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["sexo"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>                                       
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tiene trabajo remunerado?</label>
                                            <select class="form-control" name="trabajo_remunerado" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["trabajo_remunerado"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Modalidad de contratación</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <?php if (isset($informacion["informacion"]["modalidad_contratacion"])): ?>
                                            <?php if ($informacion["informacion"]["modalidad_contratacion"] == "extrahospitalaria"): ?>
                                                <div class="radio">
                                                    <label><input type="radio" name="modalidad_contratacion" checked disabled value="extrahospitalaria">Reembolso Extrahospitalaria</label>
                                                </div>
                                            <?php else: ?>
                                                <div class="radio">
                                                    <label><input type="radio" name="modalidad_contratacion" checked disabled value="hospitalaria">Reembolso Hospitalaria</label>
                                                </div> 
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Datos de Contacto</h3>
                                    </div>
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
                                            <label>Telefono de Contacto</label>
                                            <input type="text" class="form-control" name="telefono_contacto" disabled value="<?php echo $informacion["datos_contacto"]["telefono_contacto"] ?>">
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Observaciones</label>
                                            <textarea class="form-control" rows="8" disabled name="observaciones"><?php echo $informacion["datos_contacto"]["observaciones"] ?></textarea>
                                        </div>
                                    </div>
                                </div>                                 
                            </div>
                        </div>
                    </div>          
                </div>
            <?php elseif ($informacion["tipo"] == "seguro_vehiculos"): ?>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Seguro Vehiculos / Datos de la Solicitud</h2>                        
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">                                                                                                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Tipo de Vehiculo</h3>                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tipo de vehiculo</label>
                                            <select class="form-control" name="tipo_vehiculo" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["tipo_vehiculo"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Marca</label>
                                            <input type="text" class="form-control" name="marca" disabled value="<?php echo $informacion["informacion"]["marca"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Modelo</label>
                                            <input type="text" class="form-control" name="modelo" disabled value="<?php echo $informacion["informacion"]["modelo"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Combustible</label>
                                            <select class="form-control" name="vehiculo_combustible" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["vehiculo_combustible"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Numero de Puertas</label>
                                            <select class="form-control" name="vehiculo_nro_puertas" disabled>
                                                <option value=""><?php echo $informacion["informacion"]["vehiculo_nro_puertas"] ?></option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha 1ª Matriculación</label>
                                            <input type="text" class="form-control datepicker" name="fecha_matriculacion" disabled value="<?php echo $informacion["informacion"]["fecha_matriculacion"] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Matricula</label>
                                            <input type="text" class="form-control" name="matricula" disabled value="<?php echo $informacion["informacion"]["matricula"] ?>">
                                        </div>
                                    </div>
                                </div>                                                                                                            
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Conductor habitual</h3> 
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Fecha nacimiento</label>
                                                    <input type="text" class="form-control datepicker" name="fecha_nacimiento" disabled value="<?php echo $informacion["informacion"]["fecha_nacimiento"] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Sexo</label>
                                                    <select class="form-control" name="sexo" disabled>
                                                        <option value=""><?php echo $informacion["informacion"]["sexo"] ?></option>                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Estado civil</label>
                                                    <select class="form-control" name="estado_civil" disabled>
                                                        <option value=""><?php echo $informacion["informacion"]["estado_civil"] ?></option>                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tipo de documento</label>
                                                    <select class="form-control" name="tipo_documento" disabled>
                                                        <option value=""><?php echo $informacion["informacion"]["tipo_documento"] ?></option>                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>N° Documento</label>
                                                    <input type="text" class="form-control" name="numero_documento" disabled value="<?php echo $informacion["informacion"]["numero_documento"] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Fecha de permiso</label>
                                                    <input type="text" class="form-control datepicker" name="fecha_permiso" disabled value="<?php echo $informacion["informacion"]["fecha_permiso"] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Clase</label>
                                                    <select class="form-control" name="conductor_clase" disabled>
                                                        <option value=""><?php echo $informacion["informacion"]["conductor_clase"] ?></option>                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Codigo postal</label>
                                                    <input type="text" class="form-control" name="codigo_postal" disabled value="<?php echo $informacion["informacion"]["codigo_postal"] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Provincia</label>
                                                    <input type="text" class="form-control" name="provincia" disabled value="<?php echo $informacion["informacion"]["provincia"] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>                                                                      
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Datos de Contacto</h3>
                                    </div>
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
                                            <label>Telefono de Contacto</label>
                                            <input type="text" class="form-control" name="telefono_contacto" disabled value="<?php echo $informacion["datos_contacto"]["telefono_contacto"] ?>">
                                        </div>
                                    </div>                                
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Observaciones</label>
                                            <textarea class="form-control" rows="8" disabled name="observaciones"><?php echo $informacion["datos_contacto"]["observaciones"] ?></textarea>
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

    <div class="row">
        <br><hr><br>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">                
                <h3>Datos de tu Respuesta</h3>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?>
                <?php echo form_open_multipart('panel_vendedor/infocompras/seguros/responder/' . $solicitud_seguro->id); ?>                                 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                                                        
                            <label>Respuesta</label>                    
                            <textarea class="form-control" id="content" name="respuesta" rows="10"></textarea>                                        
                            <?php echo display_ckeditor($ckeditor); ?>
                        </div>
                    </div>
                </div>                                
                <div class="row">
                    <div class="col-md-12">
                        <label>Deseas adjuntar un archivo?</label>                    
                        <input type="file" name="userfile" size="20" />
                    </div>
                </div>
            </div>
            <hr>                                
            <div class="text-center">
                <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Enviar</button>
            </div>                        
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<br>
<div id="throbber" style="display:none;">
    <img src="<?php echo assets_url('imgs/small-ajax-loader.gif'); ?>" />
</div>
</div>