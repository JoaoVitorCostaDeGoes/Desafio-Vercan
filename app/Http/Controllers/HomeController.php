<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Models\Estado;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function buscarCidades($uf){
        $estadoSelecionado = Estado::where('uf', $uf)
                                        ->value('id');

        $cidadesDoEstado = Cidade::where('estado_id', $estadoSelecionado)
                                    ->orderBy('nome', 'asc')
                                    ->get();
        
        return response()->json($cidadesDoEstado);
    }
}
