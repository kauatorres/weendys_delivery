<?php

namespace Models;

use \Core\Model;
use \Models\Configuration;


class Pedidos extends Model
{

    public function getAll()
    {
        $array = array();

        return $array;
    }

    //listar todos pedidos
    public function getAllOrder()
    {
        $array = array();

        $sql = "SELECT * FROM pedidos ORDER by id DESC";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    //getOrder
    public function getOrder($id)
    {
        $array = array();

        $sql = "SELECT * FROM pedidos WHERE idPedido = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    //status pedido
    public function getStatusOrder($status_pedido, $idPedido)
    {
        $status = null;
        if ($status_pedido == 1) {
            //muda status pro 2
            $status = "<a  class='btn btn-success btn-sm'>Aprovar pedido</a>";
        } else if ($status_pedido == 2) {
            //muda status pro 3
            $status = "<a href='" . BASE_URL . "pedidos/pedido_caminho/$idPedido' class='btn btn-info btn-sm'>A caminho</a>";
        } elseif ($status_pedido == 3) {
            //muda status pro 4
            $status = "<a href='" . BASE_URL . "pedidos/pedido_entregue/$idPedido' class='btn btn-success btn-sm'>Marcar como entregue</a>";
        } elseif ($status_pedido == 4) {
            $status = '<span class="badge bg-success" style="padding: 0.25rem 0.5rem;font-size: .875rem;line-height: 1.5;border-radius: 0.2rem;">Pedido entregue</span>';
        } elseif ($status_pedido == 5) {
            $status = '<span class="badge bg-danger" style="padding: 0.25rem 0.5rem;font-size: .875rem;line-height: 1.5;border-radius: 0.2rem;">Pedido recusado</span>';
        } elseif ($status_pedido == 6) {
            $status = '<span class="badge bg-danger" style="padding: 0.25rem 0.5rem;font-size: .875rem;line-height: 1.5;border-radius: 0.2rem;">Pedido estornado</span>';
        }

        return $status;
    }

    //status da compra
    public function getStatusOrderBuy($status_compra)
    {
        if ($status_compra == 'approved') {
            $status_compra = '<span class="badge bg-success">Aprovado</span>';
        } elseif ($status_compra == 'pending') {
            $status_compra = '<span class="badge bg-warning">Pendente</span>';
        } elseif ($status_compra == 'refunded') {
            $status_compra = '<span class="badge bg-danger">Estornado</span>';
        } elseif ($status_compra == 'canceled') {
            $status_compra = '<span class="badge bg-danger">Cancelado</span>';
        } elseif ($status_compra == 'rejected') {
            $status_compra = '<span class="badge bg-danger">Rejeitado</span>';
        } else {
            $status_compra = '<span class="badge bg-danger">Não definido</span>';
        }
        return $status_compra;
    }

    //top 3 vendas 
    public function getTopSells()
    {
        $array = array();

        $sql = "SELECT * FROM produtos WHERE total_vendas > 0 ORDER BY total_vendas DESC LIMIT 3";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function pedido_caminho($id)
    {
        $sql = "UPDATE pedidos SET status_pedido = 3 WHERE idPedido = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function pedido_entregue($id)
    {
        $sql = "UPDATE pedidos SET status_pedido = 4 WHERE idPedido = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}
