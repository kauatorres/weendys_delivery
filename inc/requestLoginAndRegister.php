<?php
include("config.php");
include("functions.php");

if (isset($_GET['verificarLogin'])) {
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type');

    if (isset($_POST['cpf_email'])) {
        $cpf_email = strtolower($_POST['cpf_email']);
        $password = $_POST['senha'];
    }

    $user = $pdo->query("SELECT * FROM clientes WHERE email = '$cpf_email' OR cpf = '$cpf_email'");
    $user = $user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verificar credenciais do usuário
        if (password_verify($password, $user['senha'])) {
            $expire = time() + 60 * 60 * 24 * 30;
            setCookie('cpf_email', $cpf_email, $expire, "/");
            setCookie('logado', 'true', $expire, "/");

            $json = ['result' => true];
            echo json_encode($json);
        } else {
            $json = ['result' => false, 'message' => 'Os dados de acesso estão incorretos.'];
            echo json_encode($json);
        }
    } else {
        $json = ['result' => false, 'message' => 'Usuário não encontrado, verifique se suas credenciais estão corretass.'];
        echo json_encode($json);
    }
    die();
}

if (isset($_GET['registro'])) {
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type');

    if (isset($_POST['nome'])) {
        $nome = ucfirst(strtolower($_POST['nome']));
        $sobrenome = ucwords(strtolower($_POST['sobrenome']));
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $whatsapp = $_POST['whatsapp'];
        $cep = $_POST['cep'];
        $endereco = "R. " . $_POST['rua'] . ", " . $_POST['numero'] . " - " . $_POST['bairro'] . " — " . $_POST['cidade'] . "/" . $_POST['estado'] . " ";
    } elseif (empty($_POST['nome'])) {
        exit('Bad Request.');
    }

    $user = $pdo->query("SELECT * FROM clientes WHERE email = '$email' OR cpf = '$cpf'");
    $user = $user->fetch(PDO::FETCH_ASSOC);


    if (!$user) {
        //fazer pra cadastrar aqui
        $create = $pdo->prepare("INSERT INTO `clientes` (`nome`, `sobrenome`, `senha`, `cpf`, `email`, `whatsapp`, `cep`, `endereco`) VALUES ('$nome', '$sobrenome', '$senha', '$cpf', '$email', '$whatsapp', '$cep', '$endereco')");
        $create = $create->execute();

        $expire = time() + 60 * 60 * 24 * 30;
        setCookie('cpf_email', $cpf, $expire, "/");
        setCookie('logado', 'true', $expire, "/");

        $json = ['result' => true];
        echo json_encode($json);
    } else {
        $json = ['result' => false, 'message' => 'O usuário com este e-mail/cpf já existe.'];
        echo json_encode($json);
    }
    die();
}
