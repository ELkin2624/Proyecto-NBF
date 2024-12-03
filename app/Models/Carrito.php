<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;
    protected $table = 'carrito';
    protected $primaryKey = 'id_carrito';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['id_cliente'];

    public function items()
    {
        return $this->hasMany(CarritoItem::class, 'id_carrito');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
