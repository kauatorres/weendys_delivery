<?php
$id = filter_input(INPUT_GET, 'id'); 
if(empty($id)){
    header('location: ../inicio');
}

if($consultaPedidos['status_compra'] == "approved"){
    $status_compra = "PAGO";
}else{
    $status_compra = "EM ANÁLISE";
}
$disabled = null;

if($consultaPedidos['status_pedido'] == "3"){
    $icon = 'fast-food-outline';
    $status_pedido = "Aguardando entrega...";
    $btnText = 'MARCAR COMO ENTREGUE';
}elseif($consultaPedidos['status_pedido'] == "4"){
    $status_pedido = "Entregue";
    $icon = 'checkmark-done-outline';
    $disabled = 'disabled';
    $btnText = 'PEDIDO JÁ ENTREGUE';
}
?>
<div class="section full mt-2" style="text-align: -webkit-center;">
    <div class="wide-block pt-2 pb-1">
        
        <div class="card bg-light mb-2">
            <div class="card-header"><?=$consultaPedidos['nomeCliente']?>  / #<?=$id;?></div>
            <div class="card-body">
                <h5 class="card-title" style="font-size: 20px;"><ion-icon name="<?=$icon;?>"></ion-icon> <?=$status_pedido;?></h5>
                <p class="card-text"><?=$consultaPedidos['endereco_entrega']?></p>
                <p class="card-text">Status do pagamento: <b style="color:green;"><?=$status_compra;?></b></p>
            </div>
        </div>
        
        <div class="divider bg-secondary mt-5 mb-5">
                <div class="icon-box bg-secondary">
                    <ion-icon name="cog" role="img" class="md hydrated" aria-label="cog"></ion-icon>
                </div>
        </div>

        <button type="button" class="btn btn-success mr-1 mb-1" data-toggle="modal" data-target="#DialogIconedSuccess" <?=$disabled;?> >
            <ion-icon name="checkmark-circle-outline" role="img" class="md hydrated" aria-label="document text outline"></ion-icon>
            <?=$btnText;?>
        </button>

        <!-- DialogIconedSuccess -->
        <div class="modal fade dialogbox" id="DialogIconedSuccess" data-backdrop="static" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-icon text-success">
                        <ion-icon name="checkmark-circle"></ion-icon>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title">Sucesso!</h5>
                    </div>
                    <div class="modal-body">
                        Pedido entregue com sucesso.
                    </div>
                    <div class="modal-footer">
                        <div class="btn-inline">
                            <a href="#" class="btn" data-dismiss="modal">Fechar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- * DialogIconedSuccess -->


    </div>
</div>

