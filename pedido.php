<?php
include("inc/config.php");
include("inc/functions.php");
$key = $KEY_MPP_ACCESSTOKEN;
$id = $_GET['id'];


$nome_sobrenome = $nome . " " . $sobrenome;
$pedido = "#" . procurarPedido($id)->id;
$status = procurarPedido($id)->status; //status compra
$status_pedido = 1; //status pedido
$dataPedidoCriado = procurarPedido($id)->date_approved;

$metodoPagamento = (procurarPedido($id)->payment_method_id == "pix") ? "PIX" : "CARTÃO DE CRÉDITO";
$metodoPagamentoIcone = (procurarPedido($id)->payment_method_id == "pix") ? "pix" : "credit_card";
$dataPorExtenso = ucfirst(strftime('%A, %d de %B de %Y', strtotime($dataPedidoCriado)));
//Redireciona pra finalizar.php se pagamento nao tiver aprovado.
if (!procurarPedido($id)) {
    header('location: finalizar');
}

//Se não tiver cadastrado o pedido, faz o cadastro no banco de dados
if (!$consultaPedidos) {
    $carrinhoArray = [];
    $quantidadeItens = count($_SESSION['carrinho']);
    foreach ($_SESSION['carrinho'] as $key => $item) {
        $idProd = $item['id_produto'];
        $tamanho_id = $item['tamanho'];
        $prods = $pdo->query("SELECT * FROM produtos AS p JOIN tamanhos AS t ON p.idProduto = t.id_produto WHERE t.id_tamanho = '$tamanho_id'");
        $prods = $prods->fetch(PDO::FETCH_ASSOC);
        $idItem = $prods['idProduto'];
        $nomeItem = $prods['produto'];
        $qtdItem = $item['qtd'];
        $tamItem = $prods['tamanho'];
        $precoItem = $prods['valor_produto'];
        if (!in_array($tamanho_id, $carrinhoArray)) {
            $carrinhoArray[] = $item['tamanho'];
            //atualizar quantidade de venda
            $tVendas = $pdo->prepare("UPDATE produtos SET total_vendas = (total_vendas + 1) WHERE idProduto = '$idItem'");
            $tVendas->execute();
            //criar pedido
            $criar = $pdo->prepare("INSERT INTO `pedidos`(`idPedido`, `nomeCliente`, `cpfCliente`, `produto`, `quantidade`, `tamanho`, `endereco_entrega`, `valor`, `metodo_pagamento`, `status_compra`, `status_pedido`) VALUES ('$id','$nome_sobrenome','$cpf','$nomeItem','$qtdItem','$tamItem','$endereco','$precoItem','$metodoPagamento','$status','$status_pedido')");
            $criar->execute();
            //criar notifica_pedidos
            $criarNotificacao = $pdo->prepare("INSERT INTO `notifica_pedidos`(`id_pedido`, `status_notificacao`) VALUES ('$id','0')");
            $criarNotificacao->execute();

            unset($_SESSION['carrinho']);
        }
    }

    header("location: pedido.php?id=" . $id);
}

//Mostrar Status
if ($status == 'approved') {
    $showStatus  =  'Aprovado';
    $textColor = 'success';
    $icon = 'check-circle';
} elseif ($status == 'pending') {
    $showStatus  =  'Pendente';
    $textColor = 'warning';
    $icon = 'exclamation-triangle';
} elseif ($status == 'refunded') {
    $showStatus  =  'Devolvido';
    $textColor = 'info';
    $icon = 'exclamation-circle ';
}



?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta meta name="viewport" content="width=device-width, user-scalable=no, shrink-to-fit=no" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://www.apple.com/wss/fonts?families=SF+Pro,v3|SF+Pro+Icons,v3">
    <link rel="stylesheet" href="src/css/icons.css?v=<?= filesize('src/css/icons.css'); ?>">
    <link rel="stylesheet" href="src/css/track.css?v=<?= filesize('src/css/track.css'); ?>">
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script>
        var clearTimer = setInterval(function() {
            var req = new XMLHttpRequest();
            var resposta = "<span style='color:green;'><i class='fa fa-check'></i> Compra efetuada.</span>";
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    document.getElementById('status-pedido').innerHTML = req.responseText;
                }
            }
            req.open('GET', 'pedido.php?id=<?= $id; ?>&atualizarStatusPedido', true);
            req.send();
        }, 1510);
    </script>
    <title>Delivery - Pedido <?= $pedido; ?></title>
