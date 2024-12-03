<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaVenta extends Model
{
    use HasFactory;
    protected $table = 'nota_venta';
    protected $primaryKey = 'id_venta';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    
    protected $fillable = [
        'fecha',
        'monto_total',
        'tipo',
        'id_referencia',
        'id_admin',
        'id_metodo',
        'estado',
    ];

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodo');
    }

    public function admin()
    {
        return $this->belongsTo(Administrador::class, 'id_admin');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleNotaVenta::class, 'id_venta');
    }
}
