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
use App\Models\Bitacora;
use App\Http\Controllers\BitacoraController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $almacenes = Inventario::all(); // Obtener los almacenes existentes
        $productos = Producto::all(); // Obtener todos los productos
        return inertia('GestionInventario/CreateInv', compact(['productos', 'almacenes', 'proveedores']));
    }

    public function edit(){

    }

    public function update(Request $request, InventarioProducto $inventarioProducto)
    {
        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $inventarioProducto->update($validated);

        return redirect()->route('inventario.index')->with('success', 'Inventario actualizado con éxito');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'producto' => 'required|string|max:50',
            'ubicacion' => 'required|string|max:80',
            'cantidad' => 'required|integer|min:1',
            'precio_total' => 'required|numeric|min:0',
            'proveedor' => 'required|string|max:80',
            'fecha' => 'required|date',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Verificar o crear proveedor, producto e inventario
            $proveedor = Proveedor::firstOrCreate(['nombre' => $validatedData['proveedor']]);
            $producto = Producto::firstOrCreate(['nombre' => $validatedData['producto']]);
            $inventario = Inventario::firstOrCreate(['ubicacion' => $validatedData['ubicacion']]);

            // Asegurar que se tiene un valor válido para `id_inventario`
            if (!$inventario->id_inventario) {
                throw new \Exception('Error al crear o recuperar el inventario.');
            }

            // Actualizar o crear el registro en inventario_producto
            $inventarioProducto = InventarioProducto::firstOrNew([
                'id_inventario' => $inventario->id_inventario,
                'codigo_producto' => $producto->codigo,
            ]);

            // Incrementar la cantidad si ya existe o establecer la cantidad inicial
            $inventarioProducto->cantidad = $inventarioProducto->exists
                ? $inventarioProducto->cantidad + $validatedData['cantidad']
                : $validatedData['cantidad'];

            $inventarioProducto->save();

            // Registro en bitácora
            app(BitacoraController::class)->registrarAccion([
                'accion' => 'INSERTAR INVENTARIO',
                'detalles' => 'Se ha ingresado existencias para el producto: ' . $producto->nombre . ' en ubicación: ' . $inventario->ubicacion,
                'tabla_asociada' => 'inventario_producto',
            ]);
        });
        return redirect()->route('inventario.index')->with('success', 'Existencias ingresadas exitosamente.');
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

            // Obtener el usuario autenticado
            $usuario = auth()->user();

            // Registro en bitácora
            app(BitacoraController::class)->registrarAccion([
                'accion' => 'GENERAR REPORTE',
                'detalles' => 'Se ha generado un reporte de inventario.',
                'tabla_asociada' => 'inventario_producto',
                'usuario_id' => $usuario ? $usuario->id : null, // Guardar el ID del usuario o null si no hay usuario autenticado
            ]);

            return response()->json($reporteData);
        }

}