</head>

<body class="snippet-body" style="background-color:#edf4f7!important">
    <div class="d-flex flex-column justify-content-center align-items-center" id="order-heading">
        <div class="text-uppercase">
            <p>Detalhes do Pedido</p>
            <p></p>
        </div>
        <div class="pt-1 badge badge-info" style="font-size:14px;font-family:'SFBold';"><i class="fa fa-clock-o"></i> Previsão de entrega: <?= $tempoEstimado ?> - <?= $tempoEstimado + 15 ?>min</div>
        <!-- <div class="h4">Pedido concluído às <?= date('H:i', strtotime($dataPedidoCriado)); ?></div> -->

        <div id="status-pedido">Carregando...</div>


    </div>
    <div class="wrapper bg-white">
        <div class="table">
            <table class="table table-borderless" style="margin-bottom: -1rem!important;">
                <thead>
                    <tr class="text-uppercase text-muted">
                        <th scope="col">Itens do pedido</th>
                    </tr>
                </thead>
            </table>
        </div>
        <?php
        $total = 0;
        foreach ($listarPedidos as $produtos) {
            $total +=  $produtos['valor'];
        ?>
            <div class="d-flex justify-content-start align-items-center list py-1 border-bottom">
                <div class="mx-3" style="margin-left:0rem!important"> </div>
                <div class="order-item">
                    (<?= $produtos['quantidade']; ?>x) <?= $produtos['produto']; ?> - <?= $produtos['tamanho']; ?>
                </div>
            </div>
        <?php } ?>


        <div class="pt-2"></div>
        <div class="d-flex justify-content-start align-items-center pl-3">
            <div class="text-muted">MÉTODO DE PAGAMENTO</div>
            <div class="ml-auto"> <span class="material-icons"><?= $metodoPagamentoIcone; ?></span> <label><?= $metodoPagamento; ?></label> </div>
        </div>
        <div class="d-flex justify-content-start align-items-center py-1 pl-3 border-bottom">
            <div class="text-muted">TELE-ENTREGA</div>
            <div class="ml-auto"> <label>R$ <?= number_format($valorTele, 2, ",", "."); ?></label> </div>
        </div>

        <div class="d-flex justify-content-start align-items-center py-1 pl-3 border-bottom">
            <div class="text-muted">SUB TOTAL</div>
            <div class="ml-auto"> <label>R$ <?= number_format($total, 2, ",", "."); ?></label> </div>
        </div>

        <div class="d-flex justify-content-start align-items-center pl-3 py-3 mb-4 border-bottom">
            <div class="text-muted"> TOTAL </div>
            <div class="ml-auto h5"> R$ <?= number_format($valorTele + $total, 2, ",", "."); ?> </div>
        </div>

        <div class="row border rounded p-1 my-3">
            <div class="col-md-6">
                <div class="d-flex flex-column align-items start"> <b>Endereço de Entrega</b>
                    <p class="text-justify pt-2">
                        <?= $endereco; ?>
                    </p>
                </div>
            </div>

        </div>
        <div class="pl-3 font-weight-bold">Informações</div>
        <div class="d-sm-flex justify-content-between rounded my-3 subscriptions">
            <div> <b><?= $pedido; ?></b> </div>
            <div><?= $dataPorExtenso; ?></div>
            <div>Status: <span class="text-<?= $textColor; ?>  font-weight-bold">
                    <i class="fa fa-<?= $icon; ?>"></i> <?= $showStatus; ?> </span>
            </div>
        </div>
    </div>


    </script>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <script src="src/js/erros_cartao.js"></script>
    <script src="src/js/javascript.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>