 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">
                     Catálogo
                     <button class="btn btn-info btn-sm" onclick="window.history.back();">
                         <i class="fa-duotone fa-rotate-left"></i> Voltar
                     </button>
                 </h1>
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
             <?php foreach ($listProducts as $products) { ?>
                 <div class="col-md-3  py-2">
                     <div class="card text-white  bg-dark"><img src="../../<?= $products['img']; ?>" class="card-img-top" style="object-fit: cover;max-width: 100%; max-height: 185px; width: auto; height: auto;" alt="...">
                         <div class="card-body">
                             <h5 class="card-title text-bold"><?= $products['produto']; ?></h5>
                             <p class="card-text py-1 text-muted text-center">
                                 <?php
                                    if ($products['statusDisponibilidade'] == 1) {
                                        echo '<span class="badge badge-success">Disponível</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Indisponível</span>';
                                    }
                                    ?>
                             </p>
                             <div class="d-grid gap-2 ">
                                 <button type="button" class="btn btn-danger btn-sm" onclick="confirmExclude('<?= BASE_URL . 'produtos/product_del/' . $products['idProduto'] ?>')"><i class="fa-duotone fa-trash-can"></i> Remover</button>
                                 <button type="button" class="btn btn-success btn-sm" style="float: right;" onclick="window.location = '<?= BASE_URL . 'produtos/product_edit/' . $products['idProduto'] ?>'"><i class="fa-duotone fa-pen-to-square"></i> Editar</button>
                             </div>
                         </div>
                     </div>
                 </div>
             <?php } ?>





         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->