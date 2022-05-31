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
         <?php if (!empty($msg)) {  ?>
             <div class="callout callout-<?= $alert; ?>">
                 <h5><?= $textHeader; ?></h5>
                 <p><?= $msg; ?></p>
             </div>
         <?php } ?>

         <div class="row">

             <div class="col-md-12">
                 <!-- Default box -->

                 <div class="card">
                     <div class="card-header">
                         <h3 class="card-title">Itens de Permissões</h3>
                         <div class="card-tools text-center">
                             <a href="<?= BASE_URL . 'permissions/itens_add' ?>" type="button" class="btn  btn-success btn-sm"><i class="fa-duotone fa-list-check"></i> Adicionar item de permissão</a>
                         </div>
                     </div>
                     <div class="card-body p-0">

                         <table class="table table-striped">
                             <thead>
                                 <tr>
                                     <th>Nome permissão</th>
                                     <th>Slug</th>
                                     <th>Ações</th>
                                 </tr>
                             </thead>
                             <tbody>

                                 <?php foreach ($list as $item) { ?>
                                     <tr>
                                         <td><?= $item['name']; ?></td>
                                         <td>
                                             <?= $item['slug']; ?>
                                         </td>
                                         <td>
                                             <div class="btn-group">
                                                 <a href="<?= BASE_URL . 'permissions/item_edit/' . $item['id'] ?>" type="button" class="btn btn-default">
                                                     <i class="fas fa-edit"></i>
                                                 </a>
                                                 <a type="button" onclick="confirmExclude('<?= BASE_URL . 'permissions/item_delete/' . $item['id'] ?>');" class="btn btn-default <?= (($item['id'] == '1') ? 'disabled' : ''); ?>">
                                                     <i class="fa-solid fa-trash-can"></i>
                                                 </a>
                                             </div>
                                         </td>
                                     </tr>
                                 <?php } ?>
                             </tbody>
                         </table>


                     </div>
                     <!-- /.card-body -->

                 </div>
                 <!-- /.card -->
             </div>
         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->