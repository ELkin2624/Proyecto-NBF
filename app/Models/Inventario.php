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

    public function inventarioProductos()
    {
        return $this->hasMany(InventarioProducto::class, 'id_inventario');
    }
}
