<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= NOME_SITE; ?> | Painel (v<?= VERSAO; ?>)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/adminlte/plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/adminlte/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= BASE_URL; ?>" class="h2"><b><?= NOME_SITE; ?> </b><span class="h5"><?= VERSAO; ?></span></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">
                    Efetue o login para acessar o painel.
                </p>
                <?php
                if (!empty($error)) {
                    echo '<div class="callout callout-danger">' . $error . '</div>';
                }
                ?>
                <form action="<?= BASE_URL; ?>login/index_action" method="post">
                    <div class="input-group mb-3">
                        <input type="tel" id="cpf" name="cpf" maxlength="11" class="form-control" placeholder="Preencha seu CPF" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-address-card"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <a href="">Esqueci minha senha</a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= BASE_URL; ?>/assets/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= BASE_URL; ?>/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Toastr -->
    <script src="<?= BASE_URL; ?>/assets/adminlte/plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= BASE_URL; ?>/assets/adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>