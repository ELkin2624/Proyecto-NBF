<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'direccion',
        'tipo',
        'id_usuario',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
