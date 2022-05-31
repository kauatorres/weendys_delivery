<?php

namespace Models;

use \Core\Model;

class Permissions extends Model
{

    /* ======================================= GROUPS / PERMISSIONS =======================================*/

    public function getPermissionGroupName($id_permission)
    {
        $sql = "SELECT name FROM permission_groups WHERE id = :id_permission";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_permission', $id_permission);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            return $data['name'];
        } else {
            return null;
        }
    }

    public function editNameGroup($new_name, $id)
    {
        if ($id != 1) { /* Se id não for igual a 1 (super adm), não deixa edita o nome */
            $sql = "UPDATE permission_groups SET name = :new_name WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':new_name', $new_name);
            $sql->bindValue(':id', $id);
            $sql->execute();
        }
    }

    public function clearLinksGroup($id)
    {
        $sql = "DELETE FROM permission_links WHERE id_permission_group = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function getPermissions($id_permissions)
    {
        $array = array();

        $sql = "SELECT id_permission_item FROM permission_links WHERE id_permission_group = :id_permissions";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_permissions', $id_permissions);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            $ids = array();
            foreach ($data as $dataItem) {
                $ids[] = $dataItem['id_permission_item'];
            }

            $sql = "SELECT slug FROM permission_itens WHERE id IN (" . implode(',', $ids) . ")";
            $sql = $this->db->query($sql);

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll();

                foreach ($data as $dataItem) {
                    $array[] = $dataItem['slug'];
                }
            }
        }

        return $array; /* slugs da tabela permissions_itens */
    }

    public function getAllGroups()
    {
        $array = array();

        $sql = "SELECT permission_groups.*, (SELECT count(clientes.id) from clientes where clientes.id_permission = permission_groups.id) as total_users FROM permission_groups";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function addGroup($name)
    {
        $sql = "INSERT INTO permission_groups (name) VALUES (:name)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->execute();

        return $this->db->lastInsertId();
    }

    public function itemToGroup($id_item, $id_group)
    {
        $sql = "INSERT INTO permission_links (id_permission_item, id_permission_group) VALUES (:id_item, :id_group)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_item', $id_item);
        $sql->bindValue(':id_group', $id_group);
        $sql->execute();
    }

    public function DeleteGroup($id_group)
    {
        //Verificação para nao excluir grupo que tem usuário cadastrado nele
        $sql = "SELECT id FROM clientes WHERE id_permission = :id_group";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_group', $id_group);
        $sql->execute();

        if ($sql->rowCount() === 0) { //Se for igual a ID 1 (super administrador), não deixa edita.
            $sql = "DELETE FROM permission_links WHERE id_permission_group = :id_group";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id_group', $id_group);
            $sql->execute();

            $sql = "DELETE FROM permission_groups WHERE id = :id_group";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id_group', $id_group);
            $sql->execute();
        }
    }
    /* ======================================= ITENS =======================================*/
    public function getAllItens()
    {
        $array = array();

        $sql = "SELECT * FROM permission_itens";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function editItemName($new_name, $id)
    {
        $sql = "UPDATE permission_itens SET name = :new_name WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':new_name', $new_name);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function addNewItem($name, $slug)
    {
        /* OBS; Fazer aqui: se o noome já exitir, adicionar um ($nome+ordem numerica) */
        $sql = "SELECT * FROM permission_itens WHERE name = '$name'";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() === 0) {
            $sql = "INSERT INTO permission_itens (name, slug) VALUES (:name, :slug)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':name', $name);
            $sql->bindValue(':slug', $slug);
            $sql->execute();
        }

        return $this->db->lastInsertId();
    }

    public function delete_item_model($id)
    {
        if ($id != 1) { //Se for igual a ID 1 (ver permissoes), não deixa deletar.
            $sql = "DELETE FROM permission_itens WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();

            $sql = "DELETE FROM permission_links WHERE id_permission_item = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id', $id);
            $sql->execute();
        }
    }

    public function getItemName($id_item)
    {
        $sql = "SELECT name FROM permission_itens WHERE id = :id_item";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id_item', $id_item);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            return $data['name'];
        } else {
            return null;
        }
    }
}
