<?php
include("inc/config.php");
include("inc/functions.php");

$url = explode('/', $_GET['pages']);

if ($url[0] != 'inicio') {
	if (!isset($_COOKIE['logado'])) { // verifica se o cookie logado está definido
		header('location: inicio');
	}
}

?>
<!DOCTYPE html>

<html id="display">

<head>
	<meta charset="utf-8" />
	<title><?= $titulo; ?> </title>

	<!-- META -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="author" content="Kauã Torres - @kauatorress" />

	<!-- SCRIPTS -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="src/js/functions.js?v=9"></script>

	<!-- CSS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="src/css/icons.css?v=<?= filesize('src/css/icons.css'); ?>">
	<?= ($url[0] == "inicio") ? '<link rel="stylesheet" href="src/css/style.css?v=' . rand(1, 9999999) . '" />' : ""; ?>
	<link href="src/css/style_.css?v=<?= filesize('src/css/style_.css') + rand(1, 9999999); ?>" rel="stylesheet" />
	<link href="src/css/all-icons.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">





</head>

<body class="">

	<?php
	if (file_exists('pages/' . $url[0] . '.php')) {
		if ($_GET) {
			require_once 'pages/' . $url[0] . '.php';
		}
	} else {
		echo '<div class="alert alert-danger">Página não encontrada.</div>';
	}
	include('inc/loginAndRegister.php');

	?>



	<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
	<script src="src/js/javascript.js?v=<?= rand(1, 9999999); ?>"></script>
	<script type="text/javascript" src="src/js/script.js?v=<?= rand(1, 9999999); ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-input-spinner@3.1.10/src/bootstrap-input-spinner.min.js"></script>


</body>

</html>