<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Eliminar Cuenta</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Eliminar Cuenta</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div id="content">
    <div class="container">        
        <div class="col-md-8 col-md-offset-2">                                                                        
            <?php echo form_open('usuario/eliminar-cuenta-confirmar'); ?>              
            <h3>¿Desea eliminar su cuenta permanentemente?</h3>
            <p>Estas a punto de eliminar la cuenta de <strong><?php echo $usuario->email ?></strong></p>
            <p>Recuerde que eliminar su cuenta es permanente.</p>
            <br>            
            <input type="hidden" name="usuario_id" value="<?php echo $usuario->id ?>">
            <button type="submit" id="eliminar_cuenta" class="btn btn-lg btn-primary"> Eliminar mi cuenta</button>
            <?php echo form_close(); ?>
        </div>             
    </div>    
</div>
