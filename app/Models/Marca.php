<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marca';
    protected $primaryKey = 'id_marca';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // Si tu tabla no tiene timestamps
    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_marca');
    }
}
