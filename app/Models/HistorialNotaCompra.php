<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialNotaCompra extends Model
{
    use HasFactory;

    protected $table = 'historial_nota_compra';
    protected $primaryKey = 'id_historial';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_nota_compra',
        'estado_anterior',
        'estado_nuevo',
        'detalles',
    ];

    public function notaCompra()
    {
        return $this->belongsTo(NotaCompra::class, 'id_nota_compra');
    }
}
