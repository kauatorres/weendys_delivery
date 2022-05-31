<?php
$display = 'none';
?>
<div class="error-page">
    <div class="icon-box text-danger">
        <ion-icon name="alert-circle"></ion-icon>
    </div>
    <h1 class="title">ERRO 404</h1>
    <div class="text mb-5">
        Página não encontrada.
    </div>

    <div class="fixed-footer">
        <div class="row">
            <div class="col-6">
                <a onclick="window.history.back();" class="btn btn-secondary btn-lg btn-block">Voltar</a>
            </div>
            <div class="col-6">
                <a onclick="location.reload();" class="btn btn-primary btn-lg btn-block">Tentar novamente</a>
            </div>
        </div>
    </div>
</div>