<section class="bar background-image-1">
    <div class="container">                        
        <div class="row index-search-box">
            <div class="col-md-12">                
                <?php echo form_open('ir_productos' ,'id="productos-buscar"'); ?>                 
                <div class="row inicio-localizacion hidden-sm hidden-xs">
                    <div class="col-md-4 col-md-offset-2">
                        <div class="form-group"> 
                            <select name="provincia" class="form-control">
                                <option value="0">Todas las Provincias</option>
                                <?php foreach ($provincias as $provincia): ?>
                                    <option value="<?php echo $provincia->id ?>"><?php echo $provincia->nombre ?></option>
                                <?php endforeach; ?>                                
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
                </div>

                <div class="row inicio-precios hidden-sm hidden-xs">
                    <div class="col-md-2 text-right col-md-offset-4">
                        <p class="inicio-precios-titulo">Precios</p>                            
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default sidebar-menu principal-sidebar">                        
                            <div class="panel-body">                        
                                <div class="precios-productos">                                
                                    <div class="input-group pull-left">                                                
                                        <input type="text" class="form-control" name="precio_desde" placeholder="Desde">                                    
                                        <span class="input-group-addon"><i class="fa fa-euro fa-fw"></i></span>
                                    </div>                           

                                    <div class="input-group pull-right">                                                                                    
                                        <input type="text" class="form-control" name="precio_hasta" placeholder="Hasta">                                    
                                        <span class="input-group-addon"><i class="fa fa-euro fa-fw"></i></span>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="input-group">                    
                            <input type="text" name="search_query" class="form-control" placeholder="Ingrese un producto, o alguna referencia ...">                                                                                
                            <span class="input-group-btn">
                                <button class="btn btn-template-primary" id="search_button" type="submit"><i class="fa fa-search"></i><span class="hidden-xs">Buscar</span></button>
                            </span>
                        </div>
                    </div> 
                </div>
                <?php echo form_close(); ?>
                <br>
            </div>
        </div>
    </div>
</section>

<section class="bar background-white">
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">                                               
                    <div class="panel panel-primary panel-blue">
                        <div class="panel-heading">                                
                            <span class="titulo">Busca y Compara</span><br>
                            <span class="subtext">Productos y servicios organizados</span>
                        </div>
                        <div class="panel-body">                            
                            <ul>
                                <li>El mejor precio.</li>
                                <li>Cercanía al punto de venta.</li>
                                <li>Descripción actualizada.</li>
                                <li>Vendedores conocidos.</li>
                                <li>Siempre informado.</li>
                                <li>Precios por volumen de compra.</li>
                                <li>Facilidad de busqueda.</li>
                            </ul>
                        </div>                
                    </div>                    
                </div>
                <div class="col-md-4">                           
                    <div class="panel panel-primary panel-orange">
                        <div class="panel-heading">                                
                            <span class="titulo">Infocompras</span><br>
                            <span class="subtext">Compara presupuestos ajustados</span>
                        </div>
                        <div class="panel-body">                            
                            <ul>                                    
                                <li>Seguros.</li>
                                <li>Servicios.</li>
                                <li>Regalos.</li>
                                <li>Productos, etc...</li>
                                <ul>
                                    <li>Escoge los Vendedores.</li>
                                    <li>La demanda es anónima.</li>
                                    <li>Ellos proponen tu eliges.</li>                                    
                                </ul>
                            </ul>
                        </div>                
                    </div>
                </div>
                <div class="col-md-4">                    
                    <div class="panel panel-primary panel-green">
                        <div class="panel-heading">                                
                            <span class="titulo">Tarifas personales</span><br>
                            <span class="subtext">Tus vendedores mejoran el precio</span>
                        </div>
                        <div class="panel-body">                            
                            <ul>                                                                       
                                <li>De cada vendedor.</li>
                                <li>Precios personales.</li>
                                <li>Compara PVP con precio tarifa.</li>
                                <li>Actualización constante.</li>
                                <ul>
                                    <li>Invita a los vendedores.</li>
                                    <li>Listado de productos vendedor.</li>
                                    <li>Facilidad de comparar.</li> 
                                </ul>
                            </ul>
                        </div>                
                    </div>                      
                </div>
            </div>                    
        </div>        
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">                           
                    <div class="panel panel-primary panel-gray">
                        <div class="panel-heading">                                
                            <span class="titulo">Ventajas de ser un Vendedor</span><br>
                            <span class="subtext">Anuncios, contacto y descripcion</span>                            
                        </div>
                        <div class="panel-body">                            
                            <ul>
                                <li>Información de novedades a los clientes.</li>
                                <li>Buscar clientes potenciales, y administrar sus precios (tarifas).</li>
                                <li>Dirección, teléfono, mail y web.</li>
                                <li>Organización de productos.</li>
                                <li>Fácil de actualizar miles de artículos a las vez.</li>
                                <li>Posibilidad de recibir demandas de presupuestos.</li>
                                <li>Rebajas del precio insertado.</li>                                    
                            </ul>
                        </div>
                    </div>                        
                </div>                
            </div>                    
        </div>
    </div>
</section>
