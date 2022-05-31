<?php

namespace Controllers;

use \Core\Controller;
use Models\Permissions;
use \Models\Users;

class PermissionsController extends Controller
{
    private $user;
    private $arrayInfo;
    public function __construct()
    {
        $this->user = new Users();
        if (!$this->user->isLogged()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        /* Se não tiver permissão, redireciona pra página inicial */
        if (!$this->user->hasPermission('permissions_view')) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->arrayInfo = array(
            'user' => $this->user,
            'menuActive' => 'permissions'
        );
    }


    public function index()
    {
        $p = new Permissions();
        $this->arrayInfo['list'] = $p->getAllGroups();

        //Mensagens de retorno em permissoes
        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }

        $this->loadTemplate('permissions', $this->arrayInfo);
    }

    //Listar todos os itens de permissão    
    public function itens()
    {
        $p = new Permissions();
        $this->arrayInfo['list'] = $p->getAllItens();

        //Mensagens de retorno em itens
        if (isset($_SESSION['mensagem'])) {
            $this->arrayInfo['msg'] = $_SESSION['mensagem'];
            $this->arrayInfo['alert'] = $_SESSION['alert'];
            $this->arrayInfo['textHeader'] = $_SESSION['textHeader'];
            $_SESSION['mensagem'] = '';
            $_SESSION['alert'] = '';
            $_SESSION['textHeader'] = '';
        }

        $this->loadTemplate('permissions_itens', $this->arrayInfo);
    }

    // Adicionar Permissões
    public function adicionar()
    {
        $this->arrayInfo['errorItens'] = array();
        $p = new Permissions();

        $this->arrayInfo['permission_itens'] = $p->getAllItens();
        $this->arrayInfo = array(
            'menuActive' => 'adicionar'
        );

        //se tiver vazio o campo, redireciona pra pagina com um alerta
        if (isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
            $this->arrayInfo['errorItens'] = $_SESSION['formError'];
            unset($_SESSION['formError']);
        }

        $this->loadTemplate('permissions_add', $this->arrayInfo);
    }

