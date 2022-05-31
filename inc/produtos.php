<?php
include('config.php');
session_start();
$jsonArray = array();

if (isset($_GET['prods'])) {
    while ($row = $consultaProdutos->fetch(PDO::FETCH_ASSOC)) {
        $jsonArray = $row;
        $idProd = $jsonArray['idProduto'];
        //Listar valores
        $consultaTamanhos = $pdo->query("SELECT * FROM tamanhos WHERE id_produto = '$idProd' ORDER by valor_produto ASC");
        $consultaTamanhos = $consultaTamanhos->fetchAll();
        //Pegar menor valor 
        $lowPriceArray = array();
        $getLowPrice = $pdo->query("SELECT * FROM tamanhos WHERE id_produto = '$idProd' ORDER by valor_produto ASC");
        $lowPriceArray = $getLowPrice->fetch(PDO::FETCH_ASSOC);

        $tam = null;

        $Count = count($consultaTamanhos);
        foreach ($consultaTamanhos as $key => $tamanho) {
            $zIndex = $Count - 1 - $key;
            $tam .= '<option value="' . $tamanho['id_tamanho'] . '" data-key="' . $zIndex . '">' . $tamanho['tamanho'] . ' - R$ ' . number_format($tamanho['valor_produto'], 2, ",", ".") . '</option>';
        }

        //verificar disponibilidade 
        if ($jsonArray['statusDisponibilidade'] == 0) {
            $statusText = 'Indisponível';
            $statusColor = 'danger';
            $disabled = 'disabled';
        } elseif ($jsonArray['statusDisponibilidade'] == 1) {
            $statusText = 'Disponível';
            $statusColor = 'success';
            $disabled = null;
        }
        $resultado = '';


        $resultado .= '<div class="col-md-3  py-2">';
        $resultado .= '<div class="card text-white  bg-dark">';
        $resultado .= '<img src="' . $jsonArray['img'] . '" class="card-img-top" style="width: 100%;height:200px;" alt="...">';
        $resultado .= '<div class="card-body">';
        $resultado .= '<h5 class="card-title">' . $jsonArray['produto'] . '</h5>';
        $resultado .= '<p class="card-text text-muted text-center">A partir de <b>R$ ' . number_format($lowPriceArray['valor_produto'], 2, ",", ".") . ' </b>  </p>';
        $resultado .= '<div class="d-grid gap-2 py-1">';
        // $resultado .= '<a href="inc/produtos.php?acao=add&id=' . $jsonArray['idProduto'] . '" class="btn btn-primary"><i class="fa-duotone fa-cart-plus"></i> Adicionar ao carrinho</a>';
        $resultado .= '<a data-bs-toggle="modal"  data-bs-target="#produto-' . $jsonArray['idProduto'] . '" class="btn btn-primary"><i class="fa-duotone fa-cart-plus"></i> Adicionar</a>';
        $resultado .= '</div>';
        $resultado .= '</div>';
        $resultado .= '</div>';
        $resultado .= '</div>';



        $resultado .=
            '<div class="modal fade" id="produto-' . $jsonArray['idProduto'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="">Adicionar ao carrinho</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="inc/produtos.php?acao=add" id="cart-' . $jsonArray['idProduto'] . '">
            <div class="modal-body">
            
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-' . $statusColor . '">' . $statusText . '</strong>
              <h3 class="mb-0">' . $jsonArray['produto'] . '</h3>
              <div class="mb-1 text-muted"></div>
              <p class="mb-auto">' . $jsonArray['descricao_produto'] . '</p>

              <div class="row">
              
              <div class="col-md-4">
              <div class="mb-0 py-1 text-muted">Escolha o tamanho</div>
                    <select name="tamanho" class="form-select" id="tamanho-' . $jsonArray['idProduto'] . '" onchange="getSizes(this, ' . $jsonArray['idProduto'] . ')" required ' . $disabled . '>
                        <option value="">Selecione um tamanho</value>
                        ' . $tam . '
                    </select>
              </div>
              
              <div class="col-md-4">
              <div class="mb-0 py-1 text-muted">Quantidade</div>
              <input type="number" value="1" name="qtd" class="form-control text-center" min="0" max="500" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" ' . $disabled . ' required/>
              </div>
              </div>

              
            </div>
            <div class="col-auto d-none d-lg-block">
              
            </div>
            </div>
               

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" id="btn-add-' . $jsonArray['idProduto'] . '" ' . $disabled . '><i class="fa-duotone fa-cart-plus"></i> Adicionar ao carrinho <span id="valor_button' . $jsonArray['idProduto'] . '"></span></button>
            </div>
            </form>
            </div>
        </div>
        </div>';

        echo $resultado;
    }
}



if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho']  = array();
}
/* echo '<pre>';
var_dump($_SESSION['carrinho']);
echo '</pre>'; */
//Adicionar produto
if (isset($_GET['acao'])) {
    $limiteQuantidade = 500; // Limite de quantidade de compras

    //Adicionar ao carrinho
    if ($_GET['acao'] == "add") {
        $id = intval($_POST['id']); //idTamanho
        $id_prod = intval($_POST['id_prod']);
        $tam = $_POST['tamanho'];
        $valor = $_POST['valor'][$id];
        $qtd = (intval($_POST['qtd']) == 0) ? '1' : intval($_POST['qtd']);
        $md5Cart = md5(time() . date('s'));
        $arrayCart = array(
            'id' => $id,
            'id_produto' => $id_prod,
            'tamanho' => $tam,
            'valor' => $valor,
            'qtd' => $qtd,
            'hash' => $md5Cart
        );
        $vP = $pdo->query("SELECT * FROM produtos WHERE idProduto = '$id_prod'");
        $vP = $vP->fetch(PDO::FETCH_ASSOC);
        if ($vP['statusDisponibilidade'] == 1) { //Se o status disponibilidade for igual a 1 ele adiciona.
            if (!isset($_SESSION['carrinho'][$id])) {
                $_SESSION['carrinho'][$id] = $arrayCart;
            } else {
                $_SESSION['carrinho'][$id]['qtd'] += $qtd;
            }
        }
    }
    //Remover do carrinho
    if ($_GET['acao'] == "remover") {
        $id = intval($_POST['id']);
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
    }

    //Atualizar carrinho
    if ($_GET['acao'] == "qtd") {

        $id = intval($_POST['id']);
        $qtd = intval($_POST['qtd']);
        if ($qtd >= $limiteQuantidade) {
            $qtd = $limiteQuantidade;
        }
        if ($qtd <= 0) {
            unset($_SESSION['carrinho'][$id]);
        } else {
            $_SESSION['carrinho'][$id]['qtd'] = $qtd;
        }
    }

    //Limpar carrinho
    if ($_GET['acao'] == "limpar") {
        unset($_SESSION['carrinho']);
    }

    header('location: ../carrinho');
}
if (isset($_GET['carrinho_de_compras'])) {
    if (count($_SESSION['carrinho']) == 0) {
        echo "<div class='alert alert-warning'>Nenhum produto no carrinho.</div>";
    } else {
        $carrinhoArray = [];
        $total = 0;
        foreach ($_SESSION['carrinho'] as $key => $item) {
            $idProd = $item['id_produto'];
            $tamanho_id = $item['tamanho'];
            $prods = $pdo->query("SELECT * FROM produtos AS p JOIN tamanhos AS t ON p.idProduto = t.id_produto WHERE t.id_tamanho = '$tamanho_id'");
            $prods = $prods->fetch(PDO::FETCH_ASSOC);
            $total += $prods['valor_produto'] * $item['qtd'];

            if (!in_array($tamanho_id, $carrinhoArray)) {
                $carrinhoArray[] = $item['tamanho'];
?>
                <div class="BasketTable">
                    <div class="BasketTable-header">
                        <div class="BasketTable-header-quantity">Quantidade</div>
                        <div class="BasketTable-header-price">Preço</div>
                    </div>
                    <div class="BasketTable-items">
                        <div class="BasketItem">
                            <div class="BasketItem-productContainer">
                                <div class="BasketItemProduct">
                                    <span class="BasketItemProduct-image">
                                        <img style="max-width: 105px; max-height: 95px;" src="<?= $prods['img']; ?>">
                                    </span>
                                    <div class="BasketItemProduct-info">
                                        <p><?= $prods['produto']; ?></p>
                                        <p class="BasketItemProduct-info-sku" style="margin-top: -15px;">
                                            Tamanho: <?= $prods['tamanho']; ?>
                                        </p>
                                        <p class="BasketItemProduct-info-sku" style="margin-top: -15px;">
                                            Quantidade: <?= $item['qtd']; ?>
                                        </p>
                                        <div class="BasketItemProduct-info-store">
                                            <span class="BasketItemProduct-informative">
                                                <div>
                                                    <p class="BasketItemProduct-delivery-message">Receba em até <?= $tempoEstimado; ?> minutos</p>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="BasketItemProduct-quantity">
                                    <form method="POST" action="inc/produtos.php?acao=qtd" id="add-qtd">
                                        <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                        <input type="number" value="<?= $item['qtd']; ?>" name="qtd" class="form-control text-center BasketItemProduct-quantity-dropdown" min="0" max="500" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                                        <button type="submit" class="BasketItemProduct-quantity-remove BasketItem-Qtd">
                                            <i class="fa-duotone fa-arrow-rotate-right"></i>
                                            <span class="BasketItem-delete-label"> Atualizar</span></button>
                                    </form>
                                    <form method="POST" action="inc/produtos.php?acao=remover" id="add-qtd">
                                        <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                        <button type="submit" class="BasketItemProduct-quantity-remove">
                                            <i class="fa-solid fa-trash-can"></i>
                                            <span class="BasketItem-delete-label"> Excluir</span></button>
                                    </form>
                                </div>
                                <div class="BasketItemProduct-price"><span class="BasketItemPrice-listPrice">
                                    </span>R$ <?= number_format($prods['valor_produto'] * $item['qtd'], 2, ",", "."); ?><span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
        <?php
        //Cria sessao do total
        $_SESSION['totalBRL'] = $total;
        if (count($_SESSION['carrinho']) > 0) { ?>
            <div class="BasketPriceBox">
                <div class="BasketPriceBox-prices">
                    <div class="BasketPriceBox-price"><span class="BasketPriceBox-prices-title">
                            Subtotal
                            <span class="BasketPriceBox-prices-title--normal">
                                <?php
                                if (count($_SESSION['carrinho']) == 1) {
                                    $textItens = 'Item';
                                } else {
                                    $textItens = 'Itens';
                                }
                                ?>
                                (<?= count($_SESSION['carrinho']) . " " . $textItens; ?>)
                            </span>
                        </span>
                        <div class="BasketPriceBox-prices-values">

                            <div class="BasketPriceBox-prices--cash">
                                R$ <?= number_format($total, 2, ",", "."); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="BasketContinue">
                    <div class="BasketContinue-actions">
                        <a href="inc/produtos.php?acao=limpar" class="BasketContinue-buyMore" data-ga="{&quot;category&quot;: &quot;Carrinho&quot;, &quot;action&quot;: &quot;Comprar mais produtos&quot;, &quot;label&quot;: &quot;&quot;}">Limpar Carrinho</a>
                        <a href="./" class="BasketContinue-buyMore" data-ga="{&quot;category&quot;: &quot;Carrinho&quot;, &quot;action&quot;: &quot;Comprar mais produtos&quot;, &quot;label&quot;: &quot;&quot;}">Comprar mais produtos</a>
                        <button onclick="window.location.replace('finalizar')" class="BasketContinue-button">Continuar</button>
                    </div>

                </div>

            </div>
        <?php } ?>

<?php
    }
}
