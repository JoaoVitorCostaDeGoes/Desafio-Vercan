<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FornecedorPf extends Model
{
    use HasFactory;
    protected $primaryKey = 'fornecedor_id';
    public $incrementing = false;
    protected $guarded = [];
    
    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }
}