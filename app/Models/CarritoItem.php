<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    use HasFactory;
    protected $table = 'carrito_item';
    protected $primaryKey = 'id_carrito_item';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['id_carrito', 'codigo_producto', 'cantidad', 'precio_unitario'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto', 'codigo');
    }

    public function carrito()
    {
        return $this->belongsTo(Carrito::class, 'id_carrito');
    }
}
