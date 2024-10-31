<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedido';

    protected $fillable = [
        'fecha_recepcion',
        'estado',
        'direccion',
        'id_cliente',
    ];

    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
