<?php
include('../../inc/config.php');
include('../../vendor/autoload.php');
session_start();
$ACCESS_TOKEN = 'TEST-2426877546667017-080302-84f6b39e357af40b7bc160f9b342c129-327336472';
//$ACCESS_TOKEN = $KEY_MPP_ACCESSTOKEN;

// $exception= new ClassException();
// $exception->setPayment($_SESSION['payment']);



$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$cardNumber = filter_input(INPUT_POST, 'cardNumber', FILTER_DEFAULT);
$securityCode = filter_input(INPUT_POST, 'securityCode', FILTER_DEFAULT);
$cardExpirationMonth = filter_input(INPUT_POST, 'cardExpirationMonth', FILTER_DEFAULT);
$cardExpirationYear = filter_input(INPUT_POST, 'cardExpirationYear', FILTER_DEFAULT);
$cardholderName = filter_input(INPUT_POST, 'cardholderName', FILTER_DEFAULT);
$docType = filter_input(INPUT_POST, 'docType', FILTER_DEFAULT);
$docNumber = filter_input(INPUT_POST, 'docNumber', FILTER_DEFAULT);
$installments = filter_input(INPUT_POST, 'installments', FILTER_DEFAULT);
$amount = filter_input(INPUT_POST, 'amount', FILTER_DEFAULT);
$description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
$paymentMethodId = filter_input(INPUT_POST, 'paymentMethodId', FILTER_DEFAULT);
$token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);


MercadoPago\SDK::setAccessToken($ACCESS_TOKEN);

//Cria um cliente
$customer = new MercadoPago\Customer();
$customer->email = $consultaCliente['email'];
$customer->save();

$_SESSION['customer_id'] = $customer->id;
$_SESSION['token'] = $token;

//Cria um pagamento
$payment = new MercadoPago\Payment();
$payment->transaction_amount = $_SESSION['totalBRL'];
$payment->token = $token; //Token cartao
$payment->description = $description;
$payment->installments = $installments;
$payment->payment_method_id = $paymentMethodId;
//$payment->notification_url = 'http://localhost/pixMP/pagamento/notificacao.php';

$payment->payer = array(
    "email" => $email
);
$payment->save();
$_SESSION['payment'] = $payment;
// $exception->verifyTransaction()['class']; //classe de alerta
// echo $exception->verifyTransaction()['message']; 
header('location: retorno.php');
