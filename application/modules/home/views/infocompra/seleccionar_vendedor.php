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
        <div class="col-md-8 col-md-offset-2">            
            <?php echo form_open('', 'id="form_buscar"'); ?>
            <div class="col-md-12">
                <div class="row">                    
                    <div class="col-md-3 pull-right">
                        <div class="pull-right terminar-btn" <?php echo (!$hide_terminar) ? "style='display:none;'" : ""; ?>>                        
                            <a href="<?php echo site_url('infocompras/mostrar-resumen') ?>" class="btn btn-template-primary" id="terminar-seguros"> Terminar</a>
                        </div>                
                    </div>
                    <input type='hidden' name='pagina' id='pagina' value='1'>
                    <div class="col-md-3 pull-right">
                        <div class="pull-right enviar-todos-btn" style="display:none;">                        
                            <a href="" class="btn btn-template-primary" id="enviar-todos"> Enviar a Todos</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
            <br>
            <hr>
            <div class="col-md-12">
                <div class="row">
                    <div id="tabla-resultados"></div>
                </div>
            </div>            
        </div>
    </div>
    <div id="throbber" style="display:none;">
        <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" alt="Espere un momento."/>
    </div>
</div>

