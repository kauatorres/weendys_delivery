<?php

namespace Models;

use \Core\Model;
use \Models\Configuration;

class Produtos extends Model
{


    public function getAllProducts()
    {
        $array = array();

        $sql = "SELECT * FROM produtos AS p JOIN produto_categoria AS c ON p.categoria = c.id_categoria ORDER by idProduto DESC";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getAllCategories()
    {
        $array = array();

        $sql = "SELECT produto_categoria.*, (SELECT count(produtos.idProduto) from produtos where produtos.categoria = produto_categoria.id_categoria) as total_active FROM produto_categoria";
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getCategoryName($id)
    {
        $sql = "SELECT * FROM produto_categoria WHERE id_categoria = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            return $data['nome_categoria'];
        } else {
            return null;
        }
    }

    //Informações do produto
    public function getProductInfo($id)
    {
        $array = array();

        $sql = "SELECT * FROM produtos AS p JOIN produto_categoria AS c ON p.categoria = c.id_categoria WHERE  p.idProduto = '$id'";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }
    //pegar tamanhos do produto e listar
    public function getSizeProduct($id)
    {
        $array = array();

        $sql = "SELECT * FROM tamanhos WHERE id_produto = '$id'";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }



    public function deleteProduct($id)
    {
        $sql = "DELETE FROM produtos WHERE idProduto = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        //Deletar tamanhos do produto
        $sql = "DELETE FROM tamanhos WHERE id_produto = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function deleteSize($id)
    {
        //Deletar tamanho do produto
        $sql = "DELETE FROM tamanhos WHERE id_tamanho = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    //Adicionar novo produto
    public function add_new_product($product_name, $product_size, $product_price, $description, $category, $disponibility, $imagem)
    {
        $upload = new Configuration();
        //Extensoes que sao aceitas
        $allowed_images = array(
            'image/jpeg',
            'image/png',
            'image/jpg'
        );
        $imagem_input = 'product_photo';
        $target_file = '../src/img/products/' . $imagem;
        $folder_file = "src/img/products/" . $imagem;
        $sql = "INSERT INTO `produtos` (`idProduto`, `idLoja`, `produto`, `categoria`, `descricao_produto`,`total_vendas`, `img`, `statusDisponibilidade`) VALUES (NULL, :idLoja, :nomeProduto, :categoria, :descricao,'0', :imagem, :disponibilidade)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idLoja', 1);
        $sql->bindValue(':nomeProduto', $product_name);
        $sql->bindValue(':disponibilidade', $disponibility);
        $sql->bindValue(':categoria', $category);
        $sql->bindValue(':descricao', $description);
        $sql->bindValue(':imagem', $folder_file);

        $sql->execute();
        $idProduto = $this->db->lastInsertId();

        for ($i = 0; $i < count($product_size); $i++) {
            if (!empty($product_size[$i]) && !empty($product_price[$i])) {
                $sql = "INSERT INTO `tamanhos` (`tamanho`, `id_produto`, `valor_produto`) VALUES (:tamanho, :id_produto, :valor_produto)";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(':tamanho', $product_size[$i]);
                $sql->bindValue(':id_produto', $idProduto);
                $sql->bindValue(':valor_produto', $product_price[$i]);
                $sql->execute();
            }
        }


        $upload->upload($imagem_input, $allowed_images, $target_file);
    }

    //Editar produto
    public function product_edit($id, $id_tamanho, $product_name, $product_size, $product_price, $product_size_add, $product_price_add, $description, $category, $disponibility, $imagem)
    {
        $upload = new Configuration();

        $sql = "UPDATE
                `produtos`
                SET
                    `idProduto` =  :idProduto,
                    `idLoja` = :idLoja,
                    `produto` = :nomeProduto,
                    `categoria` = :categoria,
                    `descricao_produto` = :descricao,
                    `statusDisponibilidade` = :disponibilidade
                WHERE idProduto = :idProduto";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':idProduto', $id);
        $sql->bindValue(':idLoja', 1);
        $sql->bindValue(':nomeProduto', $product_name);
        $sql->bindValue(':disponibilidade', $disponibility);
        $sql->bindValue(':categoria', $category);
        $sql->bindValue(':descricao', $description);
        $sql->execute();

        for ($i = 0; $i < count($product_size); $i++) {
            if (!empty($product_size[$i]) && !empty($product_price[$i])) {
                $sql = "UPDATE `tamanhos` SET `tamanho` = :tamanho, valor_produto = :valor_produto WHERE id_tamanho = :id_tamanho";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(':tamanho', $product_size[$i]);
                $sql->bindValue(':valor_produto', $product_price[$i]);
                $sql->bindValue(':id_tamanho', $id_tamanho[$i]);
                $sql->execute();
            }
        }

        if (!empty($product_size_add) && !empty($product_price_add)) {
            for ($i = 0; $i < count($product_size_add); $i++) {
                if (!empty($product_size_add[$i]) && !empty($product_price_add[$i])) {
                    $sql = "INSERT INTO `tamanhos` (`tamanho`, `id_produto`, `valor_produto`) VALUES (:tamanho, :id_produto, :valor_produto)";
                    $sql = $this->db->prepare($sql);
                    $sql->bindValue(':id_produto', $id);
                    $sql->bindValue(':tamanho', $product_size_add[$i]);
                    $sql->bindValue(':valor_produto', $product_price_add[$i]);
                    $sql->execute();
                }
            }
        }

        //Caso estiver escolhida uma nova foto, atualiza no banco e importa a foto
        if (!empty($imagem)) {
            //Extensoes que sao aceitas
            $allowed_images = array(
                'image/jpeg',
                'image/png',
                'image/jpg'
            );
            $imagem_input = 'product_photo';
            $target_file = '../src/img/products/' . $imagem;
            $folder_file = "src/img/products/" . $imagem;

            $sql = "UPDATE `produtos` SET `img` = :img WHERE idProduto = :idProduto";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':idProduto', $id);
            $sql->bindValue(':img', $folder_file);
            $sql->execute();

            $upload->upload($imagem_input, $allowed_images, $target_file);
        }
    }

    /* CATEGORIAS */
    public function edit_category($id, $new_name)
    {
        if (!empty($id)) {
            $sql = "UPDATE `produto_categoria` SET `nome_categoria` = :new_name WHERE id_categoria = :id_categoria";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id_categoria', $id);
            $sql->bindValue(':new_name', $new_name);
            $sql->execute();
        }
    }

    public function add_category($category_name)
    {
        for ($i = 0; $i < count($category_name); $i++) {
            if (!empty($category_name)) {
                $sql = "INSERT INTO `produto_categoria` (`nome_categoria`) VALUES (:category_name)";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(':category_name', $category_name[$i]);
                $sql->execute();
            }
        }
    }
    public function delete_category($id)
    {
        if (!empty($id)) {
            $sql = "DELETE FROM `produto_categoria` WHERE id_categoria = :id_categoria";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':id_categoria', $id);
            $sql->execute();
        }
    }

}
