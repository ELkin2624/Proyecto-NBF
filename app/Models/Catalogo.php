<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;
    protected $table = 'CATALOGO';

    protected $fillable = [
        'nombre',
        'fecha',
        'estado',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'PRODUCTO_CATALOGO', 'id_catalogo', 'codigo_producto');
    }
}
