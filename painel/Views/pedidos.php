 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Pedidos</h1>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
         <?php

            use Models\Configuration;
            use Models\Pedidos;

            $_index = new Configuration();
            $index = new Pedidos();

            if (!empty($msg)) {  ?>
             <div class="callout callout-<?= $alert; ?>">
                 <h5><?= $textHeader; ?></h5>
                 <p><?= $msg; ?></p>
             </div>
         <?php } ?>

         <div class="row">
             <?php
                foreach ($ranking as $rank) {
                    extract($rank);
                ?>
                 <div class="col-lg-4 col-md-6">
                     <div class="small-box bg-warning">
                         <div class="inner">
                             <h3><?= $total_vendas; ?> <small style="font-size: 50%;">vendas</small></h3>
                             <p class="font-weight-bold"><?= $produto; ?></p>
                         </div>
                         <div class="icon">
                             <i class="fa-solid fa-ranking-star"></i>
                         </div>
                     </div>
                 </div>
             <?php } ?>
             <div class="col-12" id="tabelaPedidos">
                 <div class="card">
                     <div class="card-header">
                         <h3 class="card-title">Pedido de clientes</h3>
                         <div class="card-tools">
                             <div class="input-group input-group-sm" style="width: 150px;">
                                 <input type="text" name="table_search" id="pesquisar" class="form-control float-right" placeholder="Pesquisar">
                                 <div class="input-group-append">
                                     <button type="submit" class="btn btn-default">
                                         <i class="fas fa-search"></i>
                                     </button>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div class="card-body table-responsive p-0">
                         <table class="table table-hover text-nowrap">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Cliente</th>
                                     <th>CPF</th>
                                     <th>Valor</th>
                                     <th>Status Compra</th>
                                     <th></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    $pedidosArray = [];
                                    foreach ($listOrders as $key => $order) {
                                        extract($order);
                                        $total = number_format($valor * $quantidade, 2, ',', '.');
                                        $valor = number_format($valor, 2, ',', '.');

                                        $status_mp = $_index->pesquisarPedido($idPedido);
                                        $status = $index->getStatusOrder($status_pedido, $idPedido);
                                        $status_compra = $index->getStatusOrderBuy($status_mp);


                                        if (!in_array($idPedido, $pedidosArray)) {
                                            $pedidosArray[] = $idPedido;
                                            echo "
                                            <tr>
                                                <td>$idPedido</td>
                                                <td>$nomeCliente</td>
                                                <td>$cpfCliente</td>
                                                <td>R$ $total </td>
                                                <td>$status_compra</td>
                                                <td>
                                                    <a href='" . BASE_URL . "pedidos/detalhes/$idPedido' class='btn btn-info btn-sm'><i class='fa-solid fa-file-circle-info'></i></a>
                                                    $status
                                                    </td>
                                            </tr>
                                        ";
                                        }
                                    }
                                    ?>

                             </tbody>
                         </table>
                     </div>

                 </div>

             </div>
         </div>



     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->