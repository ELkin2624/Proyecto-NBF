<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;

    protected $table = 'nota_compra';
    protected $primaryKey = 'id_nota_compra';

    protected $fillable = [
        'id_proveedor',
        'fecha_orden',
        'fecha_entrega',
        'estado',
        'id_admin',
        'total',
        'fecha_creacion'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleNotaCompra::class, 'id_nota_compra');
    }

    public function historial()
    {
        return $this->hasMany(HistorialNotaCompra::class, 'id_nota_compra');
    }
}


