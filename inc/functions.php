<?php
session_start();
include("config.php");

//CONSULTA DO CLIENTE P/ SALVAR NO PEDIDO
if (isset($_SESSION['verifica'])) {
	$nomeCliente = $_SESSION['nome'];
	$sobrenomeCliente = $_SESSION['sobrenome'];
	$emailCliente = $_SESSION['email'];
	$cepCliente = $_SESSION['cep'];
	$enderecoCliente = "R. " . $_SESSION['rua'] . ", " . $_SESSION['numero'] . " - " . $_SESSION['bairro'] . " — " . $_SESSION['cidade'] . "/" . $_SESSION['estado'] . " ";
}

//Cria um novo endereço MAC ao fazer login


function buscaCliente()
{
}

/* function reembolso($idPagamento)
{
	$refund = new MercadoPago\Refund();
	$refund->payment_id = $idPagamento;
	return $refund->save();
}
 */

if (isset($_GET['getList'])) {
	header('Content-Type: application/json;charset=utf-8');
	$idProd = $_GET['tam'];
	$jsonArray = array();
	$consultaTamanhos = $pdo->query("SELECT * FROM tamanhos WHERE id_produto = '$idProd'");
	$jsonArray = $consultaTamanhos->fetchAll();
	echo json_encode($jsonArray);
	exit;
}



function procurarPedido($idPedido)
{
	$url = "https://api.mercadopago.com/v1/payments/" . $idPedido;

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$headers = array(
		"Authorization: Bearer " . $GLOBALS['KEY_MPP_ACCESSTOKEN']
	);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	//for debug only!
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$resp = curl_exec($curl);
	$json = json_decode($resp);

	return $json;
}

function verificaCidade($endereco)
{
	if (strpos($endereco, 'Alvorada') == false) {
		echo 'disabled';
	}
}

if (isset($_GET['getValorTele'])) {
	exit(json_encode($valorTele));
}

if (isset($_GET['enviarEndereco'])) {
	$CEP = $_GET['enviarEndereco'];

	$url =  "https://viacep.com.br/ws/" . $CEP . "/json/";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	if ($e = curl_error($curl)) {
		echo $e;
	} else {
		if (strtolower($_POST['email']) == "kaua.3010@gmail.com") {
			echo ('<h3 class="mb-3" style="color:#ff870c;margin-block-start: 0em;">Por favor, escolha outro e-mail. Este e-mail pertence ao dono do site.</h3>');
		} else {
			$decodedData = json_decode($response);
			$_SESSION['verifica'] = "verifica";
			$_SESSION['nome'] = $_POST['nome'];
			$_SESSION['sobrenome'] = $_POST['sobrenome'];
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['cep'] = $_POST['cep'];
			$_SESSION['rua'] = $decodedData->logradouro;
			$_SESSION['numero'] = $_POST['numero'];
			$_SESSION['bairro'] = $decodedData->bairro;
			$_SESSION['cidade'] = $decodedData->localidade;
			$_SESSION['estado'] = $decodedData->uf;

			echo ('<h3 class="mb-3" style="color:#129b36;margin-block-start: 0em;">Carregando...</h3>');
			echo ("<meta http-equiv='refresh' content='1'>");
		}
	}
	curl_close($curl);
}

//PEDIDOS
//ATUALIZAR STATUS AUTOMATICAMENTE
if (isset($_GET['atualizarStatusPedido'])) {
	$porcent = 0;
	if ($status_pedido == 1) {
		echo '<div class="pt-1">
                <p><i class="fa fa-spinner fa-spin" style="font-size:16px;"></i> <span class=""> Aguardando confirmação do estabelecimento...</span></p>
            </div>';
		$porcent = 0;
		$color = 'danger';
	} elseif ($status_pedido == 2) {
		echo '<div class="pt-1">
                <p><i class="fa fa-spinner fa-spin" style="font-size:16px;"></i> O pedido <b>#' . $consultaPedidos['idPedido'] . '</b> está sendo <b> preparado </b></p>
            </div>';
		$porcent = 45;
		$color = 'info';
	} elseif ($status_pedido == 3) {
		echo '<div class="pt-1">
                <p><b>Seu pedido saiu para entrega</b></p>
            </div>';
		$porcent = 75;
		$color = 'warning';
	} elseif ($status_pedido == 4) {
		echo '<div class="pt-1">
                <p class="text-success" style="font-weight:bold;font-family:SFBold;"><i class="fa fa-check-circle"></i> Pedido entregue às ' . date('H:i', strtotime($consultaPedidos['dataEntregue'])) . '</p>
            </div>';
		$porcent = 100;
		$color = 'success';
	} elseif ($status_pedido == 5) {
		echo '<div class="pt-1">
                <p class="text-danger" style="font-weight:bold;font-family:SFBold;"><i class="fa fa-close"></i> Pedido recusado!</p>
            </div>';
		$porcent = 100;
		$color = 'danger';
	}
	echo '<p><div class="progress">
			<div class="progress-bar progress-bar-striped progress-bar-animated bg-' . $color . ' pro"  role="progressbar" aria-valuenow="' . $porcent . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $porcent . '%"><span class="title">' . $porcent . '%</span></div>
		</div><p>';
	exit();
}
