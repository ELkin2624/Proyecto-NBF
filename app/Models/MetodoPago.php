<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;
    protected $table = 'METODO_PAGO';

    protected $fillable = [
        'nombre',
        'detalle',
    ];

    public function notasVenta()
    {
        return $this->hasMany(NotaVenta::class, 'id_metodo');
    }
}
