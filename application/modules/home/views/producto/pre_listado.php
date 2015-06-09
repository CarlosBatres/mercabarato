<div id="heading-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>Productos</h1>
            </div>
            <div class="col-md-5">
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url(); ?>">Inicio</a>
                    </li>
                    <li>Productos</li>
                </ul>

            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="heading">
                <h2>Categorias</h2>
            </div>

            <p class="lead">Para continuar seleccione una de las categorias presentadas a continuacion.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php foreach ($categorias as $categoria): ?>
                <div class="col-sm-6 col-md-3">
                    <div>
                        <a href="<?php echo site_url('productos/').'/'.$categoria->slug; ?>">
                        <div class="image">
                            <img src="<?php echo assets_url($this->config->item('categorias_img_path')).'/'.$categoria->filename; ?>" alt="" class="img-responsive">
                            <h4><?php echo $categoria->nombre?></h4>
                        </div>                                                
                        </a>
                    </div>
                    <!-- /.box-image -->

                </div>
            <?php endforeach; ?>
        </div>        
    </div>
    <hr>    
</div>