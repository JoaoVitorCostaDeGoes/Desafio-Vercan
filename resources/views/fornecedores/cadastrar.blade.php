@extends('adminlte::page')

@section('title', 'Fornecedor')

@section(section: 'content_header')
    <div class="d-flex flex-row align-items-center "><h1>Fornecedor </h1><small class="ml-3"> Cadastrar</small></div>
@endsection

@section('content')
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
                            <i class="fas fa-plus"></i> 
                        </button>
                    </div>
                </div>

                <div id="collapseFornecedor" class="collapse show">
                    <div class="card-body">
                        
                        <div class="mb-4">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" id="pjRadio" name="tipoPessoa" value="PJ" checked>
                                <label for="pjRadio" class="custom-control-label">Pessoa Jurídica</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" id="pfRadio" name="tipoPessoa" value="PF">
                                <label for="pfRadio" class="custom-control-label">Pessoa Física</label>
                            </div>
                        </div>

                        <div id="campos-pj">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cnpj">CNPJ<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="cnpj" required name="cnpj" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="razaoSocial">Razão Social<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="razaoSocial" required name="razao_social" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nomeFantasia">Nome Fantasia<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="nomeFantasia" required name="nome_fantasia" placeholder="">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="indicadorIE">Indicador de Inscrição Estadual<span style="color:red">*</span></label>
                                    <select id="indicadorIE" class="form-control" required name="indicador_ie">
                                        <option selected>Selecione</option>
                                        <option value="contribuinte">Contribuinte</option>
                                        <option value="contribuinte_isento">Contribuinte Isento</option>
                                        <option value="nao_contribuinte">Não Contribuinte</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ie">Inscrição Estadual<span id='label_inscricao_estadual' style="color:red"></span></label>
                                    <input type="text" class="form-control" id="ie" readonly name="inscricao_estadual" placeholder="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="im">Inscrição Municipal</label>
                                    <input type="text" class="form-control" id="im" name="inscricao_municipal" placeholder="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="situacaoCnpj">Situação CNPJ</label>
                                    <input type="text" class="form-control" id="situacaoCnpj" name="situacao_cnpj" disabled placeholder="">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="recolhimento">Recolhimento<span style="color:red">*</span></label>
                                    <select id="recolhimento" class="form-control" required name="recolhimento">
                                        <option>Selecione</option>
                                        <option value="recolher" selected>A Recolher pelo Prestador</option>
                                        <option value="retido">Retido pelo Tomador</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="ativoPJ">Ativo<span style="color:red">*</span></label>
                                    <select id="ativoPJ" class="form-control" required name="ativo_pj">
                                        <option >Selecione</option>
                                        <option value="1" selected>Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div id="campos-pf" style="display: none;"> 
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cpf">CPF<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nomePF">Nome<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="nomePF" name="nome_pf" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="apelido">Apelido</label>
                                    <input type="text" class="form-control" id="apelido" name="apelido" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="rg">RG<span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="rg" name="rg" placeholder="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ativoPF">Ativo<span style="color:red">*</span></label>
                                    <select id="ativoPF" class="form-control" name="ativo_pf">
                                        <option >Selecione</option>
                                        <option value="1" selected>Sim</option>
                                        <option value="0">Não</option>
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
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="collapseContatoPrincipal" class="collapse">
                    <div class="card-body">Conteúdo do bloco de contato ...</div>
                </div>
            </div>

            <div class="card">
                <div class="d-flex justify-content-between p-3 align-items-center card-toggle" data-toggle="collapse" data-target="#collapseContatosAdicionais" aria-expanded="false" aria-controls="collapseContatosAdicionais" style="cursor: pointer;">
                    <h3 class="card-title mb-0">Contatos Adicionais</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="collapseContatosAdicionais" class="collapse">
                    <div class="card-body">Conteúdo dos contatos adicionais...</div>
                </div>
            </div>

            <div class="card">
                <div class="d-flex justify-content-between p-3 align-items-center card-toggle" data-toggle="collapse" data-target="#collapseEndereco" aria-expanded="false" aria-controls="collapseEndereco" style="cursor: pointer;">
                    <h3 class="card-title mb-0">Dados do Endereço</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="collapseEndereco" class="collapse">
                    <div class="card-body">Conteúdo do endereço...</div>
                </div>
            </div>

            <div class="card">
                <div class="d-flex justify-content-between p-3 align-items-center card-toggle" data-toggle="collapse" data-target="#collapseObservacao" aria-expanded="false" aria-controls="collapseObservacao" style="cursor: pointer;">
                    <h3 class="card-title mb-0">Observações</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="collapseObservacao" class="collapse show">
                    <div class="card-body">
                        
                        <textarea id="observacaoEditor" name="observacao" class="form-control" rows="8"></textarea>
                        
                        </div>
                </div>
            </div>

        </div>

        <div class="mt-3 mb-4">
            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Cadastrar</button>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('assets/js/cadastrar_fornecedor.js') }}"></script>
@endsection

@section('footer')
    <div class="text-center text-muted py-2">
        Dashboard 2025
    </div>
@endsection
