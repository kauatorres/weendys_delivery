<?php

use Models\Configuration;
use Models\Pedidos;

$_index = new Configuration();
$index = new Pedidos();
?>
<div class="container-fluid">

    <div class="container">
        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="h5 mb-0"><a href="#" class="text-muted"></a>
                <a href="<?= BASE_URL ?>pedidos" class="btn btn-sm btn-success"><i class="fas fa-arrow-left"></i></a>

                Pedido #<?= $order[0]['idPedido'] ?>

                <?php
                $status_pedido = $_index->pesquisarPedido($order[0]['idPedido']);
                $status = $index->getStatusOrderBuy($status_pedido);
                ?>
            </h2>
        </div>

        <!-- Main content -->
        <div class="row">
            <?php
            if (!empty($msg)) {  ?>
                <div class="callout callout-<?= $alert; ?>">
                    <h5><?= $textHeader; ?></h5>
                    <p><?= $msg; ?></p>
                </div>
            <?php } ?>
            <div class="col-lg-8">
                <!-- Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="font-weight-bold">
                                <span class="me-3">
                                    <?php
                                    //formatar  data e hora
                                    $data = date('d/m/Y', strtotime($order[0]['dataPedido']));
                                    $hora = date('H:i', strtotime($order[0]['dataPedido']));
                                    echo "Pedido feito dia " . $data . ' às ' . $hora;
                                    ?>
                                </span>
                            </div>
                            <div class="d-flex">
                                <?php
                                if ($status_pedido == 'approved') {
                                ?>
                                    <a onclick="window.location.href='<?= BASE_URL . 'pedidos/estornar/' . $order[0]['idPedido']; ?>'" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                        Reembolso
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <table class="table table-borderless">
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($order as $list) {
                                    $total += $list['valor'] * $list['quantidade'];
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex mb-2">
                                                <div class="flex-lg-grow-1 ms-3">
                                                    <h6 class="font-weight-bold mb-0"><span class="text-reset"> <?= $list['produto']; ?> </span></h6>
                                                    <span class="font-weight-bold">Tamanho: <?= $list['tamanho']; ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $list['quantidade']; ?>x</td>
                                        <td class="text-end">R$ <?= number_format($list['valor'] * $list['quantidade'], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold text-success">
                                    <td colspan="2">TOTAL</td>
                                    <td class="text-end">R$ <?= number_format($total, 2, ',', '.'); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Payment -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="h6">Método de pagamento</h3>
                                <p class="font-weight-bold text-info"><?= $order[0]['metodo_pagamento']; ?><br>
                                    <span class="font-weight-bold text-light">Total: R$ <?= number_format($total, 2, ',', '.'); ?></span> <?= $status; ?>
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <h3 class="h6">Endereço de entrega</h3>
                                <address>
                                    <strong><?= $order[0]['nomeCliente']; ?> - CPF <?= $cpf = preg_replace("/^(\d{3})(\d{3})(\d{3})(\d{2})$/", "\$1.\$2.\$3-\$4", $order[0]['cpfCliente']); ?></strong><br>
                                    <?= $order[0]['endereco_entrega']; ?><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="h6">Observações</h3>
                        <p>
                        <div class="alert alert-warning">Nenhuma observação para mostrar.</div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>