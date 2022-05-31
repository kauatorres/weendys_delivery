<?php

namespace Controllers;

use \Core\Controller;
use Models\Configuration;
use Models\Pedidos;
use \Models\Users;
use \Models\Produtos;
use MercadoPago\SDK;
use MercadoPago\Refund;
use MercadoPago\Payment;
use MercadoPago\Subscription;

class PedidosController extends Controller
{
    private $user;
    private $infosStore;
    private $arrayInfo;

    public function __construct()
    {
        $this->user = new Users();
        $p = new Pedidos();
        /* Quando der o IS LOGGED, e setar o UID, vai estar com o private UID salvo em PRIVATE $user */
        if (!$this->user->isLogged()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        /* Se não tiver permissão, redireciona pra página inicial */
        if (!$this->user->hasPermission('products_view')) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->arrayInfo = array(
            'user' => $this->user,
            'menuActive' => 'pedidos',
            'listOrders' => $p->getAllOrder()
        );
    }
    public function index()
    {
        $pedidos = new Pedidos();
        $configuration = new Configuration();

        $this->arrayInfo['token'] = $configuration->getAccessToken();
        $this->arrayInfo['ranking'] = $pedidos->getTopSells();

        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }

        $this->loadTemplate('pedidos', $this->arrayInfo);
    }

    public function detalhes($id)
    {
        $pedidos = new Pedidos();
        $configuration = new Configuration();

        $this->arrayInfo['token'] = $configuration->getAccessToken();
        $this->arrayInfo['order'] = $pedidos->getOrder($id);



        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }

        $this->loadTemplate('pedidos_detalhes', $this->arrayInfo);
    }

    //estornar pedido com a funcao estornar do MercadoPago
    public function estornar($id)
    {
        $pedidos = new Pedidos();
        $configuration = new Configuration();

        $this->arrayInfo['token'] = $configuration->getAccessToken();

        $configuration->estornarPedido($id);

        $_SESSION['mensagem'] = 'Pedido estornado com sucesso!';
        $_SESSION['alert'] = 'success';
        $_SESSION['textHeader'] = 'Sucesso!';

        header('Location: ' . BASE_URL . 'pedidos/detalhes/' . $id);

        exit;
    }

    public function pedido_caminho($id)
    {
        $p = new Pedidos();
        $p->pedido_caminho($id);
        $_SESSION['mensagem'] = 'Motoboy saiu para entrega!';
        $_SESSION['alert'] = 'success';
        $_SESSION['textHeader'] = 'A caminho!';
        header('Location: ' . BASE_URL . 'pedidos');
        exit;
    }

    public function pedido_entregue($id)
    {
        $p = new Pedidos();
        $p->pedido_entregue($id);
        $_SESSION['mensagem'] = 'Pedido entregue!';
        $_SESSION['alert'] = 'success';
        $_SESSION['textHeader'] = 'Entregue!';
        header('Location: ' . BASE_URL . 'pedidos');
        exit;
    }
}
