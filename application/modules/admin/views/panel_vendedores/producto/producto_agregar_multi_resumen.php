<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Agregar grupo de productos (Excel)
            </h1>            
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box_registro">                
                <h2>Resumen de la operacion</h2>
                <hr>

                <div class="row">
                    <div class="col-md-12">                        
                        <?php if ($data["estado"] == "completado"): ?>
                            <p><strong><?php echo $data["completado"]; ?></strong></p>
                            <?php if (isset($data["extra"])): ?>
                                <?php if (isset($data["extra"]["item"]["0"])): ?>
                                    <ul>
                                        <?php foreach ($data["extra"]["item"] as $extra): ?>
                                            <li><strong><?php echo $extra["tipo"]; ?></strong>  |  <?php echo $extra["datos"]; ?></li>                                    
                                        <?php endforeach; ?>
                                    </ul>       
                                <?php else: ?>
                                    <ul>
                                        <li><strong><?php echo $data["extra"]["item"]["tipo"]; ?></strong>  |  <?php echo $data["extra"]["item"]["datos"]; ?></li>                                    
                                    </ul>       
                                <?php endif; ?>                     
                            <?php endif; ?>                                    
                        <?php endif; ?>
                        <?php if ($data["estado"] == "error"): ?>
                            <p><strong><?php echo $data["error"]; ?></strong></p>
                        <?php endif; ?>
                    </div>
                </div>                
            </div>            
        </div>
    </div>
</div>