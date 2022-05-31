<?php

namespace Controllers;

use \Core\Controller;
use Models\Configuration;
use \Models\Home;
use \Models\Users;

class HomeController extends Controller
{
	private $user;
	private $conf;
	private $arrayInfo;

	public function __construct()
	{
		$this->user = new Users();
		$c = new Home(); // $c->counterHome($table, $where, $valueWhere)

		/* Quando der o IS LOGGED, e setar o UID, vai estar com o private UID salvo em PRIVATE $user */
		if (!$this->user->isLogged()) {
			header('Location: ' . BASE_URL . 'login');
			exit;
		}

		$this->arrayInfo = array(
			'user' => $this->user,
			'menuActive' => 'home'
		);
	}
	public function index()
	{
		$c = new Home();
		$this->arrayInfo['counterSalesDay'] = $c->counterSalesDay();
		$this->arrayInfo['counterSales'] = $c->counterHomeWithFilter("pedidos", 'status_compra', 'approved');
		$this->arrayInfo['counterProducts'] = $c->counterHomeWithoutFilter("produtos");
		$this->arrayInfo['counterUsers'] = $c->counterHomeWithoutFilter("clientes");
		$this->arrayInfo['getRecentSales'] = $c->recentSales();
		$this->loadTemplate('home', $this->arrayInfo);
	}
}
