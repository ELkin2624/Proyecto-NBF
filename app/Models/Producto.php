<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'codigo';
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
        'id_categoria',
        'imagen_url'
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

    // Relación con los detalles de las notas de compra
    public function detallesCompra()
    {
        return $this->hasMany(DetalleNotaCompra::class, 'codigo_producto');
    }
}
