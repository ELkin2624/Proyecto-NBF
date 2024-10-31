<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $table = 'DETALLE_PEDIDO';

    protected $fillable = [
        'precio_unitario',
        'cantidad',
        'subtotal',
        'id_pedido',
        'codigo_producto',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto');
    }
}
