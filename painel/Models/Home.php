<?php

namespace Models;

use \Core\Model;

class Home extends Model
{
    public function counterHomeWithoutFilter($table)
    {

        $array = array();

        $sql = "SELECT * FROM $table";

        $sql = $this->db->query($sql);

        return $sql->rowCount();
    }

    public function counterHomeWithFilter($table, $where, $valueWhere)
    {

        $array = array();

        $sql = "SELECT * FROM $table WHERE $where = '$valueWhere'";

        $sql = $this->db->query($sql);

        return $sql->rowCount();
    }

    public function counterSalesDay()
    {
        $array = array();
        $sql = "SELECT * FROM pedidos WHERE dataPedido >= DATE_SUB(NOW(), INTERVAL 24 HOUR) AND status_compra = 'approved'";

        $sql = $this->db->query($sql);

        return $sql->rowCount();
    }

    public function recentSales()
    {
        $array = array();
        $sql = "SELECT * FROM pedidos WHERE dataPedido >= DATE_SUB(NOW(), INTERVAL 24 HOUR) AND status_compra = 'approved' ORDER by id DESC LIMIT 10";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }
}
