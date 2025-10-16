<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;

    protected $table = 'fornecedores';

    protected $fillable = [
        'tipo_pessoa',
        'observacao',
    ];

    public function pessoaJuridica()
    {
        return $this->hasOne(FornecedorPj::class);
    }

    public function pessoaFisica()
    {
        return $this->hasOne(FornecedorPf::class);
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class);
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }
}