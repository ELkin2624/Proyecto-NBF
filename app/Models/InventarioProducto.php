<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioProducto extends Model
{
    use HasFactory;

    protected $table = 'inventario_producto';
    public $timestamps = false; // No usa las columnas created_at/updated_at
    public $incrementing = false; // Indica que no tiene una clave autoincremental
    protected $primaryKey = null;
    protected $fillable = ['id_inventario', 'codigo_producto', 'cantidad'];

    public static function incrementCantidad($id_inventario, $codigo_producto, $cantidad)
    {
        return self::where('id_inventario', $id_inventario)
            ->where('codigo_producto', $codigo_producto)
            ->increment('cantidad', $cantidad);
    }

    // Relación con Inventario
    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }
    
    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto');
    }
}
