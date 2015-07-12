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
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-12">
                    <p class="lead">A continuación puede filtrar por provincia y población para enviar el presupuesto a los proveedores que coincidan con sus criterios de busqueda.</p>
                </div>
                <form id="form_buscar">
                    <input type="hidden" name="pagina" id="pagina" value="1">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">                                
                            <select name="provincia" class="form-control">
                                <option value="0">Todas las Provincias</option>                        
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">                        
                            <select name="poblacion" class="form-control">
                                <option value="0">Todas las Poblaciónes</option>                        
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="pull-right">
                        <button type="button" class="btn btn-template-primary" id="enviar_todos"> Enviar a Todos</button>
                    </div>
                </div>
            </div>
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
        <img src="<?php echo assets_url('imgs/loader_on_white_nb_big.gif'); ?>" />
    </div>
</div>

