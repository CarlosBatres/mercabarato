<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1><?php echo $categoria->nombre ?></h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('productos'); ?>">Productos</a>
                    </li>
                    <li><?php echo $categoria->nombre ?></li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-3">            
            <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                    <h3 class="panel-title">Categorias</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked category-menu metismenu" id="producto-menu-categorias">
                        <?php echo ($subcategorias) ? $subcategorias : "No hay categorias disponibles"; ?>                        
                    </ul>                    
                </div>
            </div>
            <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                    <h3 class="panel-title">Precios</h3>
                    <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> <span class="hidden-sm">Deshacer</span></a>
                </div>

                <div class="panel-body">
                    <form>
                        <div class="form-group">                            
                                <?php
                                $j = 0;
                                foreach ($precios as $precio) {
                                    $checked = ($precio['checked']) ? "checked='checked'" : "";
                                    echo '<div class="checkbox">'
                                    . '<label>'
                                    . '<input type="checkbox" name="precios" value="' . $precio['value'] . '" ' . $checked . '>&nbsp;' . $precio['text'] . ''
                                    . '</label>'
                                    . '</div>';
                                    $j++;
                                }
                                ?>                                                            
                        </div>
                        <button id="precios-search-aplicar" class="btn btn-default btn-sm btn-template-main"><i class="fa fa-pencil"></i> Aplicar</button>
                    </form>

                </div>
            </div>
        </div>


        <div class="col-sm-9">            
            <div class="box-simple">                                
                <form>
                    <div class="input-group">
                        <input type="text" name="search_query" class="form-control" placeholder="Ingrese un producto, una marca o referencia...">
                        <input type="hidden" value="1" name="pagina" id="pagina"/>
                        <input type="hidden" value="<?php echo $categoria->id ?>" name="categoria_padre"/>
                        <span class="input-group-btn">
                            <button class="btn btn-template-main" id="search_button" type="button"><i class="fa fa-search"></i>Buscar</button>
                        </span>
                    </div>                    
                </form>
            </div>

            <div id="tabla-resultados"></div>

        </div>
        <!-- /.col-md-9 -->
    </div>
</div>
<!-- /.container -->