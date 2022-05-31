<?php
require_once 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken($KEY_MPP_ACCESSTOKEN);
$payment = new MercadoPago\Payment();

// CRIA SESSOES DOS PRODUTOS
//totalCount (Pegar total de todos os itens)
//listarItens (Listar os itens no carrinho)
//totalBRL (Valor Total do carrinho)

if ($logado == 'true') {
    //Criar código QR Pix
    $payment->transaction_amount =  $_SESSION['totalBRL'] + $valorTele;
    $payment->description = $titulo; //Nome Produto
    $payment->payment_method_id = "pix";
    $payment->payer = array(
        "email" => $consultaCliente['email'], // Não pode ser o mesmo e-mail do mercado pago
        "first_name" => $consultaCliente['nome'], //colocar input de nome/sobrenome e separar 
        "last_name" => $consultaCliente['sobrenome'],
        "identification" => array(
            "type" => "CPF",
            "number" => $consultaCliente['cpf'] // cpf cliente 
        )
    );
    if ($payment->save()) {
        $dados = [
            'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64,
            'qr_code' => $payment->point_of_interaction->transaction_data->qr_code,
            'payment_id' => $payment->id, // fazer section do payment id se tiver pendente 
            'valor' => $_SESSION['totalBRL'] + $valorTele
        ];
        $idPaymentPix = $dados['payment_id'];
        $qrCodeBase64 = $dados['qr_code_base64'];
        $copiaECola = $dados['qr_code'];
    }
}
