<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Mockando fornecedores para testar o dataTable
        $fornecedores = [
            [
                'id' => 1,
                'razao_social' => 'Vercan Tecnologia LTDA',
                'fantasia' => 'Vercan',
                'cnpj' => '12.345.678/0001-90',
                'ativo' => true
            ],
            [
                'id' => 2,
                'razao_social' => 'Alfa Distribuidora',
                'fantasia' => 'Alfa',
                'cnpj' => '98.765.432/0001-00',
                'ativo' => false
            ]
        ];

        return view('fornecedores.index', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   

        $estados = Estado::orderBy('nome')->get();
        return view('fornecedores.cadastrar', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
