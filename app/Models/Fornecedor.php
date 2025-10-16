<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

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