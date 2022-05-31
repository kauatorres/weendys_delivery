(function (win, doc) {
    "use strict";

    window.Mercadopago.setPublishableKey("TEST-3e8e8567-0045-45f7-89ab-369ee5848930");

    window.Mercadopago.getIdentificationTypes();

    function cardBin(event) {
        let textLength = event.target.value.length;
        if (textLength >= 6) {
            let bin = event.target.value.substring(0, 6);
            window.Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethodInfo);

            Mercadopago.getInstallments({
                "bin": bin,
                "amount": parseFloat(document.querySelector('#amount').value),
            }, setInstallmentInfo);
        }
    }

    if (doc.querySelector('#cardNumber')) {
        let cardNumber = doc.querySelector('#cardNumber');
        cardNumber.addEventListener('keyup', cardBin, false);
    }


    function setInstallmentInfo(status, response) {
        let label = response[0].payer_costs;
        let installmentsSel = doc.querySelector('#installments');
        installmentsSel.options.length = 0;

        label.map(function (elem, ind, obj) {
            let txtOpt = elem.recommended_message;
            let valOpt = elem.installments;
            installmentsSel.options[installmentsSel.options.length] = new Option(txtOpt, valOpt);
        });

    };

    function sendPayment(event) {
        event.preventDefault();
        window.Mercadopago.createToken(event.target, sdkResponseHandler);
    }

    function sdkResponseHandler(status, response) {
        if (status == 200 || status == 201) {
            let form = doc.querySelector('#pay');
            let card = doc.createElement('input');
            document.getElementById("pay").disabled = true;
            card.setAttribute('name', 'token');
            card.setAttribute('hidden', 'text');
            card.setAttribute('value', response.id);
            form.appendChild(card);
            form.submit();
        }
    }

    if (doc.querySelector('#pay')) {
        let formPay = doc.querySelector('#pay');
        formPay.addEventListener('submit', sendPayment, false);
    }


    function setPaymentMethodInfo(status, response) {
        if (status == 200) {
            const paymentMethodElement = doc.querySelector('input[name=paymentMethodId]');
            paymentMethodElement.value = response[0].id;
            //doc.querySelector('.brand').innerHTML = "<img src='" + response[0].thumbnail + "' alt='Bandeira do Cartão'>";
            var brand = document.getElementById('cardNumber');
            brand.setAttribute('style', 'background: url("' + response[0].thumbnail + '") no-repeat;background-position: 97%;');
        } else {
            //alert(`payment method info error: ${response}`);
        }
    }
})(window, document);

const tbody = document.querySelector(".listar-pedidos");

const listarPedidos = async (pagina) => {
    const dados = await fetch("inc/views.php?getPedidosClient&pagina=" + pagina);
    const resposta = await dados.text();
    tbody.innerHTML = resposta;
}

listarPedidos(1);


$(document).ready(function () {
    $(document).on('click', '.view_data', function () {
        var produto_id = $(this).attr("id");
        if (produto_id !== '') {
            var dados = {
                produto_id: produto_id
            };
            $.post('inc/views.php?getProductInfo', dados, function (retorna) {
                $("#dataPedidos").html(retorna);
                $('#modalPedidos').modal('show');
            });
        }
    });
});

const redirect = async (url) => {
    location.href = url;
}


