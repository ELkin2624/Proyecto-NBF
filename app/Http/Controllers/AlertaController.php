<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventarioProducto;
use App\Models\Proveedor;

class AlertaController extends Controller
{
    public function index()
    {
        $alertas = [];

        // Alertas de productos
        $productos = InventarioProducto::where('cantidad', '<=', '90')->get();
        foreach ($productos as $producto) {
            $alertas[] = [
                'id' => $producto->codigo_producto,
                'nombre' => $producto->producto->nombre,
                'mensaje' => "El producto {$producto->producto->nombre} necesita reabastecimiento.",
            ];
        }

        return response()->json($alertas);
    }
}
