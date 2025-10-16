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



// funcoes de validar todos os campos
function validarParaEnviar(event) {
    event.preventDefault(); 
    const formularioValido = validarFormulario();
    if (formularioValido)
        $('form').submit(); 
}

function marcarErroEFoco(campo, collapseId, messagemErro) {
    const $campo = $(campo);

    $campo.addClass('is-invalid');
    $(collapseId).collapse('show');

    $campo.focus();

    Swal.fire({
        icon: 'warning', 
        title: 'Campo Obrigatório',
        text: messagemErro,
        toast: true,           
        position: 'top-end',   
        showConfirmButton: false, 
        timer: 4000,           
        timerProgressBar: true
    });
}

function validarFormulario() {
    $('input, select').removeClass('is-invalid');
    console.log('eee')
    let isValid = true; 

    const PjSelecionado = $('#pjRadio').is(':checked');
    const collapseFornecedorId = '#collapseFornecedor';

    if (PjSelecionado) {
        const cnpj = $('#cnpj').val();
        if (!cnpj || !validarCNPJ(cnpj)) {
            marcarErroEFoco('#cnpj', collapseFornecedorId, 'CNPJ deve ser preenchido ou está inválido');
            isValid = false;
        } else if (!$('#razaoSocial').val()) {
            marcarErroEFoco('#razaoSocial', collapseFornecedorId, 'Razao Social deve ser preenchido!');
            isValid = false;
        } else if (!$('#nomeFantasia').val()) {
            marcarErroEFoco('#nomeFantasia', collapseFornecedorId, 'Nome Fantasia deve ser preenchido!');
            isValid = false;
        } else if ($('#indicadorIE').val() === 'Selecione') {
             marcarErroEFoco('#indicadorIE', collapseFornecedorId, 'Escolha uma opção válida!');
             isValid = false;
        } else if ($('#indicadorIE').val() !== 'nao_contribuinte' && !$('#ie').val()) {
            marcarErroEFoco('#ie', collapseFornecedorId,'Inscrição Estadual deve ser preenchido!');
            isValid = false;
        } else if ($('#recolhimento').val() === 'Selecione') {
             marcarErroEFoco('#recolhimento', collapseFornecedorId, 'Escolha uma opção válida!');
             isValid = false;
        } else if ($('#ativoPJ').val() === 'Selecione') {
             marcarErroEFoco('#ativoPJ', collapseFornecedorId, 'Escolha uma opção válida!');
             isValid = false;
        }
        
    } else { 
        const cpf = $('#cpf').val();
        if (!cpf || !validarCPF(cpf)) {
            marcarErroEFoco('#cpf', collapseFornecedorId,'CPF vazio ou inválido!');
            isValid = false;
        } else if (!$('#nomePF').val()) {
            marcarErroEFoco('#nomePF', collapseFornecedorId, 'Nome deve ser preenchido!');
            isValid = false;
        } else if (!$('#rg').val()) {
            marcarErroEFoco('#rg', collapseFornecedorId, 'RG deve ser preenchido!');
            isValid = false;
        } else if ($('#ativoPF').val() === 'Selecione') {
             marcarErroEFoco('#ativoPF', collapseFornecedorId, 'Escolha uma opção válida!');
             isValid = false;
        }
    }
    
    if (!isValid) return false; 

    const collapseContatoId = '#collapseContatoPrincipal';
    const email = $('#email').val();
    
    console.log($('#tipo_telefone').val())
    if (!$('#telefone').val()) {
        marcarErroEFoco('#telefone', collapseContatoId, 'Telefone deve ser preenchido!');
        isValid = false;
    } else if ($('#tipo_telefone').val() == 'Selecione') {
        marcarErroEFoco('#tipo_telefone', collapseContatoId, 'Escolha uma opção válida!');
        isValid = false;
    } else if (email && !validarEmail(email)) { 
        marcarErroEFoco('#email', collapseContatoId, 'Email está fora do padrão esperado!');
        isValid = false;
    }
    
    if (!isValid) return false; 

    const collapseEnderecoId = '#collapseEndereco';
    
    const camposObrigatoriosEndereco = [
        { id: '#cep', name: 'CEP' },
        { id: '#logradouro', name: 'Logradouro' },
        { id: '#numero', name: 'Número' },
        { id: '#bairro', name: 'Bairro' },
        { id: '#uf', name: 'UF' },
        { id: '#cidade', name: 'Cidade' },
        { id: '#condominio', name: 'Condominio' }
    ];
    
    for (let campo of camposObrigatoriosEndereco) {
        if ($(campo.id).val() === '' || $(campo.id).val() === 'Selecione') {
            marcarErroEFoco(campo.id, collapseEnderecoId, `Faça o preenchimento correto do campo ${campo.name}!`);
            isValid = false;
            break;
        }
    }
    
    if (!isValid) return false; 
    
    if ($('#condominio').val() === 'Sim') {
        if (!$('#enderecoCondominio').val()) {
            marcarErroEFoco('#enderecoCondominio', collapseEnderecoId, 'Endereço não pode ser vazio!');
            isValid = false;
        } else if (!$('#numeroCondominio').val()) {
            marcarErroEFoco('#numeroCondominio', collapseEnderecoId, 'Número não pode ser vazio!');
            isValid = false;
        }
    }
    
    if (!isValid) return false;

    return true; 
}

// funcoes de validacao de dados como cpf, email e cnpj
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');
    if(cpf == '') return false;
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf.substring(0,9).split('').every((digit, i) => digit == cpf[0] && i < 9)) 
        return false;
    
    let add = 0;
    for (let i=0; i < 9; i ++) add += parseInt(cpf.charAt(i)) * (10 - i);
    let rev = 11 - (add % 11);
    if (rev == 10 || rev == 11) rev = 0;
    if (rev != parseInt(cpf.charAt(9))) return false;
    
    add = 0;
    for (let i = 0; i < 10; i ++) add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11) rev = 0;
    if (rev != parseInt(cpf.charAt(10))) return false;
    
    return true;
}

function validarCNPJ(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g,'');
    if(cnpj == '') return false;
    if (cnpj.length != 14 ||
        cnpj == "00000000000000" || 
        cnpj.substring(0,12).split('').every((digit, i) => digit == cnpj[0] && i < 12)) 
        return false;
    
    let tamanho = cnpj.length - 2;
    let numeros = cnpj.substring(0,tamanho);
    let digitos = cnpj.substring(tamanho);
    let soma = 0;
    let pos = tamanho - 7;
    for (let i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) pos = 9;
    }
    let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) return false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (let i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1)) return false;
    
    return true;
}

function validarEmail(email) {
    if (!email) return true; 
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}
