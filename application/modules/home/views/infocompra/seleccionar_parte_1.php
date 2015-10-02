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
        <?php echo form_open('infocompras/paso-2', 'id="infocompras-general-parte1"'); ?>
        <div class='row'>
            <div class="col-md-12">                            
                <h4>Selecciona una o varias categorías a continuación</h4>
                <div class="radio infocompras-general-categorias">
                    <?php foreach ($categorias as $categoria): ?>                    
                        <div class="col-md-3 checkbox-box">            
                            <label class="checkbox">
                                <input type="checkbox" name="categorias[]" value="<?php echo $categoria->id; ?>"> <strong><?php echo $categoria->nombre; ?></strong>
                            </label>                                      
                        </div>
                    <?php endforeach; ?>
                </div>


            </div>
        </div>
        <br>
        <div class='row'>
            <div class="col-md-12"> 
                <h4>Selecciona un lugar</h4>
                <div class="col-md-6">
                    <div class="form-group">                                
                        <select name="provincia" class="form-control">
                            <option value="0">Todas las provincias</option>
                            <?php foreach ($provincias as $provincia): ?>
                                <option value="<?php echo $provincia->id ?>"><?php echo $provincia->nombre ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">                        
                        <select name="poblacion" class="form-control">
                            <option value="0">Todas las poblaciones</option>                        
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class='row'>
            <div class="col-md-12"> 
                <div class="pull-right">
                    <button type="submit" class="btn btn-template-primary"> Siguiente</button>
                </div>                    
            </div>                    
        </div>                    
        <?php echo form_close(); ?>
    </div>
</div>
