<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;
    protected $table = 'bitacora';
    public $timestamps = false;

    protected $fillable = [
        'accion',
        'ip_usuario',
        'fecha',
        'hora',
        'detalles',
        'tabla_asociada',
        'id_usuario',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
