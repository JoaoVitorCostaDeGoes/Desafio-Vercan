<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contato extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $fillable = [
        'fornecedor_id',
        'nome',
        'cargo',
        'empresa',
        'contato',
        'tipo_contato',
        'rotulo',
        'principal'
    ];

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }
}