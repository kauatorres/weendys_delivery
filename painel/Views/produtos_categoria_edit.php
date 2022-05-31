 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Categorias <button class="btn btn-info btn-sm" onclick="window.history.back();"> <i class="fa-duotone fa-rotate-left"></i> Voltar</button></h1>
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
             <div class="col-md-12">

                 <form method="POST" action="<?= BASE_URL . "produtos/edit_category_action/" . $categorie_id; ?>" novalidate="novalidate">
                     <!-- Default box -->
                     <div class="card">
                         <div class="card-header">
                             <h3 class="card-title">Editar categoria</h3>
                             <div class="card-tools">
                                 <button type="submit" class="btn btn-block btn-success btn-sm"><i class="fa-regular fa-circle-check"></i> Salvar</button>
                             </div>
                         </div>
                         <div class="card-body">
                             <div class="form-group has-error">
                                 <label for="exampleInputEmail1">Nome da categoria</label>
                                 <input type="text" class="form-control" value="<?= $categoryName; ?>" id="new_name" name="new_name" placeholder="Nome categoria">
                                 <span id="exampleInputEmail1-error" class="error invalid-feedback">Erro ao editar grupo</span>
                             </div>


                         </div>
                         <!-- /.card-body -->
                     </div>
                     <!-- /.card -->
                 </form>
             </div>
         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->