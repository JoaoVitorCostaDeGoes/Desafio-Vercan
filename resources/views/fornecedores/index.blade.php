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
                    <td>{{ $fornecedor['razao_social'] }}</td>
                    <td>{{ $fornecedor['fantasia'] }}</td>
                    <td>{{ $fornecedor['cnpj'] }}</td>
                    <td>
                        @if($fornecedor['ativo'])
                            <span class="font-weight-bold">Sim</span>
                        @else
                            <span >Não</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('fornecedores.show', $fornecedor['id']) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection

@section('js')
    <script src="{{ asset('assets/js/fornecedores.js') }}"></script>
@endsection

@section('footer')
    <div class="text-center text-muted py-2">
        Dashboard 2025
    </div>
@endsection
