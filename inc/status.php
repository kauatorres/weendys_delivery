<?php
include('config.php');
require_once '../vendor/autoload.php';

MercadoPago\SDK::setAccessToken($KEY_MPP_ACCESSTOKEN);

$payment = new MercadoPago\Payment();

if (isset($_GET['paymentID'])) {
    $pId = $_GET['paymentID'];
    $status = ['status' => $payment->get($pId)->status];

    if ($status['status'] == 'approved') {
        echo 'approved';
    } elseif ($status['status'] == 'pending') {
        echo 'PENDENTE';
    } elseif ($status['status'] == 'refunded') {
        echo 'DEVOLVIDO';
    }
    exit;
} elseif (empty($_GET['paymentID'])) {
    exit('payment id não encontrado.');
}
