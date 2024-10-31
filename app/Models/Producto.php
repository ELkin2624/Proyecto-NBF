<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto'; // Nombre correcto de la tabla
    protected $primaryKey = 'codigo'; // Clave primaria es 'codigo', no 'id'

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;


    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precioxmayor',
        'precioxmenor',
        'id_marca',
        'id_categoria'
    ];

    // Relación con la tabla Marca
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    // Relación con la tabla Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    /*public function inventarios() {
        return $this->belongsToMany(Inventario::class, 'inventario_producto', 'codigo_producto', 'id_inventario')
            ->withPivot('cantidad'); // Incluimos la columna 'cantidad' en la relación pivot
    }*/

    public function detallePedido()
    {
        return $this->hasMany(DetallePedido::class, 'codigo_producto');
    }

    public function detalleCotizacion()
    {
        return $this->hasMany(DetalleCotizacion::class, 'codigo_producto');
    }

    public function inventarioProducto()
    {
        return $this->hasMany(InventarioProducto::class, 'codigo_producto');
    }

    public function suministros()
    {
        return $this->hasMany(Suministro::class, 'codigo_producto');
    }
}
