<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleNotaVenta extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_detalle_nota_venta';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $table = 'detalle_nota_venta';
    protected $fillable = [
        'id_venta',
        'codigo_producto',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto', 'codigo');
    }

    public function notaVenta()
    {
        return $this->belongsTo(NotaVenta::class, 'id_venta');
    }
}
