<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use App\Http\Controllers\Controller;
use App\Models\Cidade;
use App\Models\Contato;
use App\Models\Endereco;
use App\Models\Estado;
use App\Models\Fornecedor;
use App\Models\FornecedorPf;
use App\Models\FornecedorPj;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FornecedorController extends Controller
{

    protected function carregarEstados()
    {
        return [
            'estados' => Estado::orderBy('nome')->get(),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fornecedores = Fornecedor::with(['pessoaFisica', 'pessoaJuridica'])->WhereNull('deleted_at')->get()->toArray();
       

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
    public function store(StoreFornecedorRequest $request)
    {
        $dadosValidados = $request->validated();

        DB::beginTransaction();

        try {
            $fornecedor = Fornecedor::create([
                'tipo_pessoa' => $dadosValidados['tipoPessoa'],
                'observacao' => $dadosValidados['observacao'] ?? null,
            ]);

            if ($dadosValidados['tipoPessoa'] === 'PJ') {
                $this->createPessoaJuridica($fornecedor, $dadosValidados);
            } else {
                $this->createPessoaFisica($fornecedor, $dadosValidados);
            }

            $this->createContatos($fornecedor, $dadosValidados);

            $this->createEndereco($fornecedor, $dadosValidados);

            DB::commit();

            return redirect()
                ->route('fornecedores.index')
                ->with('success', 'Fornecedor cadastrado com sucesso! ID: ' . $fornecedor->id);

        } catch (\Exception $e) {
            DB::rollBack();

            dd($e);

            return back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar fornecedor. Tente novamente, verifique todos os campos!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($fornecedor_id)
    {

        try{

            $fornecedor = Fornecedor::find($fornecedor_id);
            $fornecedor->load([
                'pessoaJuridica', 
                'pessoaFisica', 
                'endereco.estado', 
                'endereco.cidade', 
                'contatos'
            ]);
    
            $cidades = [];
            if ($fornecedor->endereco && $fornecedor->endereco->estado_id) {
                $cidades = Cidade::where('estado_id', $fornecedor->endereco->estado_id)->get();
            }
            
            return view('fornecedores.show', array_merge($this->carregarEstados(), [
                'fornecedor' => $fornecedor,
                'cidades' => $cidades,
            ]));

        }catch(Exception $e){
            return response()->json(['error' => 'Erro ao buscar fornecedor: ' . $e->getMessage()], 500);
        }

        

        
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
    public function destroy($fornecedor_id)
    {   
        try{

            $fornecedor = Fornecedor::findOrFail($fornecedor_id);
            $fornecedor->delete();

            return response()->json(['success' => 'Fornecedor excluído com sucesso.']);

        }catch(Exception $e){
            return response()->json(['error' => 'Erro ao excluir fornecedor: ' . $e->getMessage()], 500);
        }
        
    }



    // funcoes auxiliares
    protected function createPessoaJuridica(Fornecedor $fornecedor, array $data): void
    {
        FornecedorPj::create([
            'fornecedor_id' => $fornecedor->id,
            'cnpj' => $data['cnpj'],
            'razao_social' => $data['razao_social'],
            'nome_fantasia' => $data['nome_fantasia'],
            'indicador_ie' => $data['indicador_ie'],
            'inscricao_estadual' => $data['inscricao_estadual'] ?? null,
            'inscricao_municipal' => $data['inscricao_municipal'] ?? null,
            'situacao_cnpj' => $data['situacao_cnpj'] ?? null,
            'recolhimento' => $data['recolhimento'],
            'ativo' => $data['ativo_pj'] ?? true,
        ]);
    }

    
    protected function createPessoaFisica(Fornecedor $fornecedor, array $data): void
    {
        FornecedorPf::create([
            'fornecedor_id' => $fornecedor->id,
            'cpf' => $data['cpf'],
            'nome' => $data['nome_pf'],
            'apelido' => $data['apelido'] ?? null,
            'rg' => $data['rg'],
            'ativo' => $data['ativo_pf'] ?? true,
        ]);
    }

    protected function createContatos(Fornecedor $fornecedor, array $data): void
    {
        $contatos = [];
        dd($data);

        // 4.1. Contato Principal (Telefone)
        $contatos[] = [
            'fornecedor_id' => $fornecedor->id,
            'contato' => $data['telefone'],
            'tipo_contato' => 'telefone',
            'rotulo' => $data['tipo_telefone'],
            'principal' => true,
        ];
        
        // 4.2. Contato Principal (E-mail)
        if (!empty($data['email'])) {
            $contatos[] = [
                'fornecedor_id' => $fornecedor->id,
                'contato' => $data['email'],
                'tipo_contato' => 'email',
                'rotulo' =>  $data['tipo_email'],
                'principal' => true,
            ];
        }

        // 4.3. Contatos Adicionais
        if (!empty($data['contatos_adicionais'])) {
            foreach ($data['contatos_adicionais'] as $contatoAdicional) {
                // Tenta determinar o tipo do contato (simplificado)
                $tipo = filter_var($contatoAdicional['valor'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';

                $contatos[] = [
                    'fornecedor_id' => $fornecedor->id,
                    'contato' => $contatoAdicional['valor'],
                    'tipo_contato' => $tipo,
                    'rotulo' => $contatoAdicional['rotulo'] ?? 'Adicional',
                    'principal' => false,
                ];
            }
        }
        
        // Inserção em massa na tabela contatos
        Contato::insert($contatos); 
    }

    protected function createEndereco(Fornecedor $fornecedor, array $data): void
    {
        Endereco::create([
            'fornecedor_id' => $fornecedor->id,
            'cep' => $data['endereco_cep'],
            'logradouro' => $data['endereco_logradouro'],
            'numero' => $data['endereco_numero'],
            'bairro' => $data['endereco_bairro'],
            'ponto_referencia' => $data['endereco_ponto_referencia'] ?? null,
            'estado_id' => $data['estado_id'],
            'complemento'=> $data['endereco_complemento'] ?? null,
            'cidade_id' => $data['cidade_id'],
            'condominio_sn' => $data['condominio_sim_nao'],
            'condominio_endereco' => $data['condominio_endereco'] ?? null,
            'condominio_numero' => $data['condominio_numero'] ?? null,
        ]);
    }
}
