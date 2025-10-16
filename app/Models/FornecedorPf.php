<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FornecedorPf extends Model
{
    use SoftDeletes;

    protected $table = 'fornecedor_pf';

    protected $fillable = [
        'fornecedor_id',
        'cpf',
        'nome',
        'apelido',
        'rg',
        'ativo',
    ];

    protected $primaryKey = 'fornecedor_id';
    public $incrementing = false;
    protected $guarded = [];
    
    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }
}