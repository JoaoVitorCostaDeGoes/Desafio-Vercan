@extends('adminlte::page')

@section('title', 'Fornecedor - Editar')

@section('content_header')
    <div class="d-flex flex-row align-items-center "><h1>Fornecedor </h1><small class="ml-3"> Editar #{{ $fornecedor->id }}</small></div>
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

    <form action="{{ route('fornecedores.update', $fornecedor->id) }}" method="POST">
        @csrf
        @method('PUT')
        
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
                            $tipoPessoa = old('tipoPessoa', $fornecedor->tipo_pessoa);
                        @endphp

                        <div class="mb-4">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" id="pjRadio" name="tipoPessoa" value="PJ" 
                                    @checked($tipoPessoa == 'PJ')>
                                <label for="pjRadio" class="custom-control-label">Pessoa Jurídica</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" id="pfRadio" name="tipoPessoa" value="PF" 
                                    @checked($tipoPessoa == 'PF')>
                                <label for="pfRadio" class="custom-control-label">Pessoa Física</label>
                            </div>
                        </div>

                        <div id="campos-pj" @if($tipoPessoa == 'PF') style="display: none;" @endif>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cnpj">CNPJ<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="cnpj" required name="cnpj" 
                                        value="{{ old('cnpj', $pjData->cnpj ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="razaoSocial">Razão Social<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="razaoSocial" required name="razao_social" 
                                        value="{{ old('razao_social', $pjData->razao_social ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nomeFantasia">Nome Fantasia<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="nomeFantasia" required name="nome_fantasia" 
                                        value="{{ old('nome_fantasia', $pjData->nome_fantasia ?? '') }}" placeholder="">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="indicadorIE">Indicador de Inscrição Estadual<span style="color:red">*</span></label>
                                    <select id="indicadorIE" class="form-control" required name="indicador_ie">
                                        @php $ie = old('indicador_ie', $pjData->indicador_ie ?? ''); @endphp
                                        <option value="Selecione" @selected($ie == 'Selecione' || $ie == '')>Selecione</option>
                                        <option value="contribuinte" @selected($ie == 'contribuinte')>Contribuinte</option>
                                        <option value="contribuinte_isento" @selected($ie == 'contribuinte_isento')>Contribuinte Isento</option>
                                        <option value="nao_contribuinte" @selected($ie == 'nao_contribuinte')>Não Contribuinte</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ie">Inscrição Estadual<span id='label_inscricao_estadual' style="color:red"></span></label>
                                    <input type="text" class="form-control" id="ie" readonly name="inscricao_estadual" 
                                        value="{{ old('inscricao_estadual', $pjData->inscricao_estadual ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="im">Inscrição Municipal</label>
                                    <input type="text" class="form-control" id="im" name="inscricao_municipal" 
                                        value="{{ old('inscricao_municipal', $pjData->inscricao_municipal ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="situacaoCnpj">Situação CNPJ</label>
                                    <input type="text" class="form-control" id="situacaoCnpj" name="situacao_cnpj" disabled 
                                        value="{{ $pjData->situacao_cnpj ?? '' }}" placeholder="">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="recolhimento">Recolhimento<span style="color:red">*</span></label>
                                    <select id="recolhimento" class="form-control" required name="recolhimento">
                                        @php $recolhimento = old('recolhimento', $fornecedor->recolhimento ?? ''); @endphp
                                        <option value="Selecione" @selected($recolhimento == 'Selecione' || $recolhimento == '')>Selecione</option>
                                        <option value="recolher" @selected($recolhimento == 'recolher')>A Recolher pelo Prestador</option>
                                        <option value="retido" @selected($recolhimento == 'retido')>Retido pelo Tomador</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ativoPJ">Ativo<span style="color:red">*</span></label>
                                    <select id="ativoPJ" class="form-control" required name="ativo_pj">
                                        @php $ativo = old('ativo_pj', $fornecedor->ativo ?? 1); @endphp 
                                        <option value="Selecione" @selected($ativo === null)>Selecione</option>
                                        <option value="1" @selected($ativo == 1)>Sim</option>
                                        <option value="0" @selected($ativo == 0)>Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div id="campos-pf" @if($tipoPessoa == 'PJ') style="display: none;" @endif> 
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cpf">CPF<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" 
                                        value="{{ old('cpf', $pfData->cpf ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nomePF">Nome<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="nomePF" name="nome_pf" 
                                        value="{{ old('nome_pf', $pfData->nome ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="apelido">Apelido</label>
                                    <input type="text" class="form-control" id="apelido" name="apelido" 
                                        value="{{ old('apelido', $pfData->apelido ?? '') }}" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="rg">RG<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="rg" name="rg" 
                                        value="{{ old('rg', $pfData->rg ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ativoPF">Ativo<span style="color:red">*</span></label>
                                    <select id="ativoPF" class="form-control" name="ativo_pf">
                                        @php $ativo = old('ativo_pf', $fornecedor->ativo ?? 1); @endphp
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
                                <input type="tel" class="form-control" id="telefone" required name="telefone" 
                                    value="{{ $tel }}" placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tipo<span style="color:red">*</span></label>
                                <select id="tipo_telefone" class="form-control" name="tipo_telefone">
                                    <option value="Selecione" @selected($rotuloTel == 'Selecione' || $rotuloTel == '')>Selecione</option>
                                    <option value="residencial" @selected($rotuloTel == 'residencial')>Residencial</option>
                                    <option value="comercial" @selected($rotuloTel == 'comercial')>Comercial</option> 
                                    <option value="celular" @selected($rotuloTel == 'celular')>Celular</option> 
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" required name="email" 
                                    value="{{ $emailContato }}" placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Tipo</label>
                                <select id="tipo_email" class="form-control" name="tipo_email">
                                    <option value="Selecione" @selected($rotuloEmail == 'Selecione' || $rotuloEmail == '')>Selecione</option>
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
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-link pr-5" id="adicionar-contato">ADICIONAR</button>
                    </div>
                    
                    <div class="card-body" id="contatos-container">
                        @php 
                            $contatosAdicionais = $fornecedor->contatos->where('principal', false);
                        @endphp

                        @if($contatosAdicionais->isEmpty() && !old('contatos'))
                            <p id="nao_existe_contatos_adicionais" class="text-center"> Não Há Contatos Adicionais </p>
                        @else
                            
                            @php 
                                $contatosToDisplay = old('contatos') ?? $contatosAdicionais;
                            @endphp

                            @foreach($contatosToDisplay as $index => $contato)
                                @php
                                    
                                    $contatoTel = is_array($contato) ? $contato['telefone'] : $contato->telefone;
                                    $contatoTipoTel = is_array($contato) ? $contato['tipo_telefone'] : $contato->tipo_telefone;
                                    $contatoEmail = is_array($contato) ? $contato['email'] : $contato->email;
                                    $contatoTipoEmail = is_array($contato) ? $contato['tipo_email'] : $contato->tipo_email;
                                @endphp
                                <div class="row border-bottom pb-3 mb-3 contato-adicional-item" data-index="{{ $index }}">
                                    <input type="hidden" name="contatos[{{ $index }}][telefone]" value="{{ $contatoTel }}">
                                    <input type="hidden" name="contatos[{{ $index }}][tipo_telefone]" value="{{ $contatoTipoTel }}">
                                    <input type="hidden" name="contatos[{{ $index }}][email]" value="{{ $contatoEmail }}">
                                    <input type="hidden" name="contatos[{{ $index }}][tipo_email]" value="{{ $contatoTipoEmail }}">

                                    <div class="form-group col-md-3">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control" value="{{ $contatoTel }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Tipo</label>
                                        <input type="text" class="form-control" value="{{ $contatoTipoTel }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="{{ $contatoEmail }}" readonly>
                                    </div>
                                    <div class="form-group col-md-3 d-flex align-items-center justify-content-end">
                                        <button type="button" class="btn btn-danger btn-sm remover-contato" data-index="{{ $index }}">Remover</button>
                                    </div>
                                </div>
                            @endforeach
                            <p id="nao_existe_contatos_adicionais" class="text-center" style="display: none;"> Não Há Contatos Adicionais </p>
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
                                <input type="text" class="form-control" id="cep" name="endereco_cep" required 
                                    value="{{ old('endereco_cep', $enderecoData->cep ?? '') }}" placeholder="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="logradouro">Logradouro<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="logradouro" name="endereco_logradouro" required 
                                    value="{{ old('endereco_logradouro', $enderecoData->logradouro ?? '') }}" placeholder="">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="numero">Número<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="numero" name="endereco_numero" required 
                                    value="{{ old('endereco_numero', $enderecoData->numero ?? '') }}" placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="complemento">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="endereco_complemento" 
                                    value="{{ old('endereco_complemento', $enderecoData->complemento ?? '') }}" placeholder="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="bairro">Bairro<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="bairro" name="endereco_bairro" required 
                                    value="{{ old('endereco_bairro', $enderecoData->bairro ?? '') }}" placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pontoReferencia">Ponto de Referência</label>
                                <input type="text" class="form-control" id="pontoReferencia" name="endereco_ponto_referencia" 
                                    value="{{ old('endereco_ponto_referencia', $enderecoData->ponto_referencia ?? '') }}" placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="uf">UF<span style="color: red">*</span></label>
                                <select id="uf" class="form-control select2" name="endereco_uf" required>
                                    @php $ufSelected = old('endereco_uf', $enderecoData->estado->uf ?? ''); @endphp
                                    <option value="Selecione" @selected($ufSelected == 'Selecione' || $ufSelected == '')>Selecione</option>
                                    @foreach ($estados as $estado)
                                         <option value="{{ $estado->uf }}" @selected($ufSelected == $estado->uf)>{{ $estado->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cidade">Cidade<span style="color: red">*</span></label>
                                {{-- A lista de cidades será carregada via JS ou virá pré-preenchida pelo Controller --}}
                                <select id="cidade" class="form-control select2" name="endereco_cidade" required @disabled(!old('endereco_uf', $enderecoData->estado->uf ?? ''))>
                                    @php 
                                        $cidadeIdSelected = old('endereco_cidade', $enderecoData->cidade_id ?? '');
                                    @endphp
                                    <option value="">Selecione</option>
                                    
                                    {{-- Se o Controller passou as cidades para a view (Método Edit) --}}
                                    @if(isset($cidades) && !empty($cidades))
                                        @foreach($cidades as $cidade)
                                            <option value="{{ $cidade->id }}" @selected($cidadeIdSelected == $cidade->id)>{{ $cidade->nome }}</option>
                                        @endforeach
                                    {{-- Se houver old() (erro de validação), apenas carrega a cidade selecionada para não dar erro --}}
                                    @elseif($cidadeIdSelected)
                                        <option value="{{ $cidadeIdSelected }}" selected>ID {{ $cidadeIdSelected }} (Aguardando JS)</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="condominio">Condomínio?<span style="color: red">*</span></label>
                                <select id="condominio" class="form-control" name="condominio_sim_nao" required>
                                    @php $cond = old('condominio_sim_nao', $enderecoData->condominio_sn ?? ''); @endphp
                                    <option value="Selecione" @selected($cond == 'Selecione' || $cond == '')>Selecione</option>
                                    <option value="Sim" @selected($cond == 'Sim')>Sim</option>
                                    <option value="Não" @selected($cond == 'Não')>Não</option>
                                </select>
                            </div>
                            
                            <div id="campos-condominio" class="row col-md-9 m-0 p-0" @if(old('condominio_sim_nao', $enderecoData->condominio_sn ?? '') != 'Sim') style="display: none;" @endif>
                                <div class="form-group col-md-5">
                                    <label for="enderecoCondominio">Endereço<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="enderecoCondominio" name="condominio_endereco" 
                                        value="{{ old('condominio_endereco', $enderecoData->condominio_endereco ?? '') }}" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="numeroCondominio">Número<span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="numeroCondominio" name="condominio_numero" 
                                        value="{{ old('condominio_numero', $enderecoData->condominio_numero ?? '') }}" placeholder="">
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
                        <textarea id="observacaoEditor" name="observacao" class="form-control" rows="8">{{ old('observacao', $fornecedor->observacao ?? '') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-3 mb-4">
            <button type="submit" class="btn btn-warning" onclick="validarParaEnviar(event)"><i class="fas fa-save"></i> Salvar Alterações</button>
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
    {{-- ASSUMA QUE SEU JS EXISTENTE TAMBÉM TRATA DE PREENCHER OS CAMPOS VIA AJAX (CEP, CIDADES) --}}
    <script src="{{ asset('assets/js/cadastrar_fornecedor.js') }}"></script> 
@endsection

@section('footer')
    <div class="text-center text-muted py-2">
        Dashboard 2025
    </div>
@endsection