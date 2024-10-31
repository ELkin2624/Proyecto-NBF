<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    // Definir la tabla asociada si no sigue la convención de nombres
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    // Definir los atributos que son asignables en masa
    protected $fillable = [
        'nombre',
        'telefono',
        'tiempo_entrega',
    ];

    // Si necesitas establecer relaciones, puedes hacerlo aquí
    public function suministros()
    {
        return $this->hasMany(Suministro::class, 'id_proveedor');
    }
}
