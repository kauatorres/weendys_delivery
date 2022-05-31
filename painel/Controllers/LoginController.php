<?php

namespace Controllers;

use \Core\Controller;
use Models\Users;

class LoginController extends Controller
{

    public function index()
    {
        $array = array(
            'error' => ''
        );

        if (!empty($_SESSION['errorMsg'])) {
            $array['error'] = $_SESSION['errorMsg'];
            $_SESSION['errorMsg'] = ''; //zerar msg 
        } else if (isset($_SESSION['token'])) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->loadView('login', $array);
    }

    public function index_action() /* RECEBE OS DADOS DO FORMULARIO LOGIN */
    {
        if (!empty($_POST['cpf']) && !empty($_POST['senha'])) {
            $cpf = $_POST['cpf'];
            $senha = $_POST['senha'];

            $u = new Users();
            if ($u->validateLogin($cpf, $senha)) {
                //Dados validados
                header('Location: ' . BASE_URL);
                exit;
            } else {
                $_SESSION['errorMsg'] = "CPF e/ou senha errados!";
            }
        } else {
            $_SESSION['errorMsg'] = "Preencha os campos abaixo.";
        }
        header('Location: ' . BASE_URL . 'login');
        exit;
    }

    public function logout()
    {
        unset($_SESSION['token']);
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}
