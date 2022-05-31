<?php

namespace Models;

use \Core\Model;
use \Models\Permissions;


class Users extends Model
{
    private $uid;
    private $permissions;
    private $acesso;
    private $username;
    private $id_permissao;
    private $data_registro;

    public function isLogged()
    {
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $sql = "SELECT * FROM clientes WHERE token = :token";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $p = new Permissions();
                $data = $sql->fetch();
                $this->uid = $data['id'];
                $this->acesso = $data['acesso'];
                $this->username = $data['nome'] . " " . $data['sobrenome'];
                $this->id_permissao = $data['id_permission'];
                $this->data_registro = $data['data_registro'];
                $this->permissions = $p->getPermissions($data['id_permission']);
                return true;
            }
        }

        return false;
    }

    public function getUserInfos($info)
    {
        return $this->$info;
    }

    public function hasPermission($permission_slug)
    {
        if (in_array($permission_slug, $this->permissions)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateLogin($cpf, $senha)
    {
        $sql = "SELECT * FROM clientes WHERE cpf = :cpf AND admin = 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':cpf', $cpf);
        $sql->execute();


        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            if (password_verify($senha, $data['senha'])) {
                $token = md5(time() . rand(0, 99999) . $data['id']);

                $sql = "UPDATE clientes SET token = :token WHERE id = :id";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(':token', $token);
                $sql->bindValue(':id', $data['id']);
                $sql->execute();
                $_SESSION['token'] = $token;
                return true;
            }
        }

        return false;
    }

    public function getId()
    {
        return $this->uid;
    }

    public function countNotification()
    {
        $status = 0;
        //0 = Não lido
        //1 = Lido/aceito
        //2 = Lido/rejeitado
        $sql = "SELECT * FROM notifica_pedidos WHERE status_notificacao = :status";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':status', $status);
        $sql->execute();

        return $sql->rowCount();
    }

    //
    

    public function getNotification()
    {
        $status = 0; //0 = Não lido
        $sql = "SELECT * FROM notifica_pedidos WHERE status_notificacao = '$status'";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }




    /* public function getAllTickets()
    {
        $sql = "SELECT * FROM tickets";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function criarTickets($id_pedido, $id_cliente, $id_produto, $id_usuario, $id_status, $id_tipo, $id_prioridade, $id_categoria)
    {
        $sql = "INSERT INTO tickets (id_pedido, id_cliente, id_produto, id_usuario, id_status, id_tipo, id_prioridade, id_categoria) VALUES (:id_pedido, :id_cliente, :id_produto, :id_usuario, :id_status, :id_tipo, :id_prioridade, :id_categoria)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_pedido', $id_pedido);
        $sql->bindValue(':id_cliente', $id_cliente);
        $sql->bindValue(':id_produto', $id_produto);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->bindValue(':id_status', $id_status);
        $sql->bindValue(':id_tipo', $id_tipo);
        $sql->bindValue(':id_prioridade', $id_prioridade);
        $sql->bindValue(':id_categoria', $id_categoria);
        $sql->execute();
    }

    public function getTicketsFromUser($id_usuario)
    {
        $sql = "SELECT * FROM tickets WHERE id_usuario = :id_usuario";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function replyTickets($id_ticket, $id_usuario, $resposta)
    {
        $sql = "INSERT INTO respostas_tickets (id_ticket, id_usuario, resposta) VALUES (:id_ticket, :id_usuario, :resposta)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_ticket', $id_ticket);
        $sql->bindValue(':id_usuario', $id_usuario);
        $sql->bindValue(':resposta', $resposta);
        $sql->execute();
    } */
}
