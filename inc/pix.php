<?php
require_once 'config.php'; 
require_once 'vendor/autoload.php'; 

MercadoPago\SDK::setAccessToken($KEY_MPP_ACCESSTOKEN); 


if(isset($_SESSION['totalBRL'])){
$payment = new MercadoPago\Payment();

$payment->transaction_amount =  $_SESSION['totalBRL'];
$payment->description = $titulo; //Nome Produto
$payment->payment_method_id = "pix";
$payment->payer = array(
  "email" => $_SESSION['email'], // Não pode ser o mesmo e-mail do mercado pago
  "first_name" => $_SESSION['nome'], //colocar input de nome/sobrenome e separar 
  "last_name" => $_SESSION['sobrenome'],
  "identification" => array(
      "type" => "CPF",
      "number" => "04259171003" // cpf cliente 
  )
);
if($payment->save()){
    $dados = [
        'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64,
        'qr_code' => $payment->point_of_interaction->transaction_data->qr_code,
        'payment_id' => $payment->id, // fazer section do payment id se tiver pendente 
        'valor' => $_SESSION['totalBRL']
    ];
    $id = $dados['payment_id'];
    $qrCode = $dados['qr_code_base64'];
    $copiaCola = $dados['qr_code'];
}
}