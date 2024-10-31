<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false; // Si tu tabla no tiene timestamps
    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}
