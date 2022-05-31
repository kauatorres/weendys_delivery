<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="inicio"><?= $titulo; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="inicio"><i class="fa fa-home"></i> Início</a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-address-book"></i> Contatos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="https://wa.me/<?= $whatsapp; ?>" target="_blank"> <i class="fa-brands fa-whatsapp"></i> Whatsapp</a>
                    </ul>
                </li>

                <?php
                if (isset($_COOKIE['logado'])) {
                    //Mostra o menu de "Minha conta" somente se estiver logado
                    echo '<li class="nav-item active">
                                <a class="nav-link " href="perfil"><i class="fa fa-user"></i> Minha conta</a>
                            </li>';
                    /* echo '<li class="nav-item active">
                            <a class="nav-link" href="carrinho"><i class="fa-solid fa-basket-shopping-simple"></i> Carrinho</a>
                        </li>'; */
                    echo '<li class="nav-item active">
                                <a class="nav-link" href="sair"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
                            </li>';
                } else {
                    echo '<li class="nav-item active">
                                <a class="nav-link" href="inicio?login"> <i class="fa-solid fa-door-open"></i> Efetuar Login</a>
                            </li>';
                }
                ?>


            </ul>
        </div>


        <div class="d-flex align-items-center">
            <!-- Icon -->
            <a class="me-3" href="carrinho">
                <i class="fa-regular fa-basket-shopping-simple"></i>
                <span class="badge rounded-pill badge-notification bg-danger">
                    <?php
                    if (isset($_SESSION['carrinho'])) {
                        echo count($_SESSION['carrinho']);
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </a>

        </div>



    </div>
</nav>





<?php
//Excluir capa em páginas específicas
$display = null;
if ($url[0] == 'perfil') {
    $display = "none";
}
?>
<div class="p-5 mb-4 bg-dark text-white" style="display: <?= $display; ?>;background: url('src/img/<?= $header; ?>?v=<?= rand(0, 999999999); ?>') no-repeat;background-size: cover;background-position: 30% 45%;background-color: rgba(0, 0, 0, .7);background-blend-mode: overlay;border-radius: 0% 0% 0% 0% / 10% 10% 20% 20%;">
    <img class="d-block mx-auto mb-4 circle" src="src/img/<?= $logo; ?>?v=<?= rand(0, 999999999); ?>" alt="<?= $titulo; ?>_LOGO">
    <h2 style="font-family: SFBold;" class="text-center"><?= $titulo; ?></h2>
</div>