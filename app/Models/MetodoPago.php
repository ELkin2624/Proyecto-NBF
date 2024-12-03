<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;
    protected $table = 'metodo_pago';

    protected $primaryKey = 'id_metodo';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'detalle',
    ];

    public function notasVenta()
    {
        return $this->hasMany(NotaVenta::class, 'id_metodo');
    }
}
