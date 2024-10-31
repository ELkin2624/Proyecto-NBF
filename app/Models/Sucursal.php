<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'sucursal';
    protected $primaryKey = 'id_sucursal';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nombre', 'direccion', 'telefono'];

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'id_sucursal');
    }
}
