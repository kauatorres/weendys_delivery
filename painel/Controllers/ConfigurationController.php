<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Configuration;

class ConfigurationController extends Controller
{
    private $user;
    private $infosStore;
    private $arrayInfo;

    public function __construct()
    {
        $this->user = new Users();
        /* Quando der o IS LOGGED, e setar o UID, vai estar com o private UID salvo em PRIVATE $user */
        if (!$this->user->isLogged()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        /* Se não tiver permissão, redireciona pra página inicial */
        if (!$this->user->hasPermission('store_config')) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->arrayInfo = array(
            'user' => $this->user,
            'infosStore' => $this->infosStore,
            'menuActive' => 'configuration'
        );
    }
    public function index()
    {
        $conf = new Configuration();
        $this->arrayInfo['info'] = $conf->getAllStore();

        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }

        $this->loadTemplate('configurar_loja', $this->arrayInfo);
    }

    public function edit()
    {
        $conf = new Configuration();
        if (!empty($_POST['nome_loja'])) {
            $nome_loja = $_POST['nome_loja'];
            $cnpj_loja = $_POST['cnpj_loja'];
            $email_loja = $_POST['email_loja'];
            $ano_footer_loja = $_POST['ano_footer_loja'];
            $tele_valor = str_replace(",", ".", $_POST['tele_valor']);
            $tempo_estimado = $_POST['tempo_estimado'];
            $public_key = $_POST['public_key'];
            $access_token = $_POST['access_token'];
            $whatsapp = $_POST['whatsapp'];

            $conf->editStore($nome_loja, $email_loja, $cnpj_loja, $ano_footer_loja, $tele_valor, $tempo_estimado, $public_key, $access_token, $whatsapp);

            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Atualizado!';
            $_SESSION['mensagem'] = 'As informações do site foram atualizadas com sucesso!';


            header('Location: ' . BASE_URL . "configuration");
        } else {
            //Observações
            $_SESSION['alert'] = 'danger';
            $_SESSION['textHeader'] = 'Erro!';
            $_SESSION['mensagem'] = 'Erro ao atualizar as informações.';

            header('Location: ' . BASE_URL . "configuration");
            exit;
        }
    }

    public function visual_identy_logo()
    {
        $conf = new Configuration();
        $logo = 'logo';
        $capa = null;
        if (!empty($_FILES[$logo]['name'])) {
            $conf->change_visual_identy($logo, $capa);
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Atualizado!';
            $_SESSION['mensagem'] = 'A logo do site foi atualizada com sucesso!';
        } else {
            $_SESSION['alert'] = 'danger';
            $_SESSION['textHeader'] = 'Erro!';
            $_SESSION['mensagem'] = 'Insira uma foto!';
        }
        header('Location: ' . BASE_URL . "configuration");
    }

    public function visual_identy_capa()
    {
        $conf = new Configuration();
        $logo = null;
        $capa = 'capa';

        if (!empty($_FILES[$capa]['name'])) {
            $conf->change_visual_identy($logo, $capa);
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Atualizado!';
            $_SESSION['mensagem'] = 'A capa do site foi atualizada com sucesso!';
        } else {
            $_SESSION['alert'] = 'danger';
            $_SESSION['textHeader'] = 'Erro!';
            $_SESSION['mensagem'] = 'Insira uma foto!';
        }

        header('Location: ' . BASE_URL . "configuration");
    }




    //contar notificacoes em json com valor count_notify e o id do pedido
    public function countNotifyJson()
    {
        $c = new Configuration();
        $count = $c->countNotification();
        $data = $c->getNotify();
        $json = array(
            'count' => $count,
            'result' => $data
        );
        echo json_encode($json);
    }

    public function aceitar($id_pedido)
    {
        $c = new Configuration();
        $c->aceitarPedido($id_pedido);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function recusar($id_pedido)
    {
        $c = new Configuration();
        $c->recusarPedido($id_pedido);
        $c->estornarPedido($id_pedido);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }


    public function pedidoModal($id)
    {
        //criar html modal bootstra
        $c = new Configuration();
        $data = $c->getPedido($id);
        $listarPedidosModal = $c->getListOrdersModal($id);
        $this->arrayInfo['data'] = $data;
        $this->arrayInfo['dataOrder'] = $listarPedidosModal;

        $this->loadView('pedido_modal', $this->arrayInfo);
    }

    public function pedidoModalImpressao($id)
    {
        //criar html modal bootstra
        $c = new Configuration();
        $data = $c->getPedido($id);
        $listarPedidosModal = $c->getListOrdersModal($id);
        $this->arrayInfo['data'] = $data;
        $this->arrayInfo['dataOrder'] = $listarPedidosModal;

        $this->loadView('pedido_modal_imprimir', $this->arrayInfo);
    }

    //estornar pedido
    public function estornar($id)
    {
        $c = new Configuration();
        $c->estornarPedido($id);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