    public function add_action()
    {
        $p = new Permissions();
        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $itens = $_POST['itens'];
            $id = $p->addGroup($name);

            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Permissão adicionada com sucesso!';


            if (isset($itens) && count($itens) > 0) {
                foreach ($itens as $item) {
                    $p->itemToGroup($item, $id);
                }
            }
            header('Location: ' . BASE_URL . "permissions");
        } else {
            //Observações
            $_SESSION['formError']  = array('name');
            header('Location: ' . BASE_URL . "permissions/adicionar");
            exit;
        }
    }
    //Editar Permissões
    public function edit($id)
    {
        if (!empty($id)) {
            $this->arrayInfo['errorItens'] = array();

            $p = new Permissions();

            $this->arrayInfo['permission_itens'] = $p->getAllItens();
            $this->arrayInfo['permission_id'] = $id;
            $this->arrayInfo['permission_group_name'] = $p->getPermissionGroupName($id);
            $this->arrayInfo['permission_group_slugs'] = $p->getPermissions($id);

            //se tiver vazio o campo, redireciona pra pagina com um alerta
            if (isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
                $this->arrayInfo['errorItens'] = $_SESSION['formError'];
                unset($_SESSION['formError']);
            }

            $this->loadTemplate('permissions_edit', $this->arrayInfo);
        } else {
            header('Location: ' . BASE_URL . "permissions");
        }
    }

    public function edit_action($id)
    {
        $p = new Permissions();
        if (!empty($id) && $id != 1) {
            if (!empty($_POST['name'])) {
                $new_name = $_POST['name'];

                $p->editNameGroup($new_name, $id);
                $p->clearLinksGroup($id);

                //Mensagem retorno de sucesso.
                $_SESSION['alert'] = 'success';
                $_SESSION['textHeader'] = 'Sucesso!';
                $_SESSION['mensagem'] = 'Permissão <b>' . $this->arrayInfo['permission_group_name'] . '</b> editada com sucesso!';


                if (isset($_POST['itens']) && count($_POST['itens']) > 0) {
                    foreach ($_POST['itens'] as $item) {
                        $p->itemToGroup($item, $id);
                    }
                }
                header('Location: ' . BASE_URL . "permissions/");
            } else {
                //Observações
                $_SESSION['formError']  = array('name');
                header('Location: ' . BASE_URL . "permissions/edit/" . $id);
                exit;
            }
        } else {
            header('Location: ' . BASE_URL . "permissions");
        }
    }
    //Deletar permissões
    public function delete($id_group)
    {
        $p = new Permissions();

        $p->DeleteGroup($id_group);

        //Mensagem retorno de sucesso.
        $_SESSION['alert'] = 'success';
        $_SESSION['textHeader'] = 'Deletado!';
        $_SESSION['mensagem'] = 'Permissão deletada com sucesso!';


        header('Location: ' . BASE_URL . "permissions");
        exit;
    }

    //Editar itens
    public function item_edit($id)
    {
        if (!empty($id)) {
            $this->arrayInfo['errorItens'] = array();

            $p = new Permissions();

            $this->arrayInfo['permission_item'] = $id;
            $this->arrayInfo['permission_item_name'] = $p->getItemName($id);

            //se tiver vazio o campo, redireciona pra pagina com um alerta
            if (isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
                $this->arrayInfo['errorItens'] = $_SESSION['formError'];
                unset($_SESSION['formError']);
            }

            $this->loadTemplate('permissions_item_edit', $this->arrayInfo);
        } else {
            header('Location: ' . BASE_URL . "permissions/itens");
        }
    }

    public function edit_item_action($id)
    {
        $p = new Permissions();
        if (!empty($id)) {
            if (!empty($_POST['name'])) {
                $new_name = $_POST['name'];

                $p->editItemName($new_name, $id);

                //Mensagem retorno de sucesso.
                $_SESSION['alert'] = 'success';
                $_SESSION['textHeader'] = 'Sucesso!';
                $_SESSION['mensagem'] = 'Item editado com sucesso!';

                header('Location: ' . BASE_URL . "permissions/itens");
            } else {
                //Observações
                $_SESSION['formError']  = array('name');
                header('Location: ' . BASE_URL . "permissions/item_edit/" . $id);
                exit;
            }
        } else {
            header('Location: ' . BASE_URL . "permissions/itens");
        }
    }

    public function item_delete($id_item)
    {
        $p = new Permissions();
        if ($id_item != 1) { // Não deixa excluir o item de ver permissoes
            $p->delete_item_model($id_item);

            //Mensagem retorno de sucesso.
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Item deletado com sucesso!';
        }


        header('Location: ' . BASE_URL . "permissions/itens");
        exit;
    }

    public function itens_add()
    {

        $this->arrayInfo['errorItens'] = array();

        //se tiver vazio o campo, redireciona pra pagina com um alerta
        if (isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
            $this->arrayInfo['errorItens'] = $_SESSION['formError'];
            unset($_SESSION['formError']);
        }

        $this->loadTemplate('permissions_item_add', $this->arrayInfo);
    }

    public function itens_add_action()
    {
        $p = new Permissions();
        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $slug = $_POST['slug'];

            //Mensagem retorno de sucesso.
            $_SESSION['alert'] = 'success';
            $_SESSION['textHeader'] = 'Sucesso!';
            $_SESSION['mensagem'] = 'Item adicionado com sucesso!';

            // Ao adicionar item de permissão, automaticamente cria permissão para o Super ADM
            $p->itemToGroup($p->addNewItem($name, $slug), '1');

            header('Location: ' . BASE_URL . "permissions/itens");
        } else {
            //Observações
            $_SESSION['formError']  = array('name');
            header('Location: ' . BASE_URL . "permissions/itens");
            exit;
        }
    }
}
