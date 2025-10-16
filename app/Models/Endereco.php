<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Endereco extends Model
{
    use HasFactory;
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