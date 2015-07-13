<div id="question" style="display:none; cursor: default">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Esta seguro?.</h4>
        </div>
        <div class="modal-body">                                    
            <p class="text-center">
                <button class="btn btn-success" type="button" id="yes"><i class="fa fa-check"></i> Si</button>
                <button class="btn btn-danger" type="button" id="no"><i class="fa fa-close"></i> No</button>
            </p>                                            
        </div>        
    </div>
</div>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Invitaciones Recibidas
            </h1> 
            <p class="lead"> A continuacion se muestran los clientes que te han enviado invitaciones y estan pendientes por tu aprobacion. 
                <br>Puedes aceptar o rechazar a tu conveniencia.</p>            
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
                <input type="hidden" value="invitaciones_recibidas" name="tipo"/>                                        
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