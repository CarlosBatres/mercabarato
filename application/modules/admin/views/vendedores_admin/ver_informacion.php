<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Informacion del Vendedor/Administrador
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">                
                <hr>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger"> 
                        <a class="close" data-dismiss="alert">×</a>
                        <?= $this->session->flashdata('error') ?> 
                    </div>
                <?php } ?> 
                <form action="<?php echo site_url('') ?>" method="post" class="search-form" id="listado-items">
                    <input type="hidden" value="1" name="pagina" id="pagina"/> 
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>ID</label>
                                <input type="text" class="form-control" readonly name="id" value="<?php echo $usuario->id; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="titulo" readonly value="<?php echo $usuario->email; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Completo</label>
                                <input type="text" class="form-control" name="titulo" readonly value="<?php echo $cliente->nombres . ' ' . $cliente->apellidos; ?>">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php if ($pais): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <p> Este usuario esta restringido a la siguiente zona:</p>                            
                                </div>
                            </div>
                        </div>                
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <select name="pais" readonly class="form-control">
                                        <option value="<?php echo $pais->id ?>"><?php echo $pais->nombre ?></option>                                    
                                    </select>
                                </div>
                            </div>
                            <?php if ($provincia): ?>
                                <div class="col-md-4">
                                    <div class="form-group">                                
                                        <select name="provincia" readonly class="form-control">
                                            <option value="<?php echo $provincia->id ?>"><?php echo $provincia->nombre ?></option>                                    
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($poblacion): ?>
                                <div class="col-md-4">
                                    <div class="form-group">                        
                                        <select name="poblacion" readonly class="form-control">
                                            <<option value="<?php echo $poblacion->id ?>"><?php echo $poblacion->nombre ?></option>                                    
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <p class="lead"> Paquetes aprobados por el vendedor:</p>
            <div id="tabla-resultados"></div>
        </div>
    </div>

</div>