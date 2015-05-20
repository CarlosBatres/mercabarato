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

<div class="container">    
    <div class="row">
        <div class="col-md-6">
            <div class="tipo_registro">
                <a href="#" class="registro_comprador">Comprador</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tipo_registro">
                <a href="#" class="registro_vendedor">Empresa / Vendedor</a>
            </div>
        </div>
    </div>
    
    <div class="row row_registro_comprador">        
        <div class="col-md-6">            
            <div class="box box_registro">
                <h2 class="text-uppercase">Nueva Cuenta</h2>                                        
                <hr>
                <?php echo form_open('registrar', 'id="registrar_comprador"'); ?>                 
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label>Confirme Contraseña</label>
                    <input type="password" class="form-control" name="password-confirmar">
                </div>
                <br><hr><br>
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
                <div class="form-group">
                    <label>Pais</label>
                    <select name="pais" class="form-control">
                        <option value="0">Seleccione un Pais</option>
                        <?php foreach($paises as $pais):?>
                            <option value="<?php echo $pais->id ?>"><?php echo $pais->nombre ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Provincia</label>
                    <select name="provincia" class="form-control">
                        <option value="0">---</option>                        
                    </select>
                </div>
                <div class="form-group">
                    <label>Población</label>
                    <select name="poblacion" class="form-control">
                        <option value="0">---</option>                        
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-template-main"><i class="fa fa-user-md"></i> Registrarse</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>          

        <div class="col-md-6">            
            <div class="box box_registro">
                <h4> Informacion sobre Cuenta Comprador</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.</p>                               
            </div>
        </div>
    </div>
    
    
    <div class="row row_registro_vendedor hidden">        
        <div class="col-md-6">            
            <div class="box box_registro">
                <h4> Informacion sobre Cuenta Vendedor</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet condimentum scelerisque.</p>  
            </div>
        </div>          

        <div class="col-md-6">            
            <div class="box box_registro">
                <h2 class="text-uppercase">Nueva Cuenta</h2>                                        
                <hr>
                <?php echo form_open('registrar', 'id="registrar_vendedor"'); ?>                 
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label>Confirme Contraseña</label>
                    <input type="password" class="form-control" name="password-confirmar">
                </div>
                <br><hr><br>
                <div class="form-group">
                    <label>Nombre de la Empresa o Persona</label>
                    <input type="text" class="form-control" name="nombre">
                </div>
                <div class="form-group">
                    <label>Actividad</label>
                    <select name="actividad" class="form-control">
                        <option value="0">---</option>
                        <option value="1">Actividad</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Direccion</label>
                    <input type="text" class="form-control" name="direccion">
                </div>
                <div class="form-group">
                    <label>Codigo Postal</label>
                    <input type="text" class="form-control" name="postal">
                </div>
                <div class="form-group">
                    <label>Telefono Principal</label>
                    <input type="text" class="form-control" name="telefono_principal">
                </div>
                <div class="form-group">
                    <label>Telefono Secundario</label>
                    <input type="text" class="form-control" name="telefono_secundario">
                </div>
                <div class="form-group">
                    <label>Sitio Web</label>
                    <input type="text" class="form-control" name="sitio_web">
                </div>
                <div class="form-group">
                    <label for="pais">Pais</label>
                    <select name="pais" class="form-control">
                        <option value="0">Seleccione un Pais</option>
                        <?php foreach($paises as $pais):?>
                            <option value="<?php echo $pais->id ?>"><?php echo $pais->nombre ?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="provincia">Provincia</label>
                    <select name="provincia" class="form-control">
                        <option value="0">---</option>                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="poblacion">Población</label>
                    <select name="poblacion" class="form-control">
                        <option value="0">---</option>                        
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-template-main"><i class="fa fa-user-md"></i> Registrarse</button>
                </div>
                <?php echo form_close(); ?>                    
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->


