//Mock de testes de Estado
const estados = [
    { id: 'AC', text: 'Acre' }, { id: 'AL', text: 'Alagoas' }, { id: 'AP', text: 'Amapá' },
    { id: 'AM', text: 'Amazonas' }, { id: 'BA', text: 'Bahia' }, { id: 'CE', text: 'Ceará' },
    { id: 'DF', text: 'Distrito Federal' }, { id: 'ES', text: 'Espírito Santo' }, { id: 'GO', text: 'Goiás' },
    { id: 'MA', text: 'Maranhão' }, { id: 'MT', text: 'Mato Grosso' }, { id: 'MS', text: 'Mato Grosso do Sul' },
    { id: 'MG', text: 'Minas Gerais' }, { id: 'PA', text: 'Pará' }, { id: 'PB', text: 'Paraíba' },
    { id: 'PR', text: 'Paraná' }, { id: 'PE', text: 'Pernambuco' }, { id: 'PI', text: 'Piauí' },
    { id: 'RJ', text: 'Rio de Janeiro' }, { id: 'RN', text: 'Rio Grande do Norte' }, { id: 'RS', text: 'Rio Grande do Sul' },
    { id: 'RO', text: 'Rondônia' }, { id: 'RR', text: 'Roraima' }, { id: 'SC', text: 'Santa Catarina' },
    { id: 'SP', text: 'São Paulo' }, { id: 'SE', text: 'Sergipe' }, { id: 'TO', text: 'Tocantins' }
];

function buscarCEP() {
    let cep = $('#cep').val().replace(/\D/g, '');
    if (cep.length != 8) {
        return;
    }
    $('#logradouro').val('...');
    $('#bairro').val('...');
    $('#cidade').val('').attr('disabled', true); 
    $('#uf').val('').trigger('change');

    $.ajax({
        url: 'https://viacep.com.br/ws/' + cep + '/json/',
        dataType: 'json',
        success: function(data) {
            if (!("erro" in data)) {
                $('#logradouro').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#uf').val(data.uf).trigger('change'); 
                setTimeout(function() {
                    $('#cidade').val(data.localidade).attr('disabled', false).trigger('change');
                    $('#numero').focus();
                }, 500);
            } else {
                alert("CEP não encontrado.");
            }
        }
    });
}

function controleExibicaoCamposFornecedor(){
    const pjRadio = $('#pjRadio');
    const camposPj = $('#campos-pj');
    const camposPf = $('#campos-pf');

    if(pjRadio.is(':checked')){
        camposPf.hide();
        camposPj.show();
    }else{
        camposPj.hide();
        camposPf.show();
    }
}

function controleExibicaoCamposCondominio() {
    const valor = $('#condominio').val();
    const campos = $('#campos-condominio');

    if (valor === 'Sim') {
        campos.show();
        campos.removeClass('col-md-12').addClass('col-md-9'); 
        $('#enderecoCondominio').attr('required', 'required');
        $('#numeroCondominio').attr('required', 'required');
    } else {
        campos.hide();
        $('#enderecoCondominio').removeAttr('required');
        $('#numeroCondominio').removeAttr('required');
        $('#enderecoCondominio').val('');
        $('#numeroCondominio').val('');
    }
}

function aplicarMascaras() {
    $('#cnpj').mask('00.000.000/0000-00');
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-00009');
    $('#cep').mask('00000-000');
}

function atualizarCampoInscricaoEstadual() {
    const indicadorSelect = $("#indicadorIE");
    const inscricaoInput = $("#ie");
    const spanLabel = $("#label_inscricao_estadual");
    const valor = indicadorSelect.val();

    if (valor === "nao_contribuinte" || valor === "Selecione") {
        inscricaoInput.prop("readonly", true);
        inscricaoInput.removeAttr("required");
        spanLabel.html("");
    } else {
        inscricaoInput.prop("readonly", false);
        inscricaoInput.attr("required", "required");
        spanLabel.html("*");
        spanLabel.css("color", "red");
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
    configurarUFAndCidades();
    controleExibicaoCamposFornecedor();
    inicializarSummernote();

    $('#pjRadio, #pfRadio').on('change', controleExibicaoCamposFornecedor);
    $('#indicadorIE').on('change', atualizarCampoInscricaoEstadual);
    $('#condominio').on('change', controleExibicaoCamposCondominio);
    $('#cep').on('blur', buscarCEP);
});


// Bloco de Observacoes e LiB de Formatacao
function inicializarSummernote() {
    $('#observacaoEditor').summernote({
        height: 200, 
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']], 
            ['para', ['ul', 'ol', 'paragraph']],
            ['undo', ['undo', 'redo']] 
        ]
    });
}

// Função MOCK: Simula a busca de cidades no backend
function mockCidades(uf) {
    if (uf === 'SP') {
        return [{ id: 'SaoPaulo', text: 'São Paulo' }, { id: 'Campinas', text: 'Campinas' }];
    } else if (uf === 'RJ') {
        return [{ id: 'RioJaneiro', text: 'Rio de Janeiro' }, { id: 'Niteroi', text: 'Niterói' }];
    } else {
        return [{ id: uf + 'Cidade1', text: 'Cidade ' + uf + ' 1' }];
    }
}

function configurarUFAndCidades() {
    $('#uf').select2({
        data: estados,
        placeholder: "Selecione a UF",
        theme: "bootstrap4" 
    });

    $('#uf').on('change', function() {
        const ufSelecionada = $(this).val();
        const cidadeSelect = $('#cidade');
        cidadeSelect.empty().append('<option value="">Carregando...</option>').attr('disabled', true);

        if (ufSelecionada) {
            setTimeout(function() {
                const cidadesMock = mockCidades(ufSelecionada); 
                cidadeSelect.empty().append('<option value="">Selecione</option>');
                cidadesMock.forEach(c => cidadeSelect.append(new Option(c.text, c.id)));
                cidadeSelect.attr('disabled', false);
            }, 300); 
        } else {
            cidadeSelect.empty().append('<option value="">Selecione</option>');
        }
    });
}