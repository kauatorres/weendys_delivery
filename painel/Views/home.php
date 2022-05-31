 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Dashboard</h1>
             </div><!-- /.col -->

         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
         <!-- ESTASTISTICAS INCIO -->
         <div class="row">
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-info">
                     <div class="inner">
                         <h3><?= $counterSalesDay; ?> <i class="fa-duotone fa-chart-line-up"></i></h3>

                         <p>Pedidos nas últimas 24h</p>
                         <!-- Pedidos feitos nas ultimas 24 horas -->
                     </div>
                     <div class="icon">
                         <i class="fa-duotone fa-bag-shopping"></i>
                     </div>
                 </div>
             </div>
             <!-- ./col -->
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-success">
                     <div class="inner">
                         <h3><?= $counterSales; ?></h3>

                         <p>Vendas desde o início</p>
                     </div>
                     <div class="icon">
                         <i class="fa-duotone fa-chart-column"></i>
                     </div>
                 </div>
             </div>
             <!-- ./col -->
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-warning">
                     <div class="inner">
                         <h3><?= $counterUsers; ?></h3>

                         <p>Clientes registrados</p>
                     </div>
                     <div class="icon">
                         <i class="fa-duotone fa-users"></i>
                     </div>
                 </div>
             </div>
             <!-- ./col -->
             <div class="col-lg-3 col-6">
                 <!-- small box -->
                 <div class="small-box bg-danger">
                     <div class="inner">
                         <h3><?= $counterProducts; ?></h3>

                         <p>Produtos</p>
                     </div>
                     <div class="icon">
                         <i class="fa-duotone fa-cart-shopping-fast"></i>
                     </div>
                 </div>
             </div>
             <!-- ./col -->
         </div>
         <!-- ESTASTISTICAS FIM -->

         <div class="row">
             <div class="col-md-6">
                 <div class="card">
                     <div class="card-header">
                         <h3 class="card-title">TICKETS EM ABERTO </h3>
                     </div>
                     <!-- /.card-header -->
                     <div class="card-body card-comments p-3">

                         <div class="card-comment">
                             <img class="img-circle img-sm" src="https://www.fiscalti.com.br/wp-content/uploads/2021/02/default-user-image.png">
                             <div class="comment-text">
                                 <span class="username">
                                     Nicole Torres
                                     <span class="badge bg-warning float-right">VER TICKET</span>
                                     <span class="text-muted float-right">Hoje às 22:05 ⠀</span>
                                 </span>
                                 It is a long established fact that a reader will be distracted
                                 by the readable content of a page when looking at its layout.
                             </div>
                         </div>

                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer clearfix">

                         <a href="<?= BASE_URL; ?>pedidos" class="btn btn-sm btn-secondary float-right">Ver todos tickets</a>
                     </div>
                 </div>
             </div>

             <div class="col-md-6">
                 <div class="card">
                     <div class="card-header">
                         <h3 class="card-title">PEDIDOS SOLICITADOS NAS ULTIMAS 24H</h3>
                     </div>
                     <!-- /.card-header -->
                     <div class="card-body p-0" id="pedidoRecente">
                         <?php
                            $message = null;
                            if (count($getRecentSales) == 0) {
                                $message .= '<div class="alert alert-warning m-2">Nenhum pedido feito neste período.</div>';
                            } else {
                            ?>

                             <table class="table table-striped">
                                 <thead>
                                     <tr>
                                         <th>ID Pedido</th>
                                         <th>Produto</th>
                                         <th>Valor</th>
                                     </tr>
                                 </thead>
                                 <tbody>

                                     <?php foreach ($getRecentSales as $recent) { ?>
                                         <tr>
                                             <td>#<?= $recent['idPedido']; ?></td>
                                             <td><?= $recent['produto']; ?></td>
                                             <td><span class="badge bg-warning">R$ <?= number_format($recent['valor'], 2, ',', '.'); ?></span></td>
                                         </tr>
                                     <?php } ?>
                                 </tbody>
                             </table>
                         <?php  } ?>
                         <?= $message; ?>

                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer clearfix">
                         <a href="<?= BASE_URL; ?>pedidos" class="btn btn-sm btn-secondary float-right">Ver todos pedidos</a>
                     </div>
                 </div>
             </div>
         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->