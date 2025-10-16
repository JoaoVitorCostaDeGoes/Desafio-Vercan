@extends('adminlte::page')

@section('title', 'Fornecedores')

@section(section: 'content_header')
    <div class="d-flex flex-row align-items-center "><h1>Fornecedores </h1><small class="ml-3"> Painel de Controle</small></div>
@endsection

@section('content')
    <div class="mb-3 text-right">
        <a href="{{ route('fornecedores.create') }}" class="btn btn-success px-3"><i class="mx-1 fas fa-plus"></i>Cadastrar</a>
    </div>

    <table id="tabela-fornecedores" class="table table-striped">
        <thead>
            <tr>
                <th> Razão Social/ Nome</th>
                <th> Nome Fantasia/ Apelido</th>
                <th> CNPJ/ CPF</th>
                <th> Ativo</th>
                <th> Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fornecedores as $fornecedor)
                <tr>
                    @if($fornecedor['tipo_pessoa'] == 'PF')
                        <td>{{ $fornecedor['pessoa_fisica']['nome'] }}</td>
                        <td>{{ $fornecedor['pessoa_fisica']['apelido'] }}</td>
                        <td>{{ $fornecedor['pessoa_fisica']['cpf'] }}</td>

                        @if($fornecedor['pessoa_fisica']['ativo'])
                            <td><span class="font-weight-bold">Sim</span></td>
                        @else
                            <td><span >Não</span></td>
                        @endif

                    @else
                        <td>{{ $fornecedor['pessoa_juridica']['razao_social'] }}</td>
                        <td>{{ $fornecedor['pessoa_juridica']['fantasia'] }}</td>
                        <td>{{ $fornecedor['pessoa_juridica']['cnpj'] }}</td>

                        @if($fornecedor['pessoa_juridica']['ativo'])
                            <td><span class="font-weight-bold">Sim</span></td>
                        @else
                            <td><span >Não</span></td>
                        @endif
                    @endif
                    <td class="text-center">
                        <a href="{{ route('fornecedores.show', $fornecedor['id']) }}" class="btn btn-sm btn-info" title="Ver Detalhes">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <a href="{{ route('fornecedores.edit', $fornecedor['id']) }}" class="btn btn-sm btn-warning" title="Editar Fornecedor">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <button class="btn btn-sm btn-danger delete-fornecedor" data-id="{{ $fornecedor['id'] }}" title="Excluir Fornecedor">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>

                    <form id="delete-form-{{ $fornecedor['id'] }}" action="{{ route('fornecedores.destroy', $fornecedor['id']) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/fornecedores.js') }}"></script>
@endsection

@section('footer')
    <div class="text-center text-muted py-2">
        Dashboard 2025
    </div>
@endsection
