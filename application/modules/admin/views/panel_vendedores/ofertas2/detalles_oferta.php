<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Nueva Oferta
            </h1>            
        </div>
    </div>    

    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12">
            <div class="box box_registro">
                <h2 class="text-uppercase">Detalles de la Oferta</h2>                                        
                <hr>                
                <?php echo form_open('panel_vendedor/ofertas/crear', "id='detalles_oferta'"); ?>                                                 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Inicio</label>
                            <div class="input-group">                                                                        
                                <input type="text" id="datepicker" class="form-control" name="fecha_inicio">
                                <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Finalizacion</label>
                            <div class="input-group">                                                                        
                                <input type="text" id="datepicker2" class="form-control" name="fecha_finaliza">
                                <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">                                
                            <label>Ofrecer a:</label>                    
                            <select name="grupo" class="form-control">
                                <option value="0">Todos</option>                        
                                <option value="1">Tus Contactos</option>                        
                                <option value="2">Ignorar tus Contactos</option>                        
                            </select>
                        </div>
                    </div>
                </div>
                <hr>                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="nombre">                                
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Breve Descipcion</label>                    
                            <textarea class="form-control" name="descripcion" rows="8"></textarea>
                        </div>
                    </div>                 
                </div>                

                <div class="text-center">
                    <button type="submit" id="admin_producto_submit" class="btn btn-lg btn-primary"> Continuar</button>
                </div>
                <input type="hidden" name="accion" value="item-crear">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

