<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;


class Bitacora extends Model
{
    use HasFactory;
<<<<<<< HEAD

    protected $table = 'bitacora';
    protected $primaryKey = 'id_bitacora';
=======
    protected $table = 'bitacora';
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
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


