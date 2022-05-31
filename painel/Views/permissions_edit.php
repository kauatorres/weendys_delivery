 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Permissões <button class="btn btn-info btn-sm" onclick="window.history.back();"> <i class="fa-duotone fa-rotate-left"></i> Voltar</button></h1>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">

         <div class="row">
             <div class="col-md-12">

                 <form method="POST" action="<?= BASE_URL . "permissions/edit_action/" . $permission_id; ?>" novalidate="novalidate">
                     <!-- Default box -->
                     <div class="card">
                         <div class="card-header">
                             <h3 class="card-title">Editar grupo de permissão</h3>
                             <div class="card-tools">
                                 <button type="submit" class="btn btn-block btn-success btn-sm"><i class="fa-regular fa-circle-check"></i> Salvar</button>
                             </div>
                         </div>
                         <div class="card-body">
                             <div class="form-group has-error">
                                 <label for="exampleInputEmail1">Nome do grupo</label>
                                 <input type="text" class="form-control <?= (in_array('name', $errorItens) ? 'is-invalid' : '') ?>" value="<?= $permission_group_name; ?>" id="group_name" name="name" placeholder="Nome do grupo">
                                 <span id="exampleInputEmail1-error" class="error invalid-feedback">Erro ao editar grupo</span>
                             </div>

                             <hr>


                             <?php
                                foreach ($permission_itens as $itens) {
                                ?>

                                 <div class="form-group">
                                     <div class="form-check">
                                         <input <?= (in_array($itens['slug'], $permission_group_slugs) ? 'checked="checked"' : '') ?> class="form-check-input" type="checkbox" name="itens[]" id="item-<?= $itens['id']; ?>" value="<?= $itens['id']; ?>">
                                         <label class="form-check-label"><?= $itens['name']; ?></label>
                                     </div>
                                 </div>

                             <?php } ?>


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