<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Produtos;

class ProdutosController extends Controller
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
        if (!$this->user->hasPermission('products_view')) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->arrayInfo = array(
            'user' => $this->user,
            'menuActive' => 'produtos',
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

        $this->loadTemplate('produtos', $this->arrayInfo);
    }
    /* CATÁLOGO */
    public function catalogo()
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
        $this->loadTemplate('produtos_catalogo', $this->arrayInfo);
    }

    public function product_del($id)
    {
        $prod = new Produtos();

        //Function deletar
        $prod->deleteProduct($id);

        //Mensagem retorno de sucesso.
        $_SESSION['alert'] = 'success';
        $_SESSION['textHeader'] = 'Sucesso!';
        $_SESSION['mensagem'] = 'Produto deletado com sucesso!';

        header('Location: ' . BASE_URL . "produtos/catalogo");
        exit;
    }

    /* PRODUTOS */
    public function adicionar()
    {
        $prod = new Produtos();
        //Mensagens de retorno em itens
        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }
        $this->loadTemplate('produtos_add', $this->arrayInfo);
    }

    public function action_add()
    {
        $prod = new Produtos();
        if (!empty($_POST['product_name'])) {
            $product_name = $_POST['product_name'];
            $product_size = $_POST['product_size'];
            $product_price = str_replace(",", ".", $_POST['product_price']);
            $description = $_POST['description'];
            $disponibility = (isset($_POST['disponibility'])) ? $_POST['disponibility'] : 0;
            $category = $_POST['category'];
            if (!empty($_FILES['product_photo']['name'])) {
                $imagem = $_FILES['product_photo']['name'];
            } else {
                $imagem = 'no_photo.png';
            }


            //Mensagem de sucesso
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Produto <b>' . $product_name . '</b> adicionado com sucesso!';
            $prod->add_new_product($product_name, $product_size, $product_price, $description, $category, $disponibility, $imagem);
            header('Location: ' . BASE_URL . "produtos/adicionar");
        } else {
            header('Location: ' . BASE_URL . "produtos/adicionar");
        }
    }

    //Editar produto
    public function product_edit($id)
    {
        $prod = new Produtos();
        if (!empty($id)) {
            $this->arrayInfo['getInfoProduct'] = $prod->getProductInfo($id);
            $this->arrayInfo['getSizeProduct'] = $prod->getSizeProduct($id);
            if (isset($_SESSION['mensagem'])) {
                $this->arrayInfo['msg'] = $_SESSION['mensagem'];
                $this->arrayInfo['alert'] = $_SESSION['alert'];
                $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
                $_SESSION['mensagem'] = '';
                $_SESSION['alert'] = '';
                $_SESSION['textHeader'] = '';
            }
            $this->loadTemplate('produtos_editar', $this->arrayInfo);
        } else {
            header('Location: ' . BASE_URL . "produtos/catalogo");
        }
    }

    public function product_action_edit($id)
    {
        $prod = new Produtos();
        if (!empty($_POST['product_name'])) {
            $product_name = $_POST['product_name'];

            $id_tamanho = $_POST['id_tamanho'];
            $product_size = $_POST['product_size'];
            $product_price = str_replace(",", ".", $_POST['product_price']);


            $product_size_add = $_POST['product_size_add'];
            $product_price_add = str_replace(",", ".", $_POST['product_price_add']);

            $description = $_POST['description'];
            $disponibility = (isset($_POST['disponibility'])) ? $_POST['disponibility'] : 0;
            $category = $_POST['category'];
            $imagem = $_FILES['product_photo']['name'];


            //Mensagem de sucesso
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Produto <b>' . $product_name . '</b> editado com sucesso!';
            $prod->product_edit($id, $id_tamanho, $product_name, $product_size, $product_price, $product_size_add, $product_price_add, $description, $category, $disponibility, $imagem);
            header('Location: ' . BASE_URL . "produtos/product_edit/" . $id);
        } else {
            header('Location: ' . BASE_URL . "produtos/catalogo");
        }
    }

    public function size_remove($id)
    {
        $prod = new Produtos();

        //Function deletar
        $prod->deleteSize($id);

        //Mensagem retorno de sucesso.
        $_SESSION['alert'] = 'success';
        $_SESSION['textHeader'] = 'Sucesso!';
        $_SESSION['mensagem'] = 'Tamanho deletado com sucesso!';

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    /* CATEGORIAS */
    public function categorias()
    {
        $prod = new Produtos();
        $this->arrayInfo['listCategories'] = $prod->getAllCategories();
        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }
        $this->loadTemplate('produtos_categoria', $this->arrayInfo);
    }

    public function edit_category($id)
    {
        $prod = new Produtos();
        if (!empty($id)) {
            $this->arrayInfo['categorie_id'] = $id;
            $this->arrayInfo['categoryName'] = $prod->getCategoryName($id);
            if (isset($_SESSION['mensagem'])) {
                $this->arrayInfo['msg'] = $_SESSION['mensagem'];
                $this->arrayInfo['alert'] = $_SESSION['alert'];
                $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
                $_SESSION['mensagem'] = '';
                $_SESSION['alert'] = '';
                $_SESSION['textHeader'] = '';
            }
        } else {
            header('location: ' . BASE_URL . 'produtos/categorias');
        }

        $this->loadTemplate('produtos_categoria_edit', $this->arrayInfo);
    }

    public function edit_category_action($id)
    {
        $prod = new Produtos();
        $new_name = $_POST['new_name'];
        if (!empty($id) && !empty($new_name)) {

            $prod->edit_category($id, $new_name);

            //Mensagem retorno de sucesso.
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Categoria editada com sucesso!';

            header('location: ' . BASE_URL . 'produtos/edit_category/' . $id);
        } else {
            header('location: ' . BASE_URL . 'produtos/categorias');
        }
    }

    public function category_add()
    {
        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }
        $this->loadTemplate('produtos_categoria_add', $this->arrayInfo);
    }

    public function category_add_action()
    {
        $prod = new Produtos();
        if (!empty($_POST['category_name'])) {
            $category_name = $_POST['category_name'];

            //Mensagem de sucesso
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Categoria adicionada com sucesso!';

            $prod->add_category($category_name);
            header('Location: ' . BASE_URL . "produtos/category_add");
        } else {
            header('Location: ' . BASE_URL . "produtos/category_add");
        }
    }

    public function delete_category($id)
    {
        $prod = new Produtos();
        if (!empty($id)) {
            $prod->delete_category($id);
            //Mensagem retorno de sucesso.
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Categoria deletada com sucesso!';
        }
        header('Location: ' . BASE_URL . 'produtos/categorias');
    }

    
}
