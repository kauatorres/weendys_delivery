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
                 <!-- Default box -->

                 <div class="card">
                     <div class="card-header">
                         <h3 class="card-title">Itens de Categoria</h3>
                         <div class="card-tools text-center">
                             <a href="<?= BASE_URL . 'produtos/category_add' ?>" type="button" class="btn  btn-success btn-sm"><i class="fa-solid fa-tags"></i> Adicionar categorias</a>
                         </div>
                     </div>
                     <div class="card-body p-0">

                         <table class="table table-striped">
                             <thead>
                                 <tr>
                                     <th>Nome categoria</th>
                                     <th>Qtd. ativos</th>
                                     <th>Ações</th>
                                 </tr>
                             </thead>
                             <tbody>

                                 <?php foreach ($listCategories as $item) { ?>
                                     <tr>
                                         <td><?= $item['nome_categoria']; ?></td>
                                         <td><?= $item['total_active']; ?></td>
                                         <td>
                                             <div class="btn-group">
                                                 <a href="<?= BASE_URL . 'produtos/edit_category/' . $item['id_categoria'] ?>" type="button" class="btn btn-default">
                                                     <i class="fas fa-edit"></i>
                                                 </a>
                                                 <a type="button" onclick="confirmExclude('<?= BASE_URL . 'produtos/delete_category/' . $item['id_categoria'] ?>');" class="btn btn-default <?= (($item['total_active'] != '0') ? 'disabled' : ''); ?>">
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