<?php
require("../../vendor/autoload.php");
include "../class/ClassException.php";
session_start();

$exception= new ClassException();
$exception->setPayment($_SESSION['payment']);


$alert = $exception->verifyTransaction()['class']; //classe de alerta
$_SESSION['msg'] =  '<div class="alert alert-'.$alert.'">'.$exception->verifyTransaction()['message'].'</div>'; 

header('location: ../../finalizar.php');