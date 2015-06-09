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
    <div class="row row_registro_comprador">        
        <div class="col-md-8 col-md-offset-2">            
            <div class="box box_registro">
                <h2 class="text-uppercase">Nueva Cuenta</h2>                
                <hr>                
                <?php echo form_open('registrar_cliente', 'id="form_crear"'); ?>                 
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label>Confirme Contraseña</label>
                    <input type="password" class="form-control" name="password_confirmar">
                </div>
                <div class="heading">
                    <h3 class="text-uppercase">Información Personal</h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="nombres">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="apellidos">
                        </div>
                    </div>
                </div>                 
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input type="text" id="datepicker" class="form-control" name="fecha_nacimiento">
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Codigo Postal</label>
                            <input type="text" class="form-control" name="codigo_postal">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sexo</label><br>
                            <label>Hombre<input type="radio" name="sexo" value="H" class="radioInput"></label>
                            <label>Mujer<input type="radio" name="sexo" value="F" class="radioInput"></label>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" class="form-control" name="direccion">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="text" class="form-control" name="telefono_fijo">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefono Movil</label>
                            <input type="text" class="form-control" name="telefono_movil">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pais</label>
                            <select name="pais" class="form-control">
                                <option value="0">Seleccione un Pais</option>
                                <?php foreach ($paises as $pais): ?>
                                    <option value="<?php echo $pais->id ?>"><?php echo $pais->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Provincia</label>
                            <select name="provincia" class="form-control">
                                <option value="0">---</option>                        
                            </select>
                        </div>
                    </div>
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

    </div>            
</div>
<!-- /.container -->


