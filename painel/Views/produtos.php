 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Produtos</h1>
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
         <!-- ESTASTISTICAS INCIO -->
         <div class="row">
             <div class="col-lg-4 col-sm-6">
                 <!-- small box -->
                 <div class="small-box bg-success">
                     <div class="inner">
                         <h4 style="font-weight:bold;">Catálogo <i class="fa-duotone fa-cards-blank"></i></h4>
                     </div>

                     <a href="<?= BASE_URL . 'produtos/catalogo' ?>" class="small-box-footer">
                         Ver catálogo
                         <i class="fas fa-arrow-circle-right"></i>
                     </a>
                 </div>
             </div>
             <!-- ./col -->
             <div class="col-lg-4 col-sm-6">
                 <!-- small box -->
                 <div class="small-box bg-warning">
                     <div class="inner">
                         <h4 style="font-weight:bold;">Produtos <i class="fa-duotone fa-cart-plus"></i></h4>
                     </div>

                     <a href="<?= BASE_URL . 'produtos/adicionar' ?>" class="small-box-footer">
                         Adicionar produto
                         <i class="fas fa-arrow-circle-right"></i>
                     </a>
                 </div>
             </div>
             <!-- col -->
             <div class="col-lg-4 col-sm-6">
                 <!-- small box -->
                 <div class="small-box bg-primary">
                     <div class="inner">
                         <h4 style="font-weight:bold;">Categorias <i class="fa-duotone fa-tags"></i></h4>
                     </div>

                     <a href="<?= BASE_URL . 'produtos/categorias' ?>" class="small-box-footer">
                         Configurar categorias
                         <i class="fas fa-arrow-circle-right"></i>
                     </a>
                 </div>
             </div>



         </div>
         <!-- ESTASTISTICAS FIM -->

         <div class="row">

             <?php foreach ($listProducts as $products) { ?>
                 <div class="col-md-3  py-2">
                     <div class="card text-white  bg-dark"><img src="../<?= $products['img']; ?>" class="card-img-top" style="object-fit: cover;max-width: 100%; max-height: 185px; width: auto; height: auto;" alt="...">
                         <div class="card-body">
                             <h4 style="font-weight:bold;" class="card-title"><?= $products['produto']; ?></h4>
                             <p class="card-text py-1 text-muted">
                                 Status:
                                 <?php
                                    if ($products['statusDisponibilidade'] == 1) {
                                        echo '<span class="badge badge-success">Disponível</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Indisponível</span>';
                                    }
                                    ?>
                             </p>
                             <p class="card-text py-1 text-muted" style="margin-top: -20px;">Adicionado: <?= $products['dataAdd']; ?> </p>
                             <div class="d-grid gap-2 ">
                                 <button type="button" data-toggle="modal" data-target="#modal-<?= $products['idProduto']; ?>" class="btn btn-block btn-info btn-sm" style="float: right;"><i class="fa-solid fa-info"></i> Detalhes</button>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- modal produtos -->
                 <div class="modal fade" id="modal-<?= $products['idProduto']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                     <div class="modal-dialog modal-lg" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h4 class="modal-title"><?= $products['produto']; ?></h4>
                             </div>

                             <div class="modal-body row">
                                 <div class="col-md-5">
                                     <div class="card card-primary card-outline">
                                         <div class="card-body box-profile">
                                             <div class="text-center">
                                                 <img class="profile-user-img img-fluid img-circle circle" style="object-fit: cover;max-width: 100%;max-height: 100%;" src="../<?= $products['img']; ?>">
                                             </div>
                                             <h3 class="profile-username text-center"><?= $products['produto']; ?></h3>
                                             <ul class="list-group list-group-unbordered mb-3">

                                                 <li class="list-group-item">
                                                     <b>Categoria: </b> <span class="float-right"><?= $products['nome_categoria']; ?></span>
                                                 </li>

                                                 <li class="list-group-item">
                                                     <b>Disponibilidade: </b>
                                                     <span class="float-right">
                                                         <?php
                                                            if ($products['statusDisponibilidade'] == 1) {
                                                                echo '<span class="badge badge-success">Disponível</span>';
                                                            } else {
                                                                echo '<span class="badge badge-danger">Indisponível</span>';
                                                            }
                                                            ?>
                                                     </span>
                                                 </li>
                                             </ul>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-md-7">
                                     <div class="card card-primary card-outline">
                                         <div class="card-header">
                                             <h3 class="card-title">
                                                 <i class="fa-solid fa-asterisk"></i>
                                                 Detalhes do produto
                                             </h3>
                                         </div>
                                         <div class="card-body ">

                                             <p class="text-center"><?= $products['descricao_produto']; ?></p>
                                             <table class="table borderless">
                                                 <tbody>
                                                     <tr>
                                                         <td class="text-center">

                                                             <h1><i class="fa-duotone fa-cart-arrow-up"></i></h1>
                                                             <h4 style="font-weight: bold;"> <?= $products['total_vendas']; ?> </h4>
                                                             <h4>Vendas</h4>

                                                         </td>
                                                         <td class="text-center">
                                                             <h1><i class="fa-duotone fa-heart-circle-plus"></i></h1>
                                                             <h4 style="font-weight: bold;"> 0 </h4>
                                                             <h4>Favoritos</h4>
                                                         </td>
                                                     </tr>

                                                 </tbody>
                                             </table>
                                         </div>
                                     </div>
                                 </div>



                             </div>
                             <div class="modal-footer">

                                 <button type="button" class="btn btn-info col-md-4" data-dismiss="modal">
                                     <i class="fa-duotone fa-close"></i>
                                     Fechar
                                 </button>

                             </div>
                         </div>
                     </div>
                 </div>
             <?php } ?>




         </div><!-- /.container-fluid -->
     </div>
     <!-- /.content -->