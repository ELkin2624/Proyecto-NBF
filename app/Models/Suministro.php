<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suministro extends Model
{
    use HasFactory;
    // Definimos la tabla que el modelo representa, por si el nombre difiere del pluralizado estándar
    protected $table = 'suministro';

    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    // Indicamos las columnas que pueden ser llenadas mediante asignación masiva
    protected $fillable = [
        'id_inventario',
        'id_proveedor',
        'codigo_producto',
        'cantidad',
        'precio_total',
        'fecha'
    ];

    // Relación con el modelo Inventario (uno a muchos inversa)
    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }

    // Relación con el modelo Proveedor (uno a muchos inversa)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    // Relación con el modelo Producto (uno a muchos inversa)
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto');
    }
}
