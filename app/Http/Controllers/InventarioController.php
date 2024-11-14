<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\InventarioProducto;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Suministro;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = InventarioProducto::with(['producto', 'inventario'])->get(); // Cargar inventarios con productos
        return inertia('GestionInventario/IndexInv', ['inventarios' => $inventarios]);
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $almacenes = Inventario::all(); //obtenemos los almacenes existentes
        $productos = Producto::all(); // Obtener todos los productos
        return inertia('GestionInventario/CreateInv', compact(['productos', 'almacenes', 'proveedores']));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'producto' => 'required|string|max:20',
            'ubicacion' => 'required|string|max:80',
            'cantidad' => 'required|integer',
            'precio_total' => 'required|numeric|min:0',
            'proveedor' => 'required|string|max:80',
            'fecha' => 'required|date',
        ]);

        //Verificar o crear proveedor, producto e inventario
        $proveedor = Proveedor::firstOrCreate(['nombre' => $validatedData['proveedor']]);
        $producto = Producto::firstOrCreate(['nombre' => $validatedData['producto']]);
        $inventario = Inventario::firstOrCreate(['ubicacion' => $validatedData['ubicacion']]);

        // Verificar o actualizar el producto en el inventario
        $inventarioProducto = InventarioProducto::firstOrNew([
            'id_inventario' => $inventario->id_inventario,
            'codigo_producto' => $producto->codigo,
        ]);

        if ($inventarioProducto->exists) {
            $inventarioProducto->increment('cantidad', $validatedData['cantidad']);
        } else {
            $inventarioProducto->cantidad = $validatedData['cantidad'];
            $inventarioProducto->save();
        }
        /*Suministro::create([
            'id_inventario' => $inventario->id_inventario,
            'id_proveedor' => $proveedor->id_proveedor,
            'codigo_producto' => $producto->codigo,
            'cantidad' => $validatedData['cantidad'],
            'precio_total' => $validatedData['precio_total'],
            'fecha' => $validatedData['fecha'],
        ]);*/

        return redirect()->route('inventario.index')->with('success', 'Existencias ingresadas exitosamente.');
    }

    // Método para controlar salidas de inventario
    public function salida()
    {
        // Lógica para manejar salidas de inventario
    }

    // Método para notificación de stock bajo
    public function notificacionesStock()
    {
        // Lógica para verificar productos con stock bajo
    }

    // Método para generar reportes de inventario
    public function reportes()
    {
    $inventarios = InventarioProducto::with(['producto', 'inventario'])->get();

    $reporteData = $inventarios->map(function ($inventarioProducto) {
        return [
            'producto' => $inventarioProducto->producto->nombre,
            'ubicacion' => $inventarioProducto->inventario->ubicacion,
            'cantidad' => $inventarioProducto->cantidad,
            'precio_total' => $inventarioProducto->precio_total,
        ];
    });

    return response()->json($reporteData);
    }
}
