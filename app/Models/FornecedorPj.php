<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FornecedorPj extends Model
{
    use SoftDeletes;

    protected $table = 'fornecedor_pj';

    protected $fillable = [
        'fornecedor_id',
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'indicador_ie',
        'inscricao_estadual',
        'inscricao_municipal',
        'situacao_cnpj',
        'recolhimento',
        'ativo',
    ];


    protected $primaryKey = 'fornecedor_id';
    public $incrementing = false;
    protected $guarded = []; 
    
    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }
}
