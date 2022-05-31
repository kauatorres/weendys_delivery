<?php
include("config.php");

$consultaJson = $pdo->query("SELECT * FROM produtos WHERE idLoja = '$idLoja'");

$jsonArr = array();


foreach($consultaJson as $json){
	$id = $json['idProduto'];
	$produto = $json['produto'];
	$descricao = $json['descricao_produto'];
	$img = $json['img'];
	$statusDisponibilidade = $json['statusDisponibilidade'];

	$pre1 = $json['preco_01'];
	$pre2 = $json['preco_02'];
	$pre3 = $json['preco_03'];

	$tam1 = $json['tamanho_01'];
	$tam2 = $json['tamanho_02'];
	$tam3 = $json['tamanho_03'];
	
    $jsonArr[] = array('id' => $id, 'name' => $produto, 'img' => $img, 'price' => [$pre1,$pre2,$pre3], 'sizes' => [$tam1,$tam2,$tam3], 'description' => $descricao, 'status' => $statusDisponibilidade );
}

echo json_encode($jsonArr);