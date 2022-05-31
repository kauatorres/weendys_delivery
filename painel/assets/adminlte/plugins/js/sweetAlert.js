var urlInput = {};

urlInput.keyPress = function (e) {
  var e = e || window.event;
  var key = e.charCode;
  if (key === undefined)
    key = e.keyCode;

  //maiusculas, minusculas, números e traço
  if ((key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key >= 48 && key <= 57) || (key == 45) || (key == 32))
    return true;

  //Não imprime letra
  if (key == 0)
    return true;

  return false;
}

urlInput.keyUp = function (txt) {
  txt.value = txt.value.replace(/[\s]/gi, "_"); //Transforma espaço em traço
  txt.value = txt.value.toLowerCase();
  txt.value = txt.value.replace(/[^a-z0-9_]/gi, ''); //Remove tudo que não for letras, números ou traço
  return true;
}
function toggle(source) {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i] != source)
      checkboxes[i].checked = source.checked;
  }
}

function confirmExclude(url) {
  Swal.fire({
    title: 'Você tem certeza que deseja excluir?',
    text: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sim, deletar!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = url;
    }
  })
}

function moeda(a, e, r, t) {
  let n = ""
    , h = j = 0
    , u = tamanho2 = 0
    , l = ajd2 = ""
    , o = window.Event ? t.which : t.keyCode;
  if (13 == o || 8 == o)
    return !0;
  if (n = String.fromCharCode(o),
    -1 == "0123456789".indexOf(n))
    return !1;
  for (u = a.value.length,
    h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
    ;
  for (l = ""; h < u; h++)
    -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
  if (l += n,
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2) {
    for (ajd2 = "",
      j = 0,
      h = u - 3; h >= 0; h--)
      3 == j && (ajd2 += e,
        j = 0),
        ajd2 += l.charAt(h),
        j++;
    for (a.value = "",
      tamanho2 = ajd2.length,
      h = tamanho2 - 1; h >= 0; h--)
      a.value += ajd2.charAt(h);
    a.value += r + l.substr(u - 2, u)
  }
  return !1
}

function confirmLogout(url) {
  Swal.fire({
    title: 'Você tem certeza que deseja sair?',
    text: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sim, sair!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = url;
    }
  })
}