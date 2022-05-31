<?php
require 'environment.php';

$config = array();
define("NOME_SITE", "Weendy's Delivery");
define("VERSAO", "1.0");

if (ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/pixMP/painel/");
	$config['dbname'] = 'delivery';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
} else {
	define("BASE_URL", "http://localhost/pixMP/painel/");
	$config['dbname'] = 'delivery';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = '';
}

global $db;
try {
	$db = new PDO("mysql:dbname=" . $config['dbname'] . ";host=" . $config['host'], $config['dbuser'], $config['dbpass']);
} catch (PDOException $e) {
	echo "ERRO: " . $e->getMessage();
	exit;
}
