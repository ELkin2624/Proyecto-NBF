<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotaCompra;
use App\Models\DetalleNotaCompra;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\User;
use Inertia\Inertia;

class NotaCompraController extends Controller
{
    public function index()
    {
        $notasCompra = NotaCompra::with('proveedor')->get(); // Obtener las notas de compra con los proveedores
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return Inertia::render('Compras/NotaCompraIndex', [
            'notasCompra' => $notasCompra,
            'proveedores' => $proveedores,
            'productos' => $productos,
        ]);
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::all();
        return Inertia::render('Compras/NotaCompraForm', [
            'proveedores' => $proveedores,
            'productos' => $productos
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proveedor' => 'required|exists:proveedor,id_proveedor',
            'fecha_orden' => 'required|date',
            'total' => 'required|numeric',
            'productos' => 'required|array',
            'productos.*.codigo_producto' => 'required|string',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio_unitario' => 'required|numeric',
            'productos.*.subtotal' => 'required|numeric',
        ]);

        $proveedor = Proveedor::findOrFail($request->id_proveedor);
        $tiempoEntregaMeses = $proveedor->tiempo_entrega;

        $fechaOrden = now();
        $fechaEntrega = $fechaOrden->copy()->addMonths($tiempoEntregaMeses);

        $notaCompra = NotaCompra::create([
            'id_proveedor' => $request->id_proveedor,
            'fecha_orden' => $request->fecha_orden,
            'fecha_entrega' => $fechaEntrega,
            'estado' => 'En espera',
            'id_admin' => auth()->user()->id,
            'total' => $request->total,
        ]);

        foreach ($request->productos as $producto) {
            DetalleNotaCompra::create([
                'id_nota_compra' => $notaCompra->id_nota_compra,
                'codigo_producto' => $producto['codigo_producto'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal' => $producto['subtotal'],
            ]);
        }

        return Inertia::render('Compras/NotaCompraIndex', [
            'success' => true,
            'message' => 'Nota de compra creada correctamente.'
        ]);
    }

    public function actualizarEstado(Request $request, $id)
    {
        $notaCompra = NotaCompra::findOrFail($id);
        $notaCompra->estado = $request->estado;
        $notaCompra->save();

        return redirect()->route('nota-compra.index');
    }
}
