@extends('adminlte::page')

@section('title', 'Fornecedor - Visualizar')

@section('content_header')
    <div class="d-flex flex-row align-items-center "><h1>Fornecedor </h1><small class="ml-3"> Visualizar #{{ $fornecedor->id }}</small></div>
@endsection

@section('content')
    
    <div class="accordion" id="cadastroFornecedorAccordion">

        
        <div class="card">
            <div class="d-flex justify-content-between p-3 align-items-center card-toggle" 
                data-toggle="collapse" data-target="#collapseFornecedor" 
                aria-expanded="false" aria-controls="collapseFornecedor" style="cursor: pointer;">
                <h3 class="card-title mb-0">Dados do Fornecedor</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" aria-label="Toggle">
                        <i class="fas fa-minus"></i> 
                    </button>
                </div>
            </div>

            <div id="collapseFornecedor" class="collapse show">
                <div class="card-body">
                    @php
                        $pjData = $fornecedor->pessoaJuridica;
                        $pfData = $fornecedor->pessoaFisica;
                        $enderecoData = $fornecedor->endereco;
                        $readOnlyAttr = 'readonly';
                        $disabledAttr = 'disabled';
                    @endphp

                    <div class="mb-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" id="pjRadio" name="tipoPessoa" value="PJ" 
                                @checked($fornecedor->tipo_pessoa == 'PJ') {{ $disabledAttr }}>
                            <label for="pjRadio" class="custom-control-label">Pessoa Jurídica</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" id="pfRadio" name="tipoPessoa" value="PF" 
                                @checked($fornecedor->tipo_pessoa == 'PF') {{ $disabledAttr }}>
                            <label for="pfRadio" class="custom-control-label">Pessoa Física</label>
                        </div>
                    </div>

                    <div id="campos-pj" @if($fornecedor->tipo_pessoa == 'PF') style="display: none;" @endif>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="cnpj">CNPJ<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj" 
                                    value="{{ $pjData->cnpj ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="razaoSocial">Razão Social<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="razaoSocial" name="razao_social" 
                                    value="{{ $pjData->razao_social ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nomeFantasia">Nome Fantasia<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="nomeFantasia" name="nome_fantasia" 
                                    value="{{ $pjData->nome_fantasia ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="indicadorIE">Indicador de Inscrição Estadual<span style="color:red">*</span></label>
                                <select id="indicadorIE" class="form-control" name="indicador_ie" {{ $disabledAttr }}>
                                    @php $ie = $pjData->indicador_ie ?? ''; @endphp
                                    <option value="Selecione" @selected($ie == '')>Selecione</option>
                                    <option value="contribuinte" @selected($ie == 'contribuinte')>Contribuinte</option>
                                    <option value="contribuinte_isento" @selected($ie == 'contribuinte_isento')>Contribuinte Isento</option>
                                    <option value="nao_contribuinte" @selected($ie == 'nao_contribuinte')>Não Contribuinte</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ie">Inscrição Estadual<span id='label_inscricao_estadual' style="color:red"></span></label>
                                <input type="text" class="form-control" id="ie" name="inscricao_estadual" 
                                    value="{{ $pjData->inscricao_estadual ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="im">Inscrição Municipal</label>
                                <input type="text" class="form-control" id="im" name="inscricao_municipal" 
                                    value="{{ $pjData->inscricao_municipal ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="situacaoCnpj">Situação CNPJ</label>
                                <input type="text" class="form-control" id="situacaoCnpj" name="situacao_cnpj" disabled 
                                    value="{{ $pjData->situacao_cnpj ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="recolhimento">Recolhimento<span style="color:red">*</span></label>
                                <select id="recolhimento" class="form-control" name="recolhimento" {{ $disabledAttr }}>
                                    @php $recolhimento = $pjData->recolhimento ?? ''; @endphp
                                    
                                    <option value="Selecione" @selected($recolhimento == '')>Selecione</option>
                                    <option value="recolher" @selected($recolhimento == 'recolher')>A Recolher pelo Prestador</option>
                                    <option value="retido" @selected($recolhimento == 'retido')>Retido pelo Tomador</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="ativoPJ">Ativo<span style="color:red">*</span></label>
                                <select id="ativoPJ" class="form-control" name="ativo_pj" {{ $disabledAttr }}>
                                    @php $ativo = $pjData->ativo ?? 1; @endphp 
                                    <option value="Selecione" @selected($ativo === null)>Selecione</option>
                                    <option value="1" @selected($ativo == 1)>Sim</option>
                                    <option value="0" @selected($ativo == 0)>Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div id="campos-pf" @if($fornecedor->tipo_pessoa == 'PJ') style="display: none;" @endif>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="cpf">CPF<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="cpf" name="cpf" 
                                    value="{{ $pfData->cpf ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nomePF">Nome<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="nomePF" name="nome_pf" 
                                    value="{{ $pfData->nome ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="apelido">Apelido</label>
                                <input type="text" class="form-control" id="apelido" name="apelido" 
                                    value="{{ $pfData->apelido ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="rg">RG<span style="color:red">*</span></label>
                                <input type="text" class="form-control" id="rg" name="rg" 
                                    value="{{ $pfData->rg ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ativoPF">Ativo<span style="color:red">*</span></label>
                                <select id="ativoPF" class="form-control" name="ativo_pf" {{ $disabledAttr }}>
                                    @php $ativo = $pfData->ativo ?? 1; @endphp {{-- Assume 1 se for PF --}}
                                    <option value="Selecione" @selected($ativo === null)>Selecione</option>
                                    <option value="1" @selected($ativo == 1)>Sim</option>
                                    <option value="0" @selected($ativo == 0)>Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="d-flex justify-content-between p-3 align-items-center card-toggle" data-toggle="collapse" data-target="#collapseContatoPrincipal" aria-expanded="false" aria-controls="collapseContatoPrincipal" style="cursor: pointer;">
                <h3 class="card-title mb-0">Contato Principal</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            @php
                $contatosPrincipais = $fornecedor->contatos->where('principal', true);

                $telefone = $contatosPrincipais->where('tipo_contato', 'telefone')->first();
                $email = $contatosPrincipais->where('tipo_contato', 'email')->first();

                $tel = $telefone->contato ?? '';
                $tipoTel = $telefone->tipo_contato ?? '';
                $rotuloTel = $telefone->rotulo ?? '';

                $emailContato = $email->contato ?? '';
                $tipoEmail = $email->tipo_contato ?? '';
                $rotuloEmail = $email->rotulo ?? '';
            @endphp
            
            <div id="collapseContatoPrincipal" class="collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="telefone">Telefone<span style="color:red">*</span></label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" 
                                value="{{ $tel }}" {{ $readOnlyAttr }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tipo<span style="color:red">*</span></label>
                            <select id="tipo_telefone" class="form-control" name="tipo_telefone" {{ $disabledAttr }}>
                                <option value="Selecione" @selected($rotuloTel == 'Selecione')>Selecione</option>
                                <option value="residencial" @selected($rotuloTel == 'residencial')>Residencial</option>
                                <option value="comercial" @selected($rotuloTel == 'comercial')>Comercial</option> 
                                <option value="celular" @selected($rotuloTel == 'celular')>Celular</option> 
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="{{ $emailContato }}" {{ $readOnlyAttr }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tipo</label>
                            <select id="tipo_email" class="form-control" name="tipo_email" {{ $disabledAttr }}>
                                <option value="Selecione" @selected($rotuloEmail == 'Selecione')>Selecione</option>
                                <option value="pessoal" @selected($rotuloEmail == 'pessoal')>Pessoal</option>
                                <option value="comercial" @selected($rotuloEmail == 'comercial')>Comercial</option> 
                                <option value="outro" @selected($rotuloEmail == 'outro')>Outro</option> 
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="d-flex justify-content-between p-3 align-items-center card-toggle" data-toggle="collapse" data-target="#collapseContatosAdicionais" aria-expanded="true"
                aria-controls="collapseContatosAdicionais" style="cursor: pointer;">
                <h3 class="card-title mb-0">Contatos Adicionais</h3>
                <button type="button" class="btn btn-tool">
                    <i class="fas fa-minus"></i>
                </button>
            </div>

            <div id="collapseContatosAdicionais" class="collapse show">
                
                <div class="card-body" id="contatos-container">
                    @php 
                        $contatosAdicionais = $fornecedor->contatos->where('principal', false);
                        // Agrupa por nome/cargo/empresa — facilita exibir telefone e email do mesmo contato
                        $contatosAgrupados = $contatosAdicionais->groupBy(function ($contato) {
                            return ($contato->nome ?? '') . '|' . ($contato->empresa ?? '') . '|' . ($contato->cargo ?? '');
                        });
                    @endphp

                    @if($contatosAdicionais->isEmpty())
                        <p class="text-center">Não há contatos adicionais</p>
                    @else
                        @foreach($contatosAgrupados as $index => $grupo)
                            @php
                                $contatoTelefone = $grupo->firstWhere('tipo_contato', 'telefone');
                                $contatoEmail = $grupo->firstWhere('tipo_contato', 'email');
                                [$nome, $empresa, $cargo] = explode('|', $index);
                            @endphp

                            <div class="contato-item border rounded p-3 mb-3" data-index="{{ $loop->index }}">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" value="{{ $nome ?: '' }}" {{ $readOnlyAttr }}>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Empresa</label>
                                        <input type="text" class="form-control" value="{{ $empresa ?: '' }}" {{ $readOnlyAttr }}>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Cargo</label>
                                        <input type="text" class="form-control" value="{{ $cargo ?: '' }}" {{ $readOnlyAttr }}>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control" value="{{ $contatoTelefone->contato ?? '' }}" {{ $readOnlyAttr }}>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Tipo</label>
                                        <input type="text" class="form-control" value="{{ $contatoTelefone->rotulo ?? '' }}" {{ $readOnlyAttr }}>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>E-mail</label>
                                        <input type="text" class="form-control" value="{{ $contatoEmail->contato ?? '' }}" {{ $readOnlyAttr }}>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Tipo</label>
                                        <input type="text" class="form-control" value="{{ $contatoEmail->rotulo ?? '' }}" {{ $readOnlyAttr }}>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>

        <div class="card">
            <div class="d-flex justify-content-between p-3 align-items-center card-toggle" 
                data-toggle="collapse" data-target="#collapseEndereco" 
                aria-expanded="false" aria-controls="collapseEndereco" style="cursor: pointer;">
                <h3 class="card-title mb-0">Dados de Endereço</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" aria-label="Toggle">
                        <i class="fas fa-minus"></i> 
                    </button>
                </div>
            </div>

            <div id="collapseEndereco" class="collapse show">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="cep">CEP<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="cep" name="endereco_cep" 
                                value="{{ $enderecoData->cep ?? '' }}" {{ $readOnlyAttr }}>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="logradouro">Logradouro<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="logradouro" name="endereco_logradouro" 
                                value="{{ $enderecoData->logradouro ?? '' }}" {{ $readOnlyAttr }}>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="numero">Número<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="numero" name="endereco_numero" 
                                value="{{ $enderecoData->numero ?? '' }}" {{ $readOnlyAttr }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="endereco_complemento" 
                                value="{{ $enderecoData->complemento ?? '' }}" {{ $readOnlyAttr }}>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="bairro">Bairro<span style="color: red">*</span></label>
                            <input type="text" class="form-control" id="bairro" name="endereco_bairro" 
                                value="{{ $enderecoData->bairro ?? '' }}" {{ $readOnlyAttr }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="pontoReferencia">Ponto de Referência</label>
                            <input type="text" class="form-control" id="pontoReferencia" name="endereco_ponto_referencia" 
                                value="{{ $enderecoData->ponto_referencia ?? '' }}" {{ $readOnlyAttr }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="uf">UF<span style="color: red">*</span></label>
                            <select id="uf" class="form-control select2" name="endereco_uf" {{ $disabledAttr }}>
                                <option value="Selecione">Selecione</option>
                                @foreach ($estados as $estado)
                                     <option value="{{ $estado->uf }}" @selected(($enderecoData->estado->uf ?? '') == $estado->uf)>
                                        {{ $estado->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cidade">Cidade<span style="color: red">*</span></label>
                            <select id="cidade" class="form-control select2" name="endereco_cidade" {{ $disabledAttr }}>
                                @php 
                                    $cidadeAtual = $enderecoData->cidade ?? null;
                                @endphp
                                @if($cidadeAtual)
                                    <option value="{{ $cidadeAtual->codigo_ibge }}" selected>{{ $cidadeAtual->nome }}</option>
                                @else
                                    <option value="Selecione" selected>Selecione</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="condominio">Condomínio?<span style="color: red">*</span></label>
                            <select id="condominio" class="form-control" name="condominio_sim_nao" {{ $disabledAttr }}>
                                @php $cond = $enderecoData->condominio_sn ?? ''; @endphp
                                <option value="Selecione" @selected($cond == '')>Selecione</option>
                                <option value="Sim" @selected($cond == 'Sim')>Sim</option>
                                <option value="Não" @selected($cond == 'Não')>Não</option>
                            </select>
                        </div>
                        
                        <div id="campos-condominio" class="row col-md-9 m-0 p-0" @if(($enderecoData->condominio_sn ?? '') != 'Sim') style="display: none;" @endif>
                            <div class="form-group col-md-5">
                                <label for="enderecoCondominio">Endereço<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="enderecoCondominio" name="condominio_endereco" 
                                    value="{{ $enderecoData->condominio_endereco ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="numeroCondominio">Número<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="numeroCondominio" name="condominio_numero" 
                                    value="{{ $enderecoData->condominio_numero ?? '' }}" {{ $readOnlyAttr }}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="d-flex justify-content-between p-3 align-items-center card-toggle" data-toggle="collapse" data-target="#collapseObservacao" aria-expanded="false" aria-controls="collapseObservacao" style="cursor: pointer;">
                <h3 class="card-title mb-0">Observações</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div id="collapseObservacao" class="collapse show">
                <div class="card-body">
                    <textarea id="observacaoEditor" name="observacao" class="form-control" rows="8" {{ $readOnlyAttr }}>{{ $fornecedor->observacao ?? '' }}</textarea>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-3 mb-4">
        <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
        <a href="{{ route('fornecedores.index') }}" class="btn btn-secondary ml-2">Voltar para a lista</a>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#observacaoEditor').summernote({
                toolbar: [], 
                disableDragAndDrop: true
            }).summernote('disable');

            $('.select2').each(function() {
                $(this).select2({
                    theme: 'bootstrap4',
                    disabled: true 
                });
            });
        });
    </script>
@endsection

@section('footer')
    <div class="text-center text-muted py-2">
        Dashboard 2025
    </div>
@endsection