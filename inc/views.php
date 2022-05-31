<?php
include_once "config.php";
include_once "functions.php";

// MOSTRAR INFOS DO PRODUTO NO MODAL
if (isset($_GET["getProductInfo"])) {

    if (!isset($_POST["produto_id"])) {
        exit('Bad request.');
    }

    $resultado = '';

    $row_pedido = $pdo->query("SELECT * FROM pedidos WHERE idPedido = '" . $_POST["produto_id"] . "' LIMIT 1");
    $row_pedido = $row_pedido->fetch(PDO::FETCH_ASSOC);
    //Informações do pedido
    $resultado .= '<div class="card-body" id="listar">';
    $resultado .= '<h5 class="card-title">#' . $row_pedido['idPedido'] . ' - <span class="h6">' . ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($row_pedido['dataPedido'])))) . '</span></h5>';
    $resultado .= '<p class="card-text mb-1">Método de pagamento: <b>' . $row_pedido['metodo_pagamento'] . '</b></p>';
    $resultado .= '<p class="card-text mb-1">Status do pedido: <span class="text-white mb-1 badge bg-success">Aprovado</span></p>';
    $resultado .= '<p class="card-text mb-1">Valor do pedido: <b>R$ ' . number_format(procurarPedido($row_pedido['idPedido'])->transaction_amount, 2, ",", ".") . '</b></p>';
    $resultado .= '<p class="card-text mb-1">Endereço: <b>' . $row_pedido['endereco_entrega'] . '</b></p>';
    $resultado .= '</div>';
    //Listar pedidos
    $resultado .= '<hr style="margin: 0rem 0;">';
    $resultado .= '<ul class="list-group list-group-flush">';
    $idPedidoPerfil  = $row_pedido['idPedido'];
    $listarPedidosPerfil = $pdo->query("SELECT * FROM pedidos WHERE idPedido = '$idPedidoPerfil'");

    foreach ($listarPedidosPerfil as $pedidos) {
        $resultado .= '<li class="list-group-item">(' . $pedidos['quantidade'] . 'x) ' . $pedidos['produto'] . ' - ' . $pedidos['tamanho'] . ' — R$ ' . number_format($pedidos['valor'], 2, ",", ".") . '</li>';
    }
    $resultado .= '</ul>';

    exit($resultado);
}

if (isset($_GET["getPedidosClient"])) {

    $pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_NUMBER_INT);

    //Verificar se tem pedido
    $row_pedidoCount = $pdo->query("SELECT * FROM pedidos WHERE cpfCliente = '" . $consultaCliente['cpf'] . "'");
    $row_pedidoCount = $row_pedidoCount->rowCount();

    if (!empty($pagina) && $row_pedidoCount != 0) {
        //Calcular o inicio visualização
        $qnt_result_pg = 20; //Quantidade de registro por página
        $inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

        $row_pedido = $pdo->query("SELECT * FROM pedidos WHERE cpfCliente = '" . $consultaCliente['cpf'] . "' ORDER BY id ASC LIMIT $inicio, $qnt_result_pg");

        $resultado = '';

        //Informações do pedido
        $resultado .= '<ul class="timeline">';

        $pedidosArray = [];
        foreach ($row_pedido as  $pedido) {
            if (!in_array($pedido['idPedido'], $pedidosArray)) {
                $pedidosArray[] = $pedido['idPedido'];
                $resultado .= '<li class="timeline-item mb-5">';
                $resultado .= '<h5 class="fw-bold">#w' . $pedido['idPedido'] . ' <a style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modalPedidos" id="' . $pedido['idPedido'] . '" class="h6 view_data">(Ver detalhes completo)</a></h5>';
                $resultado .= '<p class=" text-muted mb-2 fw-bold">' . ucfirst(utf8_encode(strftime('%A, %d de %B de %Y', strtotime($pedido['dataPedido'])))) . '</p>';
                $resultado .= '<p class="text-muted">';
                $resultado .= '<p><b>Endereço:</b> ' . $pedido['endereco_entrega'] . '</p>';
                $resultado .= '</p>';
                $resultado .= '</li>';
            }
        }




        /* MODAL VER DETALHES PEDIDO */
        echo '<div class="modal fade" id="modalPedidos" tabindex="-1" aria-labelledby="modalPedidos" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informações do pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12">
                        <div class="card">
                            <span id="dataPedidos"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
        </div>';

        $resultado .= '</ul>';

        $row_pg = $pdo->query("SELECT * FROM pedidos WHERE cpfCliente = " . $consultaCliente['cpf'] . "");
        $row_pg = $row_pg->rowCount();

        $quantidade_pg = ceil($row_pg / $qnt_result_pg);

        //Limitar os link antes depois
        $max_links = 2;

        $paginacao = '';
        $paginacao .= '<nav aria-label="paginacao">';
        $paginacao .= '<ul class="pagination justify-content-center">';
        $paginacao .= '<li class="page-item">';
        $paginacao .= "<span class='page-link'><a  style='cursor:pointer;' onclick='listarPedidos(1)'>Primeira</a> </span>";
        $paginacao .= '</li>';
        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
            if ($pag_ant >= 1) {
                $paginacao .= "<li class='page-item'><a class='page-link'  style='cursor:pointer;' onclick='listarPedidos($pag_ant)'>$pag_ant </a></li>";
            }
        }
        $paginacao .= '<li class="page-item active" style="cursor:pointer;">';
        $paginacao .= '<span class="page-link" >';
        $paginacao .= "$pagina";
        $paginacao .= '</span>';
        $paginacao .= '</li>';

        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
            if ($pag_dep <= $quantidade_pg) {
                $paginacao .= "<li class='page-item'><a class='page-link'  style='cursor:pointer;' onclick='listarPedidos($pag_dep)'>$pag_dep</a></li>";
            }
        }
        $paginacao .= '<li class="page-item" style="cursor:pointer;">';
        $paginacao .= "<span class='page-link'><a style='cursor:pointer;' onclick='listarPedidos($quantidade_pg)'>Última</a></span>";
        $paginacao .= '</li>';
        $paginacao .= '</ul>';
        $paginacao .= '</nav>';
        echo $paginacao;

        echo $resultado;

        echo $paginacao;
    } else {
        exit("<div class    ='alert alert-warning' role='alert'>Nenhum pedido encontrado!</div>");
    }
}
