<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fornecedor_id',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'ponto_referencia',
        'estado_id',
        'cidade_id',
        'condominio_sn',
        'condominio_endereco',
        'condominio_numero',
    ];

    protected $primaryKey = 'fornecedor_id';
    public $incrementing = false;
    protected $guarded = [];
    
    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }
    public function estado() {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    public function cidade() {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }
}