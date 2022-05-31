<?php

if (isset($_GET['registro'])) {
    if ($logado == 'true') {
        echo "<script>window.location.href='inicio';</script>";
        exit;
    }
?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#modalRegistro').modal('show');
            $('#myMomodalRegistrodal').modal({
                backdrop: 'static',
                keyboard: false
            });

        })
    </script>
    <div class="modal fade text-dark" id="modalRegistro" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registro</h5>
                    <a href="inicio" type="button" class="btn-close"></a>
                </div>
                <div class="modal-body">
                    <span>
                        Já possui uma conta?
                        <a href="?login" type="button" class="btn btn-primary btn-sm" style="float:right;margin-top:-5px;">Login</a>
                    </span>
                    <hr>
                    <form method="post" class="ajax_registro" autocomplete="off">

                        <div class="bootstrap-wrapper">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 mt-2">
                                        <label for="nome" class="form-label">Nome</label>
                                        <input type="text" class="form-control" maxlength="20" pattern=".{0,20}" title="Seu nome deve ter no máximo 20 caracteres" id="nome" name="nome" placeholder="Preencha seu nome" value="" required>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="sobrenome" class="form-label">Sobrenome</label>
                                        <input type="text" class="form-control" maxlength="20" title="Seu sobrenome deve ter no máximo 20 caracteres" id="sobrenome" name="sobrenome" placeholder="Preencha seu sobrenome" value="" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="senha" class="form-label">Senha</label>
                                        <input type="password" class="form-control" id="senha" name="senha" pattern=".{6,50}" title="Insira uma senha de pelo menos 6 e até 50 caracteres." placeholder="********" value="" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Preencha seu e-mail" value="" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="CPF" class="form-label">CPF</label>
                                        <input type="tel" class="form-control" id="cpf" name="cpf" maxlength="11" placeholder="Preencha seu CPF" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="contato" class="form-label">Whatsapp</label>
                                        <input type="tel" class="form-control" id="whatsapp" name="whatsapp" placeholder="Preencha seu telefone" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="cep" class="form-label">CEP</label>
                                        <input type="tel" class="form-control" id="cep" name="cep" size="10" maxlength="9" onblur="pesquisacep(this.value);" placeholder="00000-000" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="rua" class="form-label">Rua</label>
                                        <input type="text" class="form-control" id="rua" name="rua" value="" placeholder="" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="numero" class="form-label">Número</label>
                                        <input type="tel" class="form-control" id="numero" name="numero" value="" placeholder="">
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="bairro" class="form-label">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro" value="" placeholder="" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="cidade" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" value="" placeholder="" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="uf" class="form-label">Estado</label>
                                        <input type="text" class="form-control" id="uf" name="estado" value="" placeholder="" required>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="alert alert-danger" id="message" style="display: none;text-align: center;"></div>
                                        <input type="submit" value="REGISTRAR-SE">
                                    </div>
                                </div>
                            </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
<?php
} elseif (isset($_GET['login'])) {
    if ($logado == 'true') {
        echo "<script>window.location.href='inicio';</script>";
        exit;
        //header location
    }
?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#modalLogin').modal('show');
        })
    </script>
    <div class="modal fade text-dark" id="modalLogin" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <a href="inicio" type="button" class="btn-close"></a>
                </div>
                <div class="modal-body">
                    <span>
                        Não possui uma conta?
                        <a href="?registro" type="button" class="btn btn-warning btn-sm" style="float:right;margin-top:-5px;">Registrar-se</a>
                    </span>
                    <hr>
                    <form method="post" id="formLogin" class="ajax_login">

                        <div class="bootstrap-wrapper">
                            <div class="container">
                                <div class="row">

                                    <div class="col-md-12 mt-2">
                                        <label for="cpf_email" class="form-label">E-mail ou CPF</label>
                                        <input type="text" class="form-control" id="cpf_email" name="cpf_email" pattern="[\d]{11}|[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" title="Insira um E-mail ou CPF" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="senha" class="form-label">Senha</label>
                                        <input type="password" class="form-control" id="senha" name="senha" required>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="alert alert-danger" id="message" style="display: none;text-align: center;"></div>
                                        <input type="submit" value="ENTRAR" id="btn-acessar">
                                    </div>
                                </div>
                            </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
<?php } ?>