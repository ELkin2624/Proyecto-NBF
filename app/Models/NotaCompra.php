<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaCompra extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'nota_compra';
    protected $primaryKey = 'id_nota_compra';

=======
    // Define el nombre de la tabla
    protected $table = 'nota_compra';
    protected $primaryKey = 'id_nota_compra';

    // Define los campos que son asignables
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
    protected $fillable = [
        'id_proveedor',
        'fecha_orden',
        'fecha_entrega',
        'estado',
        'id_admin',
        'total',
        'fecha_creacion'
    ];

<<<<<<< HEAD
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin');
    }

=======
    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    // Relación con los detalles de la nota de compra
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
    public function detalles()
    {
        return $this->hasMany(DetalleNotaCompra::class, 'id_nota_compra');
    }
<<<<<<< HEAD

    public function historial()
    {
        return $this->hasMany(HistorialNotaCompra::class, 'id_nota_compra');
    }
}


=======
}
>>>>>>> 6cf30f3e27725b61240137af4a843b2a842836f5
