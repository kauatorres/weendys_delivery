<?php

namespace Models;

use \Core\Model;
//import mercado pago
use MercadoPago\SDK;
use MercadoPago\Refund;
use MercadoPago\Payment;
use MercadoPago\Payer;
use MercadoPago\Item;
use MercadoPago\Subscription;

class Configuration extends Model
{
    public function getAllStore()
    {
        $sql = "SELECT * FROM configs";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            return $data;
        }
    }


    public function editStore($nome_loja, $email_loja, $cnpj_loja, $ano_footer_loja, $tele_valor, $tempo_estimado, $public_key, $access_token, $whatsapp)
    {
        $sql = "UPDATE configs SET titulo = :titulo, cnpj  = :cnpj,
         emailLoja = :email_loja, anoInicioFooter = :ano,
         valorTele = :tele_valor , tempoEstimado = :tempo_estimado, 
         chavePublicKey = :public_key, chaveAccessToken = :access_token, 
         contatoWhats = :whats  WHERE id  = 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':titulo', $nome_loja);
        $sql->bindValue(':email_loja', $email_loja);
        $sql->bindValue(':cnpj', $cnpj_loja);
        $sql->bindValue(':ano', $ano_footer_loja);
        $sql->bindValue(':tempo_estimado', $tempo_estimado);
        $sql->bindValue(':tele_valor', $tele_valor);
        $sql->bindValue(':cnpj', $cnpj_loja);
        $sql->bindValue(':public_key', $public_key);
        $sql->bindValue(':access_token', $access_token);
        $sql->bindValue(':whats', $whatsapp);
        $sql->execute();
    }

    public function upload($id, $allowed_images, $target_file)
    {
        if (isset($_FILES[$id]['name'])) {
            $tmp_name = $_FILES[$id]['tmp_name'];
            $type = $_FILES[$id]['type'];
            if (in_array($type, $allowed_images)) {
                if (move_uploaded_file($_FILES[$id]['tmp_name'], $target_file)) {
                    //OK
                } else {
                    //ERRO 
                    exit("Erro. Contate o programador.");
                }
            }
        }
    }

    public function change_visual_identy($logo, $capa)
    {
        //Extensoes que sao aceitas
        $allowed_images = array(
            'image/jpeg',
            'image/png',
            'image/jpg'
        );

        if ($logo == 'logo') {
            $target_file = "../src/img/logo.png";
            $this->upload($logo, $allowed_images, $target_file);
        } elseif ($capa == 'capa') {
            $target_file = "../src/img/header.png";
            $this->upload($capa, $allowed_images, $target_file);
        }
    }


    //Notificacoes
    public function countNotification()
    {
        $sql = "SELECT * FROM notifica_pedidos WHERE status_notificacao = 0";
        $sql = $this->db->query($sql);

        return $sql->rowCount();
    }

    public function getNotify()
    {
        $sql = "SELECT * FROM notifica_pedidos WHERE status_notificacao = 0";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return $array;
        }
    }

    //listar notificacoes
    public function listNotify()
    {
        $sql = "SELECT * FROM notifica_pedidos WHERE status_notificacao = 0";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return $array;
        }
    }


    //juntar tabela pedido e cliente para pegar os dados do pedido e cliente
    public function getPedido($id)
    {
        $sql = "SELECT pedidos.*, clientes.* FROM pedidos INNER JOIN clientes ON pedidos.cpfCliente = clientes.cpf WHERE pedidos.idPedido = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            return $data;
        }
    }

    public function getListOrdersModal($id)
    {
        $array = array();
        $sql = "SELECT * FROM pedidos WHERE idPedido = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
            return $array;
        }
    }

    public function aceitarPedido($id_pedido)
    {
        $sql = "UPDATE notifica_pedidos SET status_notificacao = 1 WHERE id_pedido = :id_pedido";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_pedido', $id_pedido);
        $sql->execute();

        $sql = "UPDATE pedidos SET status_pedido = 2 WHERE idPedido = :id_pedido";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_pedido', $id_pedido);
        $sql->execute();
    }

    public function recusarPedido($id_pedido)
    {
        $sql = "UPDATE notifica_pedidos SET status_notificacao = 2 WHERE id_pedido = :id_pedido";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_pedido', $id_pedido);
        $sql->execute();

        $sql = "UPDATE pedidos SET status_pedido = 5 WHERE idPedido = :id_pedido";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_pedido', $id_pedido);
        $sql->execute();
    }
    public function getAccessToken()
    {
        $sql = "SELECT * FROM configs";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            return $data['chaveAccessToken'];
        }
    }

    //estornar
    public function estornarPedido($id_pedido)
    {
        $mp = new SDK();
        $mp->setAccessToken($this->getAccessToken());

        //atualizar status_pedido em produtos para estornado
        $sql = "UPDATE pedidos SET status_pedido = 6 WHERE idPedido = :id_pedido";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_pedido', $id_pedido);
        $sql->execute();

        $refund = new Refund();
        $refund->payment_id = $id_pedido;
        return $refund->save();
    }

    public function pesquisarPedido($id_pedido)
    {
        $mp = new SDK();
        $mp->setAccessToken($this->getAccessToken());

        $payment = new Payment();
        $payment->id = $id_pedido;
        $search = Payment::find_by_id($payment->id);
        return $search->status;
    }
}
