<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Contato extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'fornecedor_id',
        'contato',
        'tipo_contato',
        'rotulo',
        'principal',
    ];

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }
}