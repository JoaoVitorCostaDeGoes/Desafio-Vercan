@extends('adminlte::page')

@section('title', 'Fornecedor')

@section(section: 'content_header')
    <div class="d-flex flex-row align-items-center "><h1>Fornecedor </h1><small class="ml-3"> Cadastrar</small></div>
@endsection

@section('content')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form action="/dashboard/fornecedores" method="POST">
        @csrf
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
                        
                        <div class="mb-4">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" id="pjRadio" name="tipoPessoa" value="PJ"
                                    {{ old('tipoPessoa', 'PJ') == 'PJ' ? 'checked' : '' }}>
                                <label for="pjRadio" class="custom-control-label">Pessoa Jurídica</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" id="pfRadio" name="tipoPessoa" value="PF"
                                    {{ old('tipoPessoa', 'PF') == 'PF' ? 'checked' : '' }}>
                                <label for="pfRadio" class="custom-control-label">Pessoa Física</label>
                            </div>
                        </div>

                        <div id="campos-pj">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cnpj">CNPJ<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="cnpj" required name="cnpj" placeholder="" value="{{ old('cnpj') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="razaoSocial">Razão Social<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="razaoSocial" required name="razao_social" placeholder="" value="{{ old('razao_social') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nomeFantasia">Nome Fantasia<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="nomeFantasia" required name="nome_fantasia" placeholder="" value="{{ old(key: 'nome_fantasia') }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="indicadorIE">Indicador de Inscrição Estadual<span style="color:red">*</span></label>
                                    <select id="indicadorIE" class="form-control" required name="indicador_ie">
                                        <option value="Selecione" selected {{ old('indicador_ie') == 'Selecione' ? 'selected' : '' }}>Selecione</option>
                                        <option value="contribuinte" {{ old('indicador_ie') == 'contribuinte' ? 'selected' : '' }}>Contribuinte</option>
                                        <option value="contribuinte_isento" {{ old('indicador_ie') == 'contribuinte_isento' ? 'selected' : '' }}>Contribuinte Isento</option>
                                        <option value="nao_contribuinte" {{ old('indicador_ie') == 'nao_contribuinte' ? 'selected' : '' }}>Não Contribuinte</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ie">Inscrição Estadual<span id='label_inscricao_estadual' style="color:red"></span></label>
                                    <input type="text" class="form-control" id="ie" readonly name="inscricao_estadual" placeholder="" value="{{ old('inscricao_estadual') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="im">Inscrição Municipal</label>
                                    <input type="text" class="form-control" id="im" name="inscricao_municipal" placeholder="" value="{{ old('inscricao_municipal') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="situacaoCnpj">Situação CNPJ</label>
                                    <input type="text" class="form-control" id="situacaoCnpj" name="situacao_cnpj" readonly placeholder="" value="{{ old('situacao_cnpj') }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="recolhimento">Recolhimento<span style="color:red">*</span></label>
                                    <select id="recolhimento" class="form-control" required name="recolhimento">
                                        <option value="Selecione" {{ old('Selecione') == 'Selecione' ? 'selected' : '' }}>Selecione</option>
                                        <option value="recolher" {{ old('recolher') == 'recolher' ? 'selected' : '' }} selected>A Recolher pelo Prestador</option>
                                        <option value="retido" {{ old('retido') == 'retido' ? 'selected' : '' }}>Retido pelo Tomador</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ativoPJ">Ativo<span style="color:red">*</span></label>
                                    <select id="ativoPJ" class="form-control" required name="ativo_pj">
                                        <option  value="Selecione" {{ old('ativo_pj') == 'Selecione' ? 'selected' : '' }}>Selecione</option>
                                        <option value="1" {{ old('ativo_pj') == '1' ? 'selected' : '' }} selected>Sim</option>
                                        <option value="0" {{ old('ativo_pj') == '0' ? 'selected' : '' }}>Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div id="campos-pf" style="display: none;"> 
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cpf">CPF<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="" value="{{ old('cpf') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nomePF">Nome<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="nomePF" name="nome_pf" placeholder="" value="{{ old('nome_pf') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="apelido">Apelido</label>
                                    <input type="text" class="form-control" id="apelido" name="apelido" placeholder="" value="{{ old('apelido') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="rg">RG<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="rg" name="rg" placeholder="" value="{{ old('rg') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ativoPF">Ativo<span style="color:red">*</span></label>
                                    <select id="ativoPF" class="form-control" name="ativo_pf">
                                        <option value="Selecione" {{ old('ativo_pf') == 'Selecione' ? 'selected' : '' }}>Selecione</option>
                                        <option value="1" {{ old('ativo_pf') == '1' ? 'selected' : '' }} selected>Sim</option>
                                        <option value="0" {{ old('ativo_pf') == '0' ? 'selected' : '' }}>Não</option>
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

                <div id="collapseContatoPrincipal" class="collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="telefone">Telefone<span style="color:red">*</span></label>
                                <input type="tel" class="form-control" id="telefone" required name="telefone" placeholder="" value="{{ old('telefone') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tipo<span style="color:red">*</span></label>
                                <select id="tipo_telefone" class="form-control" name="tipo_telefone">
                                    <option value="Selecione" {{ old('tipo_telefone') == 'Selecione' ? 'selected' : '' }} selected>Selecione</option>
                                    <option value="residencial" {{ old('tipo_telefone') == 'residencial' ? 'selected' : '' }} >Residencial</option>
                                    <option value="comercial" {{ old('tipo_telefone') == 'comercial' ? 'selected' : '' }}>Comercial</option> 
                                    <option value="celular" {{ old('tipo_telefone') == 'celular' ? 'selected' : '' }}>Celular</option> 
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" required name="email" placeholder="" value="{{ old('email') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tipo</label>
                                <select id="tipo_email" class="form-control" name="tipo_email">
                                    <option value="Selecione" {{ old('tipo_email') == 'Selecione' ? 'selected' : '' }} selected>Selecione</option>
                                    <option value="pessoal" {{ old('tipo_email') == 'pessoal' ? 'selected' : '' }} >Pessoal</option>
                                    <option value="comercial" {{ old('tipo_email') == 'comercial' ? 'selected' : '' }}>Comercial</option> 
                                    <option value="outro" {{ old('tipo_email') == 'outro' ? 'selected' : '' }}>Outro</option> 
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
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-link pr-5" id="adicionar-contato">ADICIONAR</button>
                    </div>
                    
                    <div class="card-body" id="contatos-container">
                        <p id="nao_existe_contatos_adicionais" class="text-center"> Não Há Contatos Adicionais </p>
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
                                <input type="text" class="form-control" id="cep" name="endereco_cep" placeholder="" value="{{ old('endereco_cep') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="logradouro">Logradouro<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="logradouro" name="endereco_logradouro" placeholder="" value="{{ old('endereco_logradouro') }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="numero">Número<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="numero" name="endereco_numero" placeholder="" value="{{ old('endereco_numero') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="complemento">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="endereco_complemento" placeholder="" value="{{ old('endereco_complemento') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="bairro">Bairro<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="bairro" name="endereco_bairro" placeholder="" value="{{ old('endereco_bairro') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pontoReferencia">Ponto de Referência</label>
                                <input type="text" class="form-control" id="pontoReferencia" name="endereco_ponto_referencia" placeholder="" value="{{ old('endereco_ponto_referencia') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="uf">UF<span style="color: red">*</span></label>
                                <select id="uf" class="form-control select2" name="endereco_uf">
                                    <option value="Selecione">Selecione</option>
                                    @foreach ($estados as $estado)
                                         <option value="{{ $estado->uf }}" {{ old('endereco_uf') == $estado->uf ? 'selected' : '' }}>{{ $estado->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cidade">Cidade<span style="color: red">*</span></label>
                                <select id="cidade" class="form-control select2" name="endereco_cidade" disabled>
                                    <option value="Selecione">Selecione</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="condominio">Condomínio?<span style="color: red">*</span></label>
                                <select id="condominio" class="form-control" name="condominio_sim_nao">
                                    <option value="Selecione"  {{ old('condominio_sim_nao') == 'Selecione' ? 'selected' : '' }} >Selecione</option>
                                    <option value="Sim"  {{ old('condominio_sim_nao') == 'Sim' ? 'selected' : '' }} >Sim</option>
                                    <option value="Não"  {{ old('condominio_sim_nao') == 'Não' ? 'selected' : '' }} >Não</option>
                                </select>
                            </div>
                            
                            <div id="campos-condominio" class="row col-md-9 m-0 p-0" style="display: none;">
                                <div class="form-group col-md-5">
                                    <label for="enderecoCondominio">Endereço<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="enderecoCondominio" name="condominio_endereco" placeholder="" value="{{ old('condominio_endereco') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numeroCondominio">Número<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="numeroCondominio" name="condominio_numero" placeholder="" value="{{ old('condominio_numero') }}">
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
                        
                        <textarea id="observacaoEditor" name="observacao" class="form-control" rows="8">{{ old('observacao') }}</textarea>
                        
                        </div>
                </div>
            </div>

        </div>

        <div class="mt-3 mb-4">
            <button type="button" class="btn btn-success" onclick="validarParaEnviar(event)"><i class="fas fa-plus"></i> Cadastrar</button>
        </div>
    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/cadastrar_fornecedor.js') }}"></script>
@endsection

@section('footer')
    <div class="text-center text-muted py-2">
        Dashboard 2025
    </div>
@endsection
