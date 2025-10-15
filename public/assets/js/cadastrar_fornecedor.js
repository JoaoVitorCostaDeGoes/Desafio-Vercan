
function controleExibicaoCamposFornecedor() {
    const pjRadio = document.getElementById('pjRadio');
    const camposPj = document.getElementById('campos-pj');
    const camposPf = document.getElementById('campos-pf');

    if (pjRadio.checked) {
        camposPj.style.display = 'block';
        camposPf.style.display = 'none';
    } else {
        camposPj.style.display = 'none';
        camposPf.style.display = 'block';
    }
}

function aplicarMascaras() {
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#cpf').mask('000.000.000-00', {reverse: true});
}

function atualizarCampoInscricaoEstadual() {
    const indicadorSelect = document.getElementById("indicadorIE");
    const inscricaoInput = document.getElementById("ie");
    const spanLabel = document.getElementById("label_inscricao_estadual");
    const valor = indicadorSelect.value;

    if (valor === "nao_contribuinte" || valor === "Selecione") {
        inscricaoInput.readOnly = true;
        inscricaoInput.removeAttribute("required");
        spanLabel.innerHTML = "";
    } else {
        inscricaoInput.readOnly = false;
        inscricaoInput.setAttribute("required", "required");
        spanLabel.innerHTML = "*";
        spanLabel.style.color = "red";
    }
}


$(document).ready(function () {
    // Controlar a mudanca de icone dos cards conforme expansao do acordeon
    $('.collapse').on('show.bs.collapse', function () {
        $(this).prev('.card-toggle').find('.btn-tool i').removeClass('fa-plus').addClass('fa-minus');
    });

    $('.collapse').on('hide.bs.collapse', function () {
        $(this).prev('.card-toggle').find('.btn-tool i').removeClass('fa-minus').addClass('fa-plus');
    });

    aplicarMascaras();
    controleExibicaoCamposFornecedor();

    $('#pjRadio, #pfRadio').on('change', controleExibicaoCamposFornecedor);
    $('#indicadorIE').on('change', atualizarCampoInscricaoEstadual);
});