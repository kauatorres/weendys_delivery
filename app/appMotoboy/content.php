<?php
include('../../inc/config.php');
$url = explode('/', $_GET['pages']);

$display = null;
?>
<!DOCTYPE html>

<html lang="pt-BR">
<head>
  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Motoboy APP</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="manifest" href="__manifest.json">
</head>

<body>
	
	<!-- loader -->
	<div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

	 <!-- App Header -->
	 <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Discover
        </div>
        <div class="right">
            <a href="javascript:;" class="headerButton toggle-searchbox">
                <ion-icon name="search-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

	<!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form"  onsubmit="return false;">
            <div class="form-group searchbox">
                <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Pesquisar...">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <a href="javascript:;" class="ml-1 close toggle-searchbox">
                    <ion-icon name="close-circle"></ion-icon>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component -->

	<!-- App Capsule -->
    <div id="appCapsule">


	<?php
		
		if( file_exists('pages/'.$url[0].'.php')){
			if ($_GET) {
				require_once 'pages/'.$url[0].'.php';
			}
		}else{
				require_once 'pages/404.php';
		}
	?>


	</div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <div class="appBottomMenu" style="display: <?=$display;?>;">
      
        <a href="perfil" class="item">
            <div class="col">
                <ion-icon name="person-circle-outline"></ion-icon>
            </div>
        </a>
        <a href="inicio" class="item active">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
            </div>
        </a>
        
        <a href="javascript:;" class="item" data-toggle="modal" data-target="#sidebarPanel">
            <div class="col">
                <ion-icon name="menu-outline"></ion-icon>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">

                    <!-- profile box -->
                    <div class="profileBox">
                        <div class="image-wrapper">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="imaged rounded">
                        </div>
                        <div class="in">
                            <strong>Julian Gruber</strong>
                            <div class="text-muted">
                                <ion-icon name="location"></ion-icon>
                                Alvorada - RS
                            </div>
                        </div>
                        <a href="javascript:;" class="close-sidebar-button" data-dismiss="modal">
                            <ion-icon name="close"></ion-icon>
                        </a>
                    </div>
                    <!-- * profile box -->

                    <ul class="listview flush transparent no-line image-listview mt-2">
                        <li>
                            <a href="inicio" class="item">
                                <div class="icon-box bg-secondary">
                                    <ion-icon name="home-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Página inicial
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="perfil" class="item">
                                <div class="icon-box bg-secondary">
                                    <ion-icon name="person-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Perfil
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="entregues" class="item">
                                <div class="icon-box bg-success">
                                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    Pedidos entregues
                                </div>
                            </a>
                        </li>
                        
                    </ul>

                   
                    
                </div>

                <!-- sidebar buttons -->
                <div class="sidebar-buttons">
                    <a href="perfil" class="button">
                        <ion-icon name="person-outline"></ion-icon>
                    </a>
                    <a href="entregues" class="button">
                        <ion-icon name="archive-outline"></ion-icon>
                    </a>
                    <a href="sair" class="button">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </a>
                </div>
                <!-- * sidebar buttons -->
            </div>
        </div>
    </div>
    <!-- * App Sidebar -->

    
    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="assets/js/lib/jquery-3.4.1.min.js"></script>

    <script type="text/javascript">

	function buscarNome(nome) {
		$.ajax({
			url: "func/list_orders.php",
			method: "POST",
			data: {nome:nome},
			success: function(data){
				$('#resultado').html(data);
			}
		});
	}

	$(document).ready(function(){
		buscarNome();

		$('#buscar').keyup(function(){
			var nome = $(this).val();
			if (nome != ''){
				buscarNome(nome);
			}
			else
			{
				buscarNome();
			}
		});
	});


    </script>
    <!-- Bootstrap-->
    <script src="assets/js/lib/popper.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/base.js"></script>




</body>

</html>