<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'COTIZACION';

    protected $fillable = [
        'fecha_recepcion',
        'estado',
        'direccion',
        'id_cliente',
    ];

    public function detalleCotizaciones()
    {
        return $this->hasMany(DetalleCotizacion::class, 'id_cotizacion');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
