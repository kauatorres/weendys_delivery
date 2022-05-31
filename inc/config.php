<?php
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

$idLoja = 1; // fazer um link especial para redirecionar com a sessao do id loja
$username = "root";
$password = "";
try {
  $pdo = new PDO('mysql:host=localhost;dbname=delivery', $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

if (isset($_COOKIE['logado']) == 'true') {
  $logado = 'true';
} else {
  $logado = null;
}

/* if (isset($_SESSION['idPaymentPix'])) {
  $idPayment =  $_SESSION['idPaymentPix'];
  $qrCode =    $_SESSION['qrCodeBase64'];
  $copiaCola =    $_SESSION['copiaECola'];
} */

//Consulta nas configurações
$consultaConfigs = $pdo->query("SELECT * FROM configs WHERE idLoja = '$idLoja';");
$consultaConfigs = $consultaConfigs->fetch(PDO::FETCH_ASSOC);

$idLoja = $consultaConfigs['idLoja'];
$titulo = $consultaConfigs['titulo'];
$emailLoja = $consultaConfigs['emailLoja'];
$header = $consultaConfigs['header'];
$cnpj = $consultaConfigs['cnpj'];
$logo = $consultaConfigs['logo'];
$valorTele = $consultaConfigs['valorTele'];
$tempoEstimado = $consultaConfigs['tempoEstimado'];
$anoInicioFooter = $consultaConfigs['anoInicioFooter'];
$whatsapp = $consultaConfigs['contatoWhats'];
$desenvolvedor = $consultaConfigs['desenvolvedor'];
//$chavePix = $consultaConfigs['chavePix'];
$KEY_MPP_ACCESSTOKEN = $consultaConfigs['chaveAccessToken'];
$KEY_MPP_PUBLICKEY = $consultaConfigs['chavePublicKey'];

//TeleEntrega
if ($valorTele == 0) {
  $valorTeleEntrega = 0;
  $textColor = 'success';
  $text  = 'Grátis';
} else {
  $valorTeleEntrega = $valorTele;
  $textColor = 'secondary';
}

//Consulta cliente registrado
if (isset($_COOKIE['cpf_email'])) {
  $cpf_email = $_COOKIE['cpf_email'];
  $consultaCliente = $pdo->query("SELECT * FROM clientes WHERE email = '$cpf_email' OR cpf = '$cpf_email'");
  $consultaCliente = $consultaCliente->fetch(PDO::FETCH_ASSOC);
  $nome = $consultaCliente['nome'];
  $sobrenome = $consultaCliente['sobrenome'];
  $cpf = $consultaCliente['cpf'];
  $email = $consultaCliente['email'];
  $endereco = $consultaCliente['endereco'];
} else {
  $consultaCliente = null;
}



//Consulta produtos
// $consultaProdutos = $pdo->query("SELECT * FROM produtos INNER JOIN tamanhos ON (produtos.idProduto = tamanhos.idProduto)");
$consultaProdutos = $pdo->query("SELECT * FROM produtos WHERE idLoja = '$idLoja'");

$consultaProdutoss = $pdo->query("SELECT * FROM produtos WHERE idLoja = '$idLoja'");

//Consulta pedido(s)
$idPedido = filter_input(INPUT_GET, 'id'); //parametro da pagina de pedido
$consultaPedidos = $pdo->query("SELECT * FROM pedidos WHERE idPedido = '$idPedido'");
$consultaPedidos = $consultaPedidos->fetch(PDO::FETCH_ASSOC);

$status_pedido = isset($consultaPedidos['status_pedido']) ? $consultaPedidos['status_pedido'] : 0;

$listarPedidos = $pdo->query("SELECT * FROM pedidos WHERE idPedido = '$idPedido'");


/* PAGINAS APP */
// Pedidos
$idPedidoApp = filter_input(INPUT_GET, 'id'); //parametro da pagina de pedido
$consultaPedidos = $pdo->query("SELECT * FROM pedidos WHERE idPedido = '$idPedido'");
$consultaPedidos = $consultaPedidos->fetch(PDO::FETCH_ASSOC);
