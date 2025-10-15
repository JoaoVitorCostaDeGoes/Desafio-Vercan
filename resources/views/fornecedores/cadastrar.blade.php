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
                <div class="d-flex justify-content-between p-3 align-items-center card-toggle" data-toggle="collapse" data-target="#collapseFornecedor" aria-expanded="false" aria-controls="collapseFornecedor" style="cursor: pointer;">
                    <h3 class="card-title mb-0">Dados do Fornecedor</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="collapseFornecedor" class="collapse">
                    <div class="card-body">Conteudo dos dados de fornecedor...</div>
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

                <div id="collapseObservacao" class="collapse">
                    <div class="card-body">Conteúdo das observações... </div>
                </div>
            </div>

        </div>

        <div class="mt-3 mb-4">
            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Cadastrar</button>
        </div>
    </form>
@endsection

@section('js')
    <script>
    $(document).ready(function () {
        // Controlar a mudanca de icone dos cards conforme expansao do acordeon
        $('.collapse').on('show.bs.collapse', function () {
            $(this).prev('.card-toggle').find('.btn-tool i').removeClass('fa-plus').addClass('fa-minus');
        });

        $('.collapse').on('hide.bs.collapse', function () {
            $(this).prev('.card-toggle').find('.btn-tool i').removeClass('fa-minus').addClass('fa-plus');
        });
    });
    </script>
@endsection
