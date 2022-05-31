var controleCampo = 1;
function adicionarCampo() {
    controleCampo++;
    //console.log(controleCampo);
    //  id="campo' + controleCampo + '"
    document.getElementById('plusplus').insertAdjacentHTML('beforeend', '<div class="row" id="campo' + controleCampo + '"><div class=\"col-sm-8\"><div class=\"form-group\"><input type=\"text\" class=\"form-control\" name="product_size[]" id="tamanho" placeholder="..."></div></div><div class="col-sm-4"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span></div><input type="text" name="product_price[]" id="preco" class="money form-control" placeholder="0" inputmode="numeric"><div class="input-group-append"><button type="button" class="btn btn-danger input-group-text remove_button"  id="' + controleCampo + '" onclick="removerCampo(' + controleCampo + ')"><i class="fa-solid fa-minus"></i></button></div></div></div></div></div>');
}

function removerCampo(idCampo) {
    //console.log("Campo remover: " + idCampo);
    document.getElementById('campo' + idCampo).remove();
}


/* EDIT */
function adicionarCampo01() {
    controleCampo++;
    //console.log(controleCampo);
    //  id="campo' + controleCampo + '"
    document.getElementById('plusplus').insertAdjacentHTML('beforeend', '<div class="row" id="campo' + controleCampo + '"><div class=\"col-sm-8\"><div class=\"form-group\"><input type=\"text\" class=\"form-control\" name="product_size_add[]" id="tamanho" placeholder="..." required></div></div><div class="col-sm-4"><div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span></div><input type="text" name="product_price_add[]" id="preco" class="money form-control" placeholder="0" inputmode="numeric" required><div class="input-group-append"><button type="button" class="btn btn-danger input-group-text remove_button"  id="' + controleCampo + '" onclick="removerCampo01(' + controleCampo + ')"><i class="fa-solid fa-minus"></i></button></div></div></div></div></div>');
}

function removerCampo01(idCampo) {
    //console.log("Campo remover: " + idCampo);
    document.getElementById('campo' + idCampo).remove();
}


/* CATEGORY ADD */
function adicionarCampo02() {
    controleCampo++;
    //console.log(controleCampo);
    //  id="campo' + controleCampo + '"
    document.getElementById('plusplus').insertAdjacentHTML('beforeend', '<div class="row" id="campo' + controleCampo + '"><div class="col-sm-12"> <div class="form-group">  <div class="input-group"> <div class="input-group-prepend"> <span class="input-group-text"><i class="fa-solid fa-tags"></i></span> </div> <input type="text" name="category_name[]" class="form-control" placeholder="Categoria"> <div class="input-group-append"> <button type="button"  class="btn btn-danger input-group-text"  id="' + controleCampo + '" onclick="removerCampo02(' + controleCampo + ')"><i class="fa-solid fa-minus"></i></button> </div> </div> </div> </div></div>');
}

function removerCampo02(idCampo) {
    //console.log("Campo remover: " + idCampo);
    document.getElementById('campo' + idCampo).remove();
}


$(document).ready(function ($) {
    $('.money').mask('000.000.000.000.000,00', { reverse: true });
    $('#cnpj').mask('00.000.000/0000-00', { reverse: true });
    $(document).on("focus", ".money", function () {
        $('.money').mask('000.000.000.000.000,00', { reverse: true });
    });

    document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function (event) {
            let checkboxLabel = document.querySelector('label[for="disponibilidade"]');
            let checkboxID = document.getElementById('disponibilidade');
            if (checkboxLabel) checkboxLabel.textContent = checkbox.checked ? "Disponível" : "Indisponível";
        });
    });
});
$(".money").focusout(function ($) {
    if ($(this).val().length <= 2) {
        temp = $(this).val()
        var newNum = temp + ",00"
        $(this).val(newNum)
    }
})




//url mostrando modal
function showModal(url) {
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            $('#modal-default').modal('show');
            $('#modal-default .modal_pedido').html(data);
        }
    });
}

function cont() {
    var conteudo = conteudo = document.getElementById("imprimirPedido").outerHTML;
    document.getElementById('imprimirPedido').innerHTML;
    tela_impressao = window.open('about:blank');
    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
    tela_impressao.window.close();
}

//se tiver uma nova notificacao, mostra modal automaticamente   
$(document).ready(function () {
    const timeoutClear = setInterval(function () {
        $.ajax({
            url: 'http://localhost/pixMP/painel/configuration/countNotifyJson',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.count > 0) {
                    //data.result[0].isd
                    for (var i = 0; i < data.count; i++) {
                        showModal('http://localhost/pixMP/painel/configuration/pedidoModal/' + data.result[i].id_pedido);
                    }

                    /* var audio = new Audio('http://localhost/pixMP/painel/assets/adminlte/plugins/notify/toque.mp3');
                    audio.play();
                    audio.loop = true;
                    audio.currentTime = 0.3; */
                    //window.print();
                    clearInterval(timeoutClear);
                }
            }
        });
    }, 1000);
    //pesquisar pedidos
    $('#pesquisar').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('#tabelaPedidos tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});







