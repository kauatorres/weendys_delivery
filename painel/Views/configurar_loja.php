 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Configurar loja</h1>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
         <?php if (!empty($msg)) {  ?>
             <div class="callout callout-<?= $alert; ?>">
                 <h5><?= $textHeader; ?></h5>
                 <p><?= $msg; ?></p>
             </div>
         <?php } ?>
         <div class="row">
             <div class="col-md-6">
                 <div class="card card-primary">
                     <div class="card-header">
                         <h3 class="card-title">Configurações da loja</h3>
                     </div>

                     <form method="POST" action="<?= BASE_URL . "configuration/edit" ?>">
                         <div class=" card-body">
                             <div class="form-group">
                                 <label for="">Nome da loja</label>
                                 <input type="text" class="form-control" id="nome_loja" name="nome_loja" placeholder="Insira o nome da sua loja" value="<?= $info['titulo']; ?>" required>
                             </div>
                             <div class="form-group">
                                 <label for="">Endereço de e-mail</label>
                                 <input type="email" class="form-control" id="email_loja" name="email_loja" placeholder="Insira o e-mail da loja" value="<?= $info['emailLoja']; ?>" required>
                             </div>
                             <div class="form-group">
                                 <label for="">CNPJ</label>
                                 <input type="text" class="cnpj form-control" id="cnpj" name="cnpj_loja" value="<?= $info['cnpj']; ?>" maxlength="18" required>
                             </div>

                             <div class="form-group">
                                 <label for="">Qual ano você abriu a empresa?</label>
                                 <input type="number" class="form-control" id="ano_footer_loja" name="ano_footer_loja" placeholder="Ano inicio da empresa" value="<?= $info['anoInicioFooter']; ?>" maxlength=" 4" required>
                             </div>


                             <div class="form-group">
                                 <label for="">Valor tele-entrega</label>

                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                                     </div>
                                     <input type="text" name="tele_valor" class="form-control money" value="<?= $info['valorTele']; ?>" inputmode="numeric">
                                 </div>
                                 <!-- /.input group -->
                             </div>

                             <div class="form-group">
                                 <label for="">Tempo estimado de entrega</label>
                                 <select class="custom-select form-control" id="tempo_estimado" name="tempo_estimado" required>
                                     <?php
                                        if (!empty($info['tempoEstimado'])) {
                                            echo '<option value="' . $info['tempoEstimado'] . '">' . $info['tempoEstimado'] . ' Minutos</option>';
                                        } else {
                                            echo '<option value="">Selecione uma opção</option>';
                                        }
                                        ?>
                                     <option value="10">10 Minutos</option>
                                     <option value="20">20 Minutos</option>
                                     <option value="30">30 Minutos</option>
                                     <option value="40">40 Minutos</option>
                                     <option value="50">50 Minutos</option>
                                     <option value="60">60 Minutos</option>
                                     <option value="70">70 Minutos</option>
                                     <option value="110">110 Minutos</option>
                                     <option value="120">120 Minutos</option>
                                     <option value="130">130 Minutos</option>
                                 </select>
                             </div>
                             <label for="">Para pegar as credenciais do mercado pago: <a href="https://www.mercadopago.com.br/developers/panel" target="_blank">Pegar credencial</a></label>
                             <div class="form-group">
                                 <label for="">Chave Public Key</label>
                                 <input type="text" class="form-control" id="public_key" name="public_key" value="<?= $info['chavePublicKey']; ?>" placeholder="Public Key" required>
                             </div>

                             <div class="form-group">
                                 <label for="">Chave Access Token</label>
                                 <input type="text" class="form-control" id="access_token" name="access_token" value="<?= $info['chaveAccessToken']; ?>" placeholder="Access Token" required>
                             </div>


                             <div class="form-group">
                                 <label for="">Numero para contato (whatsapp)</label>
                                 <input type="tel" class="form-control" id="whatsapp" name="whatsapp" placeholder="Preencha o whatsapp da empresa" value="<?= $info['contatoWhats']; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                             </div>



                         </div>
                         <!-- /.card-body -->
                         <div class="card-footer">
                             <button type="submit" class="btn btn-primary float-right">Atualizar dados</button>
                         </div>
                     </form>
                 </div>
             </div>


             <div class="col-md-6">
                 <div class="card card-primary card-outline">
                     <div class="card-body box-profile">
                         <div class="text-center headerPage" style="background: url('<?= BASE_URL ?>../src/img/header.jpg?v=<?= rand(0, 9999999); ?>') no-repeat;">
                             <img class="profile-user-img img-fluid circle" src="<?= BASE_URL ?>../src/img/<?= $info['logo']; ?>?v=<?= rand(0, 9999999); ?>" alt="">
                         </div>
                         <h3 class="profile-username text-center"><?= $info['titulo']; ?></h3>
                         <p class="text-muted text-center"><?= $info['emailLoja']; ?></p>
                         <ul class="list-group list-group-unbordered mb-3">

                             <li class="list-group-item">
                                 <b>CNPJ </b> <a class="float-right"><?= $info['cnpj']; ?></a>
                             </li>
                             <li class="list-group-item">
                                 <b>Valor tele: </b> <a class="float-right">R$ <?= $info['valorTele']; ?></a>
                             </li>
                         </ul>
                     </div>
                 </div>

                 <div class="card card-primary card-outline">
                     <div class="card-header">
                         <h3 class="card-title">
                             <i class="fa-duotone fa-paintbrush"></i>
                             Alterar identidade visual
                         </h3>
                     </div>

                     <div class="card-body box-profile">

                         <form method="POST" action="<?= BASE_URL . "configuration/visual_identy_logo" ?>" enctype="multipart/form-data">
                             <div class="form-group">
                                 <label for="">Logo</label>
                                 <div class="input-group">
                                     <div class="custom-file">
                                         <input type="file" class="custom-file-input" accept="image/png, image/jpeg" id="logo" name="logo">
                                         <label class="custom-file-label" for="">Escolha um arquivo (logo)</label>
                                     </div>
                                 </div>
                             </div>
                             <button type="submit" class="btn btn-info float-right btn-xs">Atualizar logo</button>
                         </form>
                         <div>⠀</div> <!-- SEPARAR -->
                         <form method="POST" action="<?= BASE_URL . "configuration/visual_identy_capa" ?>" enctype="multipart/form-data">
                             <div class="form-group">
                                 <label for="">Capa</label>
                                 <div class="input-group">
                                     <div class="custom-file">
                                         <input type="file" value="<?= $info['header']; ?>" class="custom-file-input" accept="image/png, image/jpeg" id="capa" name="capa">
                                         <label class="custom-file-label" for="">Escolha um arquivo (capa)</label>
                                     </div>
                                 </div>
                             </div>
                             <button type="submit" class="btn btn-primary float-right btn-xs">Atualizar capa</button>
                         </form>

                     </div>


                 </div>
             </div>



         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->