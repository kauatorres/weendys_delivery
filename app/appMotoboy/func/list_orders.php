<?php
include('../../../inc/config.php');
session_start();

$statusPedido = 3;

if (isset($_POST["nome"])) {
	$busca = $_POST["nome"];
    $listSales = $pdo->query("SELECT * FROM pedidos WHERE status_pedido = '3' AND idPedido LIKE '%".$busca."%' OR nomeCliente LIKE '%".$busca."%'");
    $count = $listSales->rowCount();
}else {
	$listSales = $pdo->query("SELECT * FROM pedidos WHERE status_pedido = '3'");
    $count = $listSales->rowCount();
}

?>

<?php
if($count){
 foreach($listSales as $orders) {

           echo '<li>
                <a href="pedido?id='.$orders['idPedido'].'" class="item">
                    <div class="icon-box bg-secondary">
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                    <div class="in">
                    <div>
                        '.$orders['nomeCliente'].'
                        <footer>#'.$orders['idPedido'].'</footer>
                    </div>
                        <span class="text-muted">Visualizar</span>
                    </div>
                </a>
            </li>';
}
}else{
    echo '<div class="wide-block pt-2 pb-2">

            <div class="alert alert-outline-primary" role="alert">
                Nenhum pedido encontrado.  
            </div>

        </div>';
}
?>
