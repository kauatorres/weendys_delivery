<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Produtos;

class UsersController extends Controller
{
    private $user;
    private $infosStore;
    private $arrayInfo;

    public function __construct()
    {
        $this->user = new Users();
        $prod = new Produtos();
        /* Quando der o IS LOGGED, e setar o UID, vai estar com o private UID salvo em PRIVATE $user */
        if (!$this->user->isLogged()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        /* Se não tiver permissão, redireciona pra página inicial */
        if (!$this->user->hasPermission('users_view')) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->arrayInfo = array(
            'user' => $this->user,
            'menuActive' => 'clientes',
            'listProducts' => $prod->getAllProducts(),
            'listCategories' => $prod->getAllCategories()
        );
    }

    public function index()
    {
        $prod = new Produtos();


        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }

        $this->loadTemplate('clientes', $this->arrayInfo);
    }

   
}
