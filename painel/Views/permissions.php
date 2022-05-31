 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Permissões</h1>
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
                         <h3 class="card-title">Grupos de Permissões</h3>
                         <div class="card-tools text-center">
                             <a href="<?= BASE_URL . 'permissions/itens' ?>" type="button" class="btn  btn-info btn-sm"><i class="fa-duotone fa-list"></i> Itens de permissão</a>
                             <a href="<?= BASE_URL . 'permissions/adicionar' ?>" type="button" class="btn  btn-success btn-sm"><i class="fa-duotone fa-layer-plus"></i> Adicionar grupo de permissão</a>
                         </div>
                     </div>
                     <div class="card-body p-0">

                         <table class="table table-striped">
                             <thead>
                                 <tr>
                                     <th>Nome permissão</th>
                                     <th>Qtd. ativos</th>
                                     <th>Ações</th>
                                 </tr>
                             </thead>
                             <tbody>

                                 <?php foreach ($list as $item) { ?>
                                     <tr>
                                         <td><?= $item['name']; ?></td>
                                         <td>
                                             <?= $item['total_users']; ?>
                                         </td>
                                         <td>
                                             <div class="btn-group">
                                                 <a href="<?= BASE_URL . 'permissions/edit/' . $item['id'] ?>" type="button" class="btn btn-default">
                                                     <i class="fas fa-edit"></i>
                                                 </a>
                                                 <a type="button" onclick="confirmExclude('<?= BASE_URL . 'permissions/delete/' . $item['id'] ?>');" class="btn btn-default <?= (($item['total_users'] != '0') ? 'disabled' : ''); ?>">
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