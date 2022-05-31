<?php
include('inc/post.php');
if (!isset($_SESSION['carrinho'])) {
  header('location: inicio');
}
?>
<script>
  var clearTimer = setInterval(function() {
    var req = new XMLHttpRequest();
    var resposta = "<span style='color:green;'><i class='fa fa-check'></i> Compra efetuada.</span>";
    var respostaLoading = '<div class="listTutorial" style="text-align:center;"> AGUARDE: <b>REDIRECIONANDO...</b></div>';
    req.onreadystatechange = function() {
      if (req.readyState == 4 && req.status == 200) {
        document.getElementById('status').innerHTML = req.responseText;
      }
      if (document.getElementById('status').innerHTML == "approved") {
        $('#status').html(resposta);
        $('#carregando').html(respostaLoading);

        req.status == 200;
        clearInterval(clearTimer);
        clearTimer = 0;
        window.location = "pedido.php?id=<?= $idPaymentPix; ?>";
      }
    }
    req.open('GET', 'inc/status.php?paymentID=<?= $idPaymentPix; ?>', true);
    req.send();
  }, 1500);

  <?php
  if (isset($_SESSION['msg'])) { ?>
    $(document).ready(function() {
      $("#cartaoCredito").modal('show');
    });
  <?php } ?>
</script>

<?php include('inc/navbar.php');  ?>



<div class="container">

  <div class="row">
    <div class="col-md-6 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Seu carrinho (<?= count($_SESSION['carrinho']) ?>)</span>
        <a href="inicio" type="button" class="btn btn-warning btn-sm">ADICIONAR MAIS ITENS</a>
      </h4>

      <ul class="list-group mb-3">

        <?php
        $carrinhoArray = [];
        foreach ($_SESSION['carrinho'] as $key => $item) {
          $idProd = $item['id_produto'];
          $tamanho_id = $item['tamanho'];
          $prods = $pdo->query("SELECT * FROM produtos AS p JOIN tamanhos AS t ON p.idProduto = t.id_produto WHERE t.id_tamanho = '$tamanho_id'");
          $prods = $prods->fetch(PDO::FETCH_ASSOC);
          if (!in_array($tamanho_id, $carrinhoArray)) {
            $carrinhoArray[] = $item['tamanho'];
        ?>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">(<?= $item['qtd']; ?>x) <?= $prods['produto']; ?> - <?= $prods['tamanho']; ?></h6>
                <small class="text-muted"><?= mb_strimwidth($prods['descricao_produto'], 0, 45, "..."); ?></small>
              </div>
              <span class="text-muted">R$ <?= number_format($prods['valor_produto'] * $item['qtd'], 2, ",", "."); ?></span>
            </li>
        <?php }
        } ?>

        <li class="list-group-item d-flex justify-content-between bg-light">
          <div class="text-<?= $textColor; ?>">
            <h6 class="my-0">Tele Entrega</h6>
            <small><?= isset($text) ? $text : ''; ?></small>
          </div>
          <span class="text-<?= $textColor; ?>">R$ <?= number_format($valorTeleEntrega, 2, ",", "."); ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between bg-light">
          <strong>Subtotal </strong> R$ <?= number_format($_SESSION['totalBRL'], 2, ",", "."); ?>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <strong>Total:</strong>
          <strong style="color:green">R$ <?= number_format($_SESSION['totalBRL']  + $valorTele, 2, ",", "."); ?></strong>
        </li>
      </ul>


    </div>
    <div class="col-md-6 order-md-1">
      <h4 class="mb-3">Informações</h4>

      <form class="needs-validation" method="post" novalidate>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="<?= $consultaCliente['nome']; ?>" disabled>
          </div>
          <div class="col-md-6 mb-3">
            <label for="sobrenome">Sobrenome</label>
            <input type="text" class="form-control" id="sobrenome" placeholder="" value="<?= $consultaCliente['sobrenome']; ?>" disabled>
          </div>

          <div class="col-md-6 mb-3">
            <label for="CPF">CPF</label>
            <input type="text" class="form-control" value="<?= $consultaCliente['cpf']; ?>" placeholder="" disabled>
          </div>

          <div class="col-md-6 mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="<?= $consultaCliente['email']; ?>" placeholder="" disabled>
          </div>

          <div class="col-md-4 mb-3">
            <label for="cep">CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" size="10" maxlength="9" value="<?= $consultaCliente['cep']; ?>" placeholder="00000-000" disabled>
          </div>

          <div class="col-md-7 mb-3">
            <label for="rua">Endereço</label>
            <input type="text" class="form-control" id="rua" placeholder="" value="<?= $consultaCliente['endereco']; ?>" disabled>
          </div>

      </form>
      <hr class="mb-4">

      <h4 class="mb-0">Forma de pagamento</h4>
      <small class="text-muted">Escolha uma opção para forma de pagamento.</small>
      <div class="d-block my-3">
        <button type="button" class="btn btn-warning" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#cartaoCredito" <?= verificaCidade($consultaCliente['endereco']); ?>>
          <span class="material-icons">credit_card</span> <span>Cartão de Crédito </span>
        </button>
      </div>

      <div class="d-block my-1">
        <button type="button" class="btn btn-success" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#pix" <?= verificaCidade($consultaCliente['endereco']); ?>>
          <span class="material-icons">pix</span> <span>PIX</span>
        </button>
        <?php //fazer para aparecer o qrcode / pix copia e cola, desaparecer botaco e após pagamento redirecionar para pagina  de finalizacao 
        ?>
      </div>

      <!-- MODAL CARTÃO  DE CREDITO -->
      <div class="modal fade" id="cartaoCredito" tabindex="-1" role="dialog" aria-labelledby="cartaoCredito" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="cartaoCredito">Pagar com Cartão de Crédito</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div style="background:#00b1ea;padding: 10px;text-align:center;border-radius:5px;">
                <img src="https://http2.mlstatic.com/storage/auth-library/layout/handshake-logo-mp.svg">
              </div>
              <hr>
              <form method="post" action="pagamento/controllers/PaymentController.php" id="pay" name="pay" class="needs-validation" autocomplete="off" required>
                <div class="field" style="margin-bottom:10px;font-size: 14px;">
                  <label for="email">E-mail</label>
                  <input type="email" id="email" name="email" class="form-control-sm form-control" class="form-control-sm form-control" value="<?= $consultaCliente['email']; ?>" placeholder="Seu e-mail" required />
                </div>

                <div class="field" style="margin-bottom:10px;font-size: 14px;">
                  <label for="cardholderName">Nome do Titular:</label>
                  <input type="text" id="cardholderName" class="form-control-sm form-control" data-checkout="cardholderName" placeholder="" required />
                </div>

                <div class="field" style="margin-bottom:10px;font-size: 14px;">
                  <label for="cardNumber">Número do Cartão de Crédito:</label>
                  <input type="tel" id="cardNumber" class="form-control-sm form-control" data-checkout="cardNumber" maxlength="20" placeholder="0000 0000 0000 0000" onselectstart="return false" onpaste="return true" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off required />
                </div>

                <div class="field col-3" style="margin-bottom:10px;display:inline-block;padding-left:0;">
                  <label class="form-text text-gray" style="font-size: 14px;" for="validade_mes">Validade</label>
                  <select id="cardExpirationMonth" required="required" class="form-control-sm form-control dropdown" data-checkout="cardExpirationMonth" placeholder="11" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off>
                    <option value="">M&ecirc;s</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                </div>
                <div class="field col-4" style="margin-bottom:10px;display:inline-block;padding-left:0;font-size: 14px;">
                  <label for="validade_ano">&nbsp;</label>
                  <select id="cardExpirationYear" required="required" class="form-control-sm form-control dropdown" data-checkout="cardExpirationYear" placeholder="2025" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off>
                    <option value="">Ano</option>
                    <?php
                    $ano_atual = date("Y");
                    for ($a = $ano_atual; $a <= ($ano_atual + 12); $a++) {
                      echo "<option value='" . $a . "'>" . $a . "</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="field col-4" style="font-size: 14px;margin-bottom:10px;display:inline-block;padding:0px;max-width:39.2%;">
                  <label class="form-text text-gray" for="digitos">CVV</label>
                  <input class="form-control-sm form-control" type="tel" id="securityCode" maxlength="4" placeholder="Verificador" required="required" data-checkout="securityCode" placeholder="123" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off required>
                  <span class="ccv"></span>
                </div>

                <div class="field col-4" style="font-size: 14px;margin-bottom:10px;display:inline-block;padding-left:0;">
                  <label for="docType">Tipo Documento:</label>
                  <select id="docType" class="form-control-sm form-control dropdown" data-checkout="docType" disabled></select>
                </div>
                <div class="field col-6" style="font-size: 14px;margin-bottom:10px;display:inline-block;padding-left:0;">
                  <label for="docNumber">Número do documento:</label>
                  <input type="tel" class="form-control-sm form-control" id="docNumber" data-checkout="docNumber" maxlength="11" placeholder="000.000.000-00" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                </div>

                <div class="field" style="font-size: 14px;margin-bottom:10px;">
                  <label for="installments">Parcelas:</label>
                  <select id="installments" class="form-control-sm form-control dropdown" class="form-control" name="installments"></select>
                </div>

                <input type="hidden" name="amount" value="<?= $_SESSION['totalBRL']; ?>" id="amount" />
                <input type="hidden" name="description" />
                <input type="hidden" name="paymentMethodId" />


            </div>

            <?php
            if (isset($_SESSION['msg'])) {
              echo $_SESSION['msg'];
              unset($_SESSION['msg']);
            }
            ?>

            <div class="modal-footer">
              <button class="btn btn-success btn-lg btn-block" type="submit" id="pay">FINALIZAR PAGAMENTO</button>
            </div>
            </form>


          </div>
        </div>
      </div>



      <!-- MODAL PIX -->

      <div class="modal fade" id="pix" tabindex="-1" role="dialog" aria-labelledby="pix" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="pix">Pagar com PIX</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="listTutorial" style="text-align:center;">
                STATUS DA COMPRA: <b><span id="status">Carregando...</span></b>
              </div>
              <div id="carregando"></div>
              <div id="display">
                <div class="listTutorial">
                  <span data-v-5d32ba48="" class="material-icons" data-v-3f96ff50="">
                    <svg width="21" height="21" viewBox="0 0 21 21" style="fill: var(--gray-500);">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10 17C13.866 17 17 13.866 17 10C17 6.13401 13.866 3 10 3C6.13401 3 3 6.13401 3 10C3 13.866 6.13401 17 10 17ZM10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" fill="#355CC0"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.1913 5.03806C10.3782 5.11545 10.5 5.29777 10.5 5.5V13H12.5C12.7761 13 13 13.2239 13 13.5C13 13.7761 12.7761 14 12.5 14H7.5C7.22386 14 7 13.7761 7 13.5C7 13.2239 7.22386 13 7.5 13H9.5V6.70711L8.35355 7.85355C8.15829 8.04881 7.84171 8.04881 7.64645 7.85355C7.45118 7.65829 7.45118 7.34171 7.64645 7.14645L9.64645 5.14645C9.78945 5.00345 10.0045 4.96067 10.1913 5.03806Z" fill="#355CC0"></path>
                    </svg>
                  </span>

                  Abra o aplicativo do seu banco e acesse a área Pix.
                </div>
                <div class="listTutorial">
                  <span data-v-5d32ba48="" class="material-icons" data-v-3f96ff50="">
                    <svg width="21" height="21" viewBox="0 0 21 21" style="fill: var(--gray-500);">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10 17C13.866 17 17 13.866 17 10C17 6.13401 13.866 3 10 3C6.13401 3 3 6.13401 3 10C3 13.866 6.13401 17 10 17ZM10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" fill="#355CC0"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M11.089 5.16779C12.179 5.51438 13 6.42191 13 7.49999C13 8.18108 12.6557 8.73529 12.2263 9.19907C11.8273 9.62996 11.3002 10.0394 10.7824 10.4416C10.7489 10.4676 10.7154 10.4937 10.682 10.5197C9.73797 11.2539 8.80834 12.0065 8.26305 13H12.5C12.7761 13 13 13.2239 13 13.5C13 13.7761 12.7761 14 12.5 14H7.5C7.33928 14 7.18835 13.9227 7.09438 13.7924C7.0004 13.662 6.97483 13.4944 7.02566 13.3419C7.58052 11.6773 8.9598 10.5923 10.068 9.73031C10.0926 9.71123 10.117 9.69227 10.1412 9.67343C10.6853 9.25042 11.1513 8.88819 11.4925 8.51966C11.8443 8.13969 12 7.8189 12 7.49999C12 6.96284 11.571 6.37038 10.786 6.12078C10.0279 5.87972 8.94922 5.98094 7.81235 6.89043C7.59672 7.06294 7.28207 7.02798 7.10957 6.81235C6.93706 6.59672 6.97202 6.28207 7.18765 6.10956C8.55078 5.01906 9.97211 4.81265 11.089 5.16779Z" fill="#355CC0"></path>
                    </svg>
                  </span>
                  Escolha a opção que deseja pagar: <b>QR Code (aponte a camera do seu celular no QR abaixo)</b> ou <b>Pix Copia e Cola (Cole o código no espaço indicado no aplicativo)</b>.
                </div>


                <div class="listTutorial">
                  <span data-v-5d32ba48="" class="material-icons" data-v-3f96ff50="">
                    <svg width="21" height="21" viewBox="0 0 21 21" style="fill: var(--gray-500);">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10 17C13.866 17 17 13.866 17 10C17 6.13401 13.866 3 10 3C6.13401 3 3 6.13401 3 10C3 13.866 6.13401 17 10 17ZM10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18Z" fill="#355CC0"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 6.5L7.14645 6.14645C6.95118 6.34171 6.95118 6.65829 7.14645 6.85355C7.34163 7.04873 7.65802 7.04882 7.85331 6.8538L7.85222 6.85489M7.5 6.5C7.14645 6.14645 7.14645 6.14645 7.14645 6.14645L7.14767 6.14523L7.14927 6.14364L7.15361 6.13938L7.16677 6.1267C7.17752 6.11646 7.19222 6.10272 7.21075 6.08598C7.2478 6.05252 7.30032 6.00693 7.36734 5.95332C7.50108 5.84632 7.69437 5.70591 7.93943 5.56588C8.42746 5.287 9.13811 5 10 5C11.7011 5 13 6.15432 13 7.5C13 8.18503 12.6509 8.83365 11.9648 9.29103C11.8226 9.38588 11.6664 9.47233 11.4961 9.54968C11.6833 9.65276 11.8538 9.76897 12.0076 9.89714C12.691 10.4667 13 11.2359 13 12C13 13.4931 11.8081 15 10 15C9.19489 15 8.52315 14.8659 8.05014 14.7308C7.81335 14.6631 7.62531 14.5949 7.49399 14.5424C7.42829 14.5161 7.37667 14.4937 7.34011 14.4772C7.32182 14.4689 7.30729 14.4621 7.29663 14.457L7.28356 14.4508L7.27924 14.4486L7.27763 14.4478L7.27667 14.4474C7.27667 14.4474 7.27639 14.4472 7.5 14L7.27667 14.4474C7.02968 14.3239 6.92929 14.0234 7.05279 13.7764C7.17605 13.5299 7.47548 13.4297 7.7222 13.5521L7.72336 13.5527L7.72656 13.5542C7.73129 13.5564 7.7397 13.5604 7.75169 13.5658C7.77567 13.5766 7.81389 13.5933 7.86538 13.6139C7.96844 13.6551 8.12415 13.7119 8.32486 13.7692C8.72685 13.8841 9.30511 14 10 14C11.1919 14 12 13.0069 12 12C12 11.5141 11.809 11.0333 11.3674 10.6654C10.9199 10.2924 10.1705 10 9 10C8.72386 10 8.5 9.77614 8.5 9.5C8.5 9.22386 8.72386 9 9 9C10.1915 9 10.9579 8.76049 11.4101 8.45897C11.8491 8.16635 12 7.81497 12 7.5C12 6.84568 11.2989 6 10 6C9.36189 6 8.82254 6.213 8.43557 6.43412C8.24312 6.54409 8.09267 6.65368 7.99203 6.73418C7.94187 6.77432 7.90454 6.80685 7.88104 6.82808C7.8693 6.83869 7.86106 6.84643 7.85642 6.85084L7.85222 6.85489" fill="#355CC0"></path>
                    </svg>
                  </span>
                  Após o pagamento, você receberá por email as informações da sua compra.
                </div>


                <label style="margin-top:10px;">Pix copia e cola</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" value="<?= $copiaECola ?>" id="copiaecola" readonly>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" onclick="copiarAreaTransferencia()" type="button"><i class="fa fa-copy"></i></button>
                  </div>
                </div>
                <hr>
                <label style="margin-top:10px;">Pix QR Code</label>
                <div class="mb-3 text-center">
                  <img src="data:image/jpeg;base64,<?php echo $qrCodeBase64; ?>" alt="QRCode" style="width: 300px;">
                </div>

              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary fechar" id="fechar" data-bs-dismiss="modal" aria-label="Close">Fechar</button>
            </div>
          </div>
        </div>
      </div>



    </div>
  </div>
</div>
<?php include("inc/footer.php"); ?>