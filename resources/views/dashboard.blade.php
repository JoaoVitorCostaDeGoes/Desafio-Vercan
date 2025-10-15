@extends('adminlte::page')

@section('title', 'Dashboard')

@section(section: 'content_header')
    <div class="d-flex flex-row align-items-center "><h1>Dashboard </h1><small class="ml-3"> Painel de Controle</small></div>
@endsection

@section('content')

    <div class="alert alert-warning d-flex align-items-center">
        <i class="icon fa fa-bullhorn mr-2"></i>
        Diariamente as informações contidas neste sistema são apagadas.
    </div>

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between  mb-3">
                <h4> Olá Candidato, bem vindo ao Desafio VERCAN</h4>
                <span> Hoje é {{ now()->format('d/m/Y') }}</span>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4">
                    <h6 class="font-weight-bold"> Suporte </h6>
                    <p class="mb-1">Celular: (19) 9 9820-4361</p>
                    <p class="mb-1">Celular: (19) 9 9612-4430</p>
                    <p class="mb-0">E-mail: <a href="mailto:suporte@vercan.com.br">suporte@vercan.com.br</a></p>
                </div>

                <div class="col-md-4">
                    <h6 class="font-weight-bold"> Endereço </h6>
                    <p class="mb-1">Rua Dr. Benigno Ribeiro, 176</p>
                    <p class="mb-1">Bairro: São Bernardo</p>
                    <p class="mb-0">Campinas - São Paulo</p>
                </div>
                
                <div class="col-md-4">
                    <h6 class="font-weight-bold"> Mais Informações</h6>
                    <p class="mb-1">Telefone: (19) 3291-0004</p>
                    <p class="mb-1">E-mail: <a href="mailto:contato@vercan.com.br">contato@vercan.com.br</a></p>
                </div>
            </div>

            <hr>

            <p class="mb-0"> Vercan Tecnologia</p>

        </div>
    </div>

@endsection

@section('footer')
    <div class="text-center text-muted py-2">
        Dashboard 2025
    </div>
@endsection
