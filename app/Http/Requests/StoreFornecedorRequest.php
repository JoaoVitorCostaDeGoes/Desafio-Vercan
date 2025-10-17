<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Estado;
use App\Models\Cidade;

class StoreFornecedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tipoPessoa = $this->input('tipoPessoa'); 

        $rules = [
            'tipoPessoa' => ['required', Rule::in(['PJ', 'PF'])],
            'observacao' => ['nullable', 'string'],

            // Contato Principal ( Obrigatório )
            'telefone'      => ['required', 'string', 'max:20'],
            'tipo_telefone' => ['required', 'string', 'max:50'], 
            'email'         => ['nullable', 'email', 'max:255'],
            
            // Contatos Adicionais 
            'contatos_adicionais' => ['nullable', 'array'],
            'contatos_adicionais.*.valor' => ['required', 'string'],
            'contatos_adicionais.*.rotulo' => ['nullable', 'string', 'max:50'],

            // Endereço
            'endereco_cep'       => ['required', 'string', 'max:10'],
            'endereco_logradouro'=> ['required', 'string', 'max:255'],
            'endereco_numero'    => ['required', 'string', 'max:20'],
            'endereco_bairro'    => ['required', 'string', 'max:100'],
            'estado_id'          => ['required', 'exists:estados,id'], 
            'cidade_id'          => ['required', 'exists:cidades,id'],
            'condominio_sim_nao' => ['required', Rule::in(['Sim', 'Não'])],
            
            // Regras condominios
            'condominio_endereco'=> ['required_if:condominio_sim_nao,Sim', 'nullable', 'string', 'max:255'],
            'condominio_numero'  => ['required_if:condominio_sim_nao,Sim', 'nullable', 'string', 'max:20'],
        ];

        if ($tipoPessoa === 'PJ') {
            $rules['cnpj']                 = ['required', 'string', 'max:18', 'unique:fornecedor_pj,cnpj'];
            $rules['razao_social']         = ['required', 'string', 'max:255'];
            $rules['nome_fantasia']        = ['required', 'string', 'max:255'];
            $rules['indicador_ie']         = ['required', Rule::in(['contribuinte', 'isento', 'nao_contribuinte'])];
            $rules['inscricao_estadual']   = ['nullable', 'string', 'max:50'];
            $rules['recolhimento']         = ['required', Rule::in(['recolher', 'retido'])];
            $rules['ativo_pj']             = ['boolean'];
        }

        if ($tipoPessoa === 'PF') {
            $rules['cpf']    = ['required', 'string', 'max:14', 'unique:fornecedor_pf,cpf'];
            $rules['nome_pf'] = ['required', 'string', 'max:255'];
            $rules['rg']     = ['required', 'string', 'max:50'];
            $rules['ativo_pf'] = ['boolean'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'tipoPessoa.required' => 'O tipo de pessoa é obrigatório.',
            'tipoPessoa.in' => 'O tipo de pessoa deve ser PJ ou PF.',

            'telefone.required' => 'O telefone principal é obrigatório.',
            'telefone.max' => 'O telefone não pode ter mais que 20 caracteres.',
            'tipo_telefone.required' => 'O tipo de telefone é obrigatório.',
            'email.email' => 'O e-mail informado não é válido.',
            'email.max' => 'O e-mail não pode ter mais que 255 caracteres.',

            'contatos_adicionais.array' => 'Os contatos adicionais devem estar em formato de lista.',
            'contatos_adicionais.*.valor.required' => 'O valor do contato adicional é obrigatório.',
            'contatos_adicionais.*.rotulo.max' => 'O rótulo do contato adicional deve ter no máximo 50 caracteres.',

            'endereco_cep.required' => 'O CEP é obrigatório.',
            'endereco_logradouro.required' => 'O logradouro é obrigatório.',
            'endereco_numero.required' => 'O número é obrigatório.',
            'endereco_bairro.required' => 'O bairro é obrigatório.',
            'estado_id.required' => 'O estado é obrigatório.',
            'estado_id.exists' => 'O estado selecionado não existe.',
            'cidade_id.required' => 'A cidade é obrigatória.',
            'cidade_id.exists' => 'A cidade selecionada não existe.',
            'condominio_sim_nao.required' => 'Informe se é condomínio.',
            'condominio_sim_nao.in' => 'Valor inválido para o campo condomínio (use Sim ou Não).',

            'condominio_endereco.required_if' => 'O endereço do condomínio é obrigatório quando marcado como "Sim".',
            'condominio_numero.required_if' => 'O número do condomínio é obrigatório quando marcado como "Sim".',

            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'razao_social.required' => 'A razão social é obrigatória.',
            'nome_fantasia.required' => 'O nome fantasia é obrigatório.',
            'indicador_ie.required' => 'O indicador de inscrição estadual é obrigatório.',
            'indicador_ie.in' => 'Valor inválido para o indicador de inscrição estadual.',
            'recolhimento.required' => 'O campo recolhimento é obrigatório.',
            'recolhimento.in' => 'Valor inválido para o recolhimento.',
            'ativo_pj.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'nome_pf.required' => 'O nome é obrigatório para pessoa física.',
            'rg.required' => 'O RG é obrigatório.',
            'ativo_pf.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }

    protected function prepareForValidation(): void
    {
        
        if ($this->filled('endereco_uf')) {
            $estado = Estado::where('uf', $this->input('endereco_uf'))->first();
            if ($estado) {
                $this->merge([
                    'estado_id' => $estado->id,
                ]);
            }
        }

        if ($this->filled('endereco_cidade')) {
            $cidade = Cidade::where('codigo_ibge', $this->input('endereco_cidade'))->first();
            if ($cidade) {
                $this->merge([
                    'cidade_id' => $cidade->id,
                ]);
            }
        }
    }

}