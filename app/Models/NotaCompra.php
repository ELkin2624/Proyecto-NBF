<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;

    // Define el nombre de la tabla
    protected $table = 'nota_compra';
    protected $primaryKey = 'id_nota_compra';

    // Define los campos que son asignables
    protected $fillable = [
        'id_proveedor',
        'fecha_orden',
        'fecha_entrega',
        'estado',
        'id_admin',
        'total',
        'fecha_creacion'
    ];

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    // Relación con los detalles de la nota de compra
    public function detalles()
    {
        return $this->hasMany(DetalleNotaCompra::class, 'id_nota_compra');
    }
}
