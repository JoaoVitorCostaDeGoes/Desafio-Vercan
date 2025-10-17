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

    public function index()
    {
        $fornecedores = Fornecedor::with(['pessoaFisica', 'pessoaJuridica'])->WhereNull('deleted_at')->get()->toArray();
       

        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create()
    {   

        $estados = Estado::orderBy('nome')->get();
        return view('fornecedores.cadastrar', compact('estados'));
    }

    
    public function store(StoreFornecedorRequest $request)
    {
        $dadosValidados = array_merge($request->all(), $request->validated());

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

    public function edit($fornecedor_id)
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
            
            return view('fornecedores.edit', array_merge($this->carregarEstados(), [
                'fornecedor' => $fornecedor,
                'cidades' => $cidades,
            ]));

        }catch(Exception $e){
            return response()->json(['error' => 'Erro ao buscar fornecedor: ' . $e->getMessage()], 500);
        }
    }

    public function update(StoreFornecedorRequest $request, int $id_fornecedor) 
    {
        DB::beginTransaction();

        $fornecedor = Fornecedor::find($id_fornecedor);

        try {
            
            $fornecedor->update([
                'tipo_pessoa' => $request->input('tipoPessoa'),
                'observacao' => $request->input('observacao'),
            ]);
            
            $this->atualizarDadosPessoa($request, $fornecedor);
            $this->atualizarEndereco($request, $fornecedor);
            $this->atualizarContatosPrincipais($request, $fornecedor);
            $this->sincronizarContatosAdicionais($request, $fornecedor);

            DB::commit();

            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');

        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withInput()->withErrors(['message' => 'Erro interno ao salvar alterações.']);
        }
    }

    public function destroy($fornecedor_id)
    {   
        try {
            $fornecedor = Fornecedor::with(['pessoaJuridica', 'pessoaFisica', 'contatos', 'endereco'])
                                    ->findOrFail($fornecedor_id);

            if ($fornecedor->pessoaJuridica) {
                $fornecedor->pessoaJuridica->delete();
            }

            if ($fornecedor->pessoaFisica) {
                $fornecedor->pessoaFisica->delete();
            }

            if ($fornecedor->endereco) {
                $fornecedor->endereco->delete();
            }

            if ($fornecedor->contatos->isNotEmpty()) {
                foreach ($fornecedor->contatos as $contato) {
                    $contato->delete();
                }
            }

            $fornecedor->delete();

            return response()->json(['success' => 'Fornecedor excluído com sucesso.']);

        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao excluir fornecedor: ' . $e->getMessage()], 500);
        }
}

    // funcoes auxiliares para criacao dos fornecedores
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

        $contatos[] = [
            'fornecedor_id' => $fornecedor->id,
            'nome' => null,
            'cargo' => null,
            'empresa' => null,
            'contato' => $data['telefone'],
            'tipo_contato' => 'telefone',
            'rotulo' => $data['tipo_telefone'],
            'principal' => true,
        ];
        
        if (!empty($data['email'])) {
            $contatos[] = [
                'fornecedor_id' => $fornecedor->id,
                'nome' => null,
                'cargo' => null,
                'empresa' => null,
                'contato' => $data['email'],
                'tipo_contato' => 'email',
                'rotulo' => $data['tipo_email'],
                'principal' => true,
            ];
        }

        if (!empty($data['contatos_adicionais'])) {
        
            foreach ($data['contatos_adicionais'] as $contatoAdicional) {
                if (!empty($contatoAdicional['telefone_adicional'])) {
                    $contatos[] = [
                        'fornecedor_id' => $fornecedor->id,
                        'nome' => $contatoAdicional['nome_adicional'] ?? null,
                        'cargo' => $contatoAdicional['cargo_adicional'] ?? null,
                        'empresa' => $contatoAdicional['empresa_adicional'] ?? null,
                        'contato' => $contatoAdicional['telefone_adicional'],
                        'tipo_contato' => 'telefone',
                        'rotulo' => $contatoAdicional['tipo_telefone_adicional'] ?? 'Adicional',
                        'principal' => false,
                    ];
                }
        
                if (!empty($contatoAdicional['email_adicional'])) {
                    $contatos[] = [
                        'fornecedor_id' => $fornecedor->id,
                        'nome' => $contatoAdicional['nome_adicional'] ?? null,
                        'cargo' => $contatoAdicional['cargo_adicional'] ?? null,
                        'empresa' => $contatoAdicional['empresa_adicional'] ?? null,
                        'contato' => $contatoAdicional['email_adicional'],
                        'tipo_contato' => 'email',
                        'rotulo' => $contatoAdicional['tipo_email_adicional'] ?? 'Adicional',
                        'principal' => false,
                    ];
                }
            }
        }
        
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


    //funcoes auxiliares para realizar o update/atulaizacao dos dados
    private function atualizarDadosPessoa($request, Fornecedor $fornecedor)
    {
        $fornecedorIdKey = 'fornecedor_id'; 
        
        if ($request->input('tipoPessoa') === 'PJ') {
            FornecedorPj::updateOrCreate(
                [$fornecedorIdKey => $fornecedor->id],
                [
                    'cnpj' => $request->input('cnpj'),
                    'razao_social' => $request->input('razao_social'),
                    'nome_fantasia' => $request->input('nome_fantasia'),
                    'indicador_ie' => $request->input('indicador_ie'),
                    'inscricao_estadual' => $request->input('inscricao_estadual'),
                    'inscricao_municipal' => $request->input('inscricao_municipal'),
                    'recolhimento' => $request->input('recolhimento'),
                    'ativo' => $request->input('ativo_pj', 0), 
                ]
            );

            FornecedorPf::where($fornecedorIdKey, $fornecedor->id)->delete();
        } elseif ($request->input('tipoPessoa') === 'PF') {
            FornecedorPf::updateOrCreate(
                [$fornecedorIdKey => $fornecedor->id], 
                [
                    'cpf' => $request->input('cpf'),
                    'nome' => $request->input('nome_pf'),
                    'apelido' => $request->input('apelido'),
                    'rg' => $request->input('rg'),
                    'ativo' => $request->input('ativo_pf', 0),
                ]
            );

            FornecedorPj::where($fornecedorIdKey, $fornecedor->id)->delete();
        }
    }

    private function atualizarEndereco($request, Fornecedor $fornecedor)
    {
        
        $fornecedorIdKey = 'fornecedor_id';
        
        Endereco::updateOrCreate(
            [$fornecedorIdKey => $fornecedor->id], 
            [
                'cep' => $request->input('endereco_cep'),
                'logradouro' => $request->input('endereco_logradouro'),
                'numero' => $request->input('endereco_numero'),
                'bairro' => $request->input('endereco_bairro'),
                'estado_id' => $request->input('estado_id'),
                'cidade_id' => $request->input('cidade_id'),
                'condominio_sn' => $request->input('condominio_sim_nao'),
                'condominio_endereco' => $request->input('condominio_endereco'),
                'condominio_numero' => $request->input('condominio_numero'),
                'complemento' => $request->input('endereco_complemento'), 
                'ponto_referencia' => $request->input('endereco_ponto_referencia'),
            ]
        );
    }

    /**
     * Atualiza o Telefone e Email principal.
     */
    private function atualizarContatosPrincipais($request, Fornecedor $fornecedor)
    {
       
        Contato::updateOrCreate(
            ['fornecedor_id' => $fornecedor->id, 'tipo_contato' => 'telefone', 'principal' => true],
            [
                'contato' => $request->input('telefone'),
                'rotulo' => $request->input('tipo_telefone'),
                'principal' => true,
            ]
        );
        
        if ($request->filled('email')) {
             Contato::updateOrCreate(
                ['fornecedor_id' => $fornecedor->id, 'tipo_contato' => 'email', 'principal' => true],
                [
                    'contato' => $request->input('email'),
                    'rotulo' => 'principal', 
                    'principal' => true,
                ]
            );
        } else {
            $fornecedor->contatos()
                ->where('principal', true)
                ->where('tipo_contato', 'email')
                ->delete();
        }
    }

    private function sincronizarContatosAdicionais($request, Fornecedor $fornecedor)
    {
        $novosContatos = $request->input('contatos_adicionais') ?? [];

        $fornecedor->contatos()->where('principal', false)->delete();
        
        foreach ($novosContatos as $contatoData) {
            
            // Garante que pelo menos um campo de contato está preenchido
            if (empty($contatoData['telefone_adicional']) && empty($contatoData['email_adicional'])) {
                continue;
            }

            $nome = $contatoData['nome_adicional'] ?? null;
            $cargo = $contatoData['cargo_adicional'] ?? null;
            $empresa = $contatoData['empresa_adicional'] ?? null; 

            if (!empty($contatoData['telefone_adicional'])) {
                $fornecedor->contatos()->create([
                    'tipo_contato' => 'telefone',
                    'contato' => $contatoData['telefone_adicional'],
                    'rotulo' => $contatoData['tipo_telefone_adicional'] ?? 'celular', 
                    'nome' => $nome,
                    'cargo' => $cargo,
                    'empresa' => $empresa,
                    'principal' => false
                ]);
            }

            if (!empty($contatoData['email_adicional'])) {
                $fornecedor->contatos()->create([
                    'tipo_contato' => 'email',
                    'contato' => $contatoData['email_adicional'],
                    'rotulo' => $contatoData['tipo_email_adicional'] ?? 'pessoal',
                    'nome' => $nome,
                    'cargo' => $cargo,
                    'empresa' => $empresa,
                    'principal' => false
                ]);
            }
        }
    }
}


