<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= NOME_SITE; ?> | Painel</title>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= BASE_URL; ?>assets/adminlte/plugins/fontawesome-free/css/all.min.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASE_URL; ?>assets/adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?= BASE_URL; ?>assets/adminlte/dist/css/css.css?v=<?= rand(0, 99999999); ?>">
  <!-- sweet alert -->
  <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/js/sweetAlert.js?v=<?= rand(0, 99999999); ?>"></script>
  <!-- datatables -->
  <link rel="stylesheet" href="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- toastr -->
  <link rel="stylesheet" href="<?= BASE_URL; ?>assets/adminlte/plugins/toastr/toastr.min.css">
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/toastr/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    setInterval(function() {
      $('#alert').load(window.location.href + " " + '#alert');
      $('#alertCount').load(window.location.href + " " + '#alertCount');
      $('#pedidoRecente').load(window.location.href + " " + '#pedidoRecente');
    }, 1000);
  </script>


</head>

<body class="hold-transition sidebar-mini dark-mode">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown" style="font-size:20px;">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa-regular fa-bell-on"></i>
            <span id="alertCount">
              <span class="badge badge-danger navbar-badge"><?= $viewData['user']->countNotification(); ?></span>
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div id="alert">
              <?php
              if ($viewData['user']->countNotification() == 0) {
                echo '<span style="padding:10px" class="text-center">Nenhuma notificação no momento!</span>';
              } else {
                foreach ($viewData['user']->getNotification() as $notificacoes) { ?>
                  <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                      <img src="https://www.fiscalti.com.br/wp-content/uploads/2021/02/default-user-image.png" alt="User Avatar" class="img-size-50 img-circle mr-3">
                      <div class="media-body">
                        <h3 class="dropdown-item-title">
                          Notificação
                          <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                        </h3>
                        <p class="text-sm">xxxx</p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> agora mesmo</p>
                      </div>
                    </div>
                    <!-- Message End -->
                  </a>
              <?php }
              } ?>
            </div>
            <div class="dropdown-divider"></div>

            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Ver todos pedidos</a>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" onclick="confirmLogout('<?= BASE_URL; ?>login/logout');" href="#">
            <i class="nav-icon fas fa-sign-out-alt"></i> Sair
          </a>
        </li>

        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> -->
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= BASE_URL; ?>" class="brand-link">
        <img src="<?= BASE_URL; ?>assets/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= NOME_SITE; ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="https://www.fiscalti.com.br/wp-content/uploads/2021/02/default-user-image.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $viewData['user']->getUserInfos('username'); ?></a>
            <span class="text-white text-muted">Desde:
              <?php
              $date = strtotime($viewData['user']->getUserInfos('data_registro'));
              $dateformated = date("d/m/Y", $date);
              echo ($dateformated);
              ?>
            </span>
          </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?= BASE_URL; ?>" class="nav-link <?= ($viewData['menuActive'] == "home") ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <?php if ($viewData['user']->hasPermission('permissions_view')) { ?>
              <li class="nav-item">
                <a href="<?= BASE_URL; ?>permissions" class="nav-link <?= ($viewData['menuActive'] == "permissions") ? 'active' : ''; ?>">
                  <i class="nav-icon  fas fa-user-secret nav-icon"></i>
                  <p>Permissões</p>
                </a>
              </li>
            <?php } ?>


            <?php if ($viewData['user']->hasPermission('store_config')) { ?>
              <li class="nav-item">
                <a href="<?= BASE_URL; ?>configuration" class="nav-link <?= ($viewData['menuActive'] == "configuration") ? 'active' : ''; ?>">
                  <i class="nav-icon  fas fa-cogs nav-icon"></i>
                  <p>Configurações</p>
                </a>
              </li>
            <?php } ?>

            <?php if ($viewData['user']->hasPermission('products_view')) { ?>
              <li class="nav-item">
                <a href="<?= BASE_URL; ?>produtos" class="nav-link <?= ($viewData['menuActive'] == "produtos") ? 'active' : ''; ?>">
                  <i class="nav-icon  fa-duotone fa-cart-shopping-fast"></i>
                  <p>Produtos</p>
                </a>
              </li>
            <?php } ?>

            <?php if ($viewData['user']->hasPermission('sales_view')) { ?>
              <li class="nav-item">
                <a href="<?= BASE_URL; ?>pedidos" class="nav-link <?= ($viewData['menuActive'] == "pedidos") ? 'active' : ''; ?>">
                  <i class="nav-icon fa-duotone fa-store"></i>
                  <p>Pedidos</p>
                </a>
              </li>
            <?php } ?>

            <?php if ($viewData['user']->hasPermission('users_view')) { ?>
              <li class="nav-item">
                <a href="<?= BASE_URL; ?>clientes" class="nav-link <?= ($viewData['menuActive'] == "clientes") ? 'active' : ''; ?>">
                  <i class="nav-icon fa-duotone fa-users-gear"></i>
                  <p>Clientes</p>
                </a>
              </li>
            <?php } ?>



            <li class="nav-item">
              <a href="#" onclick="confirmLogout('<?= BASE_URL; ?>login/logout');" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  Deslogar
                </p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php $this->loadViewInTemplate($viewName, $viewData); ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>####</h5>
        <p>Sidebar</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->

  </div>
  <!-- ./wrapper -->

  <!-- MODAL PEDIDOS ABRIR AUTOMATICAMENTE -->
  <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="height: 60px;">
          <h2 class="modal-title" id="exampleModalLongTitle">NOVO PEDIDO</h2>
        </div>
        <div class="modal_pedido"></div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <!--   <script src="<?= BASE_URL; ?>assets/adminlte/plugins/jquery/jquery.min.js"></script>
 -->
  <!-- MASK -->
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/js/mask.js?v=<?= rand(0, 99999999) ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= BASE_URL; ?>assets/adminlte/dist/js/adminlte.min.js"></script>

  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- datatable -->
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/js/events.js?v=<?= rand(0, 99999999) ?>"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/jszip/jszip.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= BASE_URL; ?>assets/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <script>
    $(function() {
      bsCustomFileInput.init();
    });
    $(function() {
      $("#produtos").DataTable({
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["pdf", "print"],
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.12.0/i18n/pt-BR.json"
        }
      }).buttons().container().appendTo('#produtos_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>

</html>