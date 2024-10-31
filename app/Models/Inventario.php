<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';
    protected $primaryKey = 'id_inventario';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['ubicacion', 'id_sucursal'];

    // Desactivar timestamps
    public $timestamps = false;

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    // Relación con la tabla InventarioProducto (Relación muchos a muchos con productos)
   /* public function productos()
    {
        return $this->belongsToMany(Producto::class, 'inventario_producto', 'id_inventario', 'codigo_producto')
                    ->withPivot('cantidad'); // Incluimos la columna 'cantidad' en la relación pivot
    }*/
    public function inventarioProductos()
    {
        return $this->hasMany(InventarioProducto::class, 'id_inventario');
    }
}
