<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCotizacion extends Model
{
    use HasFactory;
    protected $table = 'DETALLE_COTIZACION';

    protected $fillable = [
        'precio_unitario',
        'cantidad',
        'subtotal',
        'id_cotizacion',
        'codigo_producto',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'id_cotizacion');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto');
    }
}