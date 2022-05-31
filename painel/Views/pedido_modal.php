<div class="modal-body">
    <?php
    $vip = $data['total_pedidos'] >= 20 ? '<i class="text-warning fa-duotone fa-crown"></i>' : '';
    $status = $data['status_pedido'] == 1 ? '<span class="badge badge-warning">Aguardando sua aprovação</span>' : '<span class="badge badge-success">Aceito</span>';
    $cpf = $data['cpfCliente'];
    $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);

    //mascara de telefone
    $telefone = $data['whatsapp'];
    $telefone = '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 5);
    $total = 0;
    $listarPedidos = null;
    foreach ($dataOrder as $item) {
        $produto = $item['produto'];
        $quantidade = $item['quantidade'];
        $valor = $item['valor'];
        $valor = number_format($valor, 2, ',', '.');
        $tamanho = $item['tamanho'];
        $total += $item['valor'] * $item['quantidade'];
        $listarPedidos .= '<li class="list-group-item" style="background-color:#3e4246a8;border-radius:5px;margin-bottom:3px;border-bottom: 0px;">
                            (' . $quantidade . 'x) ' . $produto . ' - <b> ' . $tamanho . '</b>
                            </li>';
    } ?>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title font-weight-bold">Pedido #<?= $data['idPedido'] ?> </h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>
        </div>
        <div class="card-body">
            <div class="row" id="print">
                <div class="col-md-6">
                    <p class="card-text">
                        <b>Nome:</b> <?= $data['nomeCliente'] ?> <?= $vip; ?><br>
                        <b>CPF:</b> <?= $cpf ?><br>
                        <b>Whatsapp:</b> <?= $telefone; ?><br>
                        <b>Email:</b> <?= $data['email'] ?><br>
                        <b>Endereço:</b> <br> <?= $data['endereco'] ?><br>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="card-text">
                        <b>Data:</b> <?= date('d/m/Y H:i', strtotime($data['dataPedido'])) ?><br>
                        <b>Valor:</b> R$ <?= number_format($total, 2, ',', '.') ?><br>
                        <b>Forma de Pagamento:</b> <?= $data['metodo_pagamento'] ?><br>
                        <b>Status:</b> <?= $status ?><br>
                    </p>
                </div>
            </div>


            <hr style="background-color: #cccccc42; height: 1px; border: 0;">
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-group list-group-flush">
                        <?= $listarPedidos ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<div class="modal-footer">
    <button type="button" onclick="window.location.href = '<?= BASE_URL ?>configuration/recusar/<?= $data['idPedido']; ?>'" class="btn  btn-danger col-md-5" data-dismiss="modal">
        <i class="fa-duotone fa-circle-x"></i>
        RECUSAR
    </button>
    <button type="button" onclick="window.location.href = '<?= BASE_URL ?>configuration/aceitar/<?= $data['idPedido']; ?>'" class="btn btn-success col-md-5" data-dismiss="modal">
        <i class="fa-duotone fa-circle-check"></i>
        ACEITAR - <b>R$ <?= number_format($total, 2, ',', '.') ?></b>
    </button>
</div>