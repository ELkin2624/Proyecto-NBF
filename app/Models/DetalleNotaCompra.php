<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleNotaCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_nota_compra';
    public $timestamps = false;
    protected $primaryKey = 'id_detalle_nota_compra';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_nota_compra',
        'codigo_producto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    // Relación con el modelo NotaCompra
    public function notaCompra()
    {
        return $this->belongsTo(NotaCompra::class, 'id_nota_compra');
    }

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto', 'codigo');
    }
}
