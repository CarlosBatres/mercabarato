<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Clientes Actuales
            </h1>            
            <p class="lead"> A continuacion se muestran los clientes que estan conectados contigo o cuyas invitaciones han sido aceptadas.</p>                                  
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">             
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"> 
                    <a class="close" data-dismiss="alert">×</a>
                    <?= $this->session->flashdata('success') ?> 
                </div>
            <?php } ?> 
            <form action="<?php echo site_url('panel_vendedor/producto/listado') ?>" method="post" class="search-form" id="listado-items">
                <input type="hidden" value="1" name="pagina" id="pagina"/>                                        
                <input type="hidden" value="invitaciones_aceptadas" name="tipo"/>   
            </form>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Clientes
                        </div>
                        <div class="panel-body">
                            <div id="tabla-resultados"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>