 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Adicionar categoria</h1>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
         <?php if (!empty($msg)) {  ?>
             <div class="callout callout-<?= $alert; ?>">
                 <h5><?= $textHeader; ?></h5>
                 <p><?= $msg; ?></p>
             </div>
         <?php } ?>
         <div class="row">
             <div class="col-md-8">
                 <div class="card card-primary">


                     <form method="POST" action="<?= BASE_URL . "produtos/category_add_action" ?>" id="addItem" class="addItem" autocomplete="off">
                         <div class=" card-body">
                           
                             <div class="form-group">
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <div class="form-group">
                                             <label>Nome da categoria</label>
                                             <div class="input-group">
                                                 <div class="input-group-prepend">
                                                     <span class="input-group-text"><i class="fa-solid fa-tags"></i></span>
                                                 </div>
                                                 <input type="text" name="category_name[]" class="form-control" placeholder="Categoria">

                                                 <div class="input-group-append">
                                                     <button type="button" id="add" onclick="adicionarCampo02()" class="btn btn-success input-group-text"><i class="fa-solid fa-plus"></i></button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div id="plusplus"></div>
                             </div>


                         </div>
                         <!-- /.card-body -->
                         <div class="card-footer">
                             <button type="submit" class="btn btn-success float-right">Adicionar</button>
                         </div>
                     </form>
                 </div>
             </div>





         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->