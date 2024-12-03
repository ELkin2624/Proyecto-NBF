<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Inertia\Inertia;
use App\Models\Bitacora;
use App\Http\Controllers\BitacoraController;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Proveedor::query();

        // Filtrar por nombre, teléfono y tiempo de entrega
        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        if ($request->has('telefono')) {
            $query->where('telefono', 'like', '%' . $request->telefono . '%');
        }
        if ($request->has('tiempo_entrega')) {
            $query->where('tiempo_entrega', '<=', $request->tiempo_entrega);
        }

        // Obtener los resultados
        $proveedores = $query->get();

        return Inertia::render('Compras/ProveedorIndex', [
            'proveedores' => $proveedores,
        ]);
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|string|max:10',
            'tiempo_entrega' => 'required|integer|min:1',
            'productos' => 'array'
        ]);

        // Crear un nuevo proveedor con los datos validados
        $proveedor = Proveedor::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'tiempo_entrega' => $request->tiempo_entrega,
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'CREAR PROVEEDOR',
            'detalles' => 'Se ha creado un nuevo proveedor: ' . $proveedor->nombre . ' con teléfono: ' . $proveedor->telefono,
            'tabla_asociada' => 'proveedores',
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|string|max:10',
            'tiempo_entrega' => 'required|integer|min:1'
        ]);

        // Buscar el proveedor por ID
        $proveedor = Proveedor::findOrFail($id);

        // Actualizar los datos del proveedor
        $proveedor->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'tiempo_entrega' => $request->tiempo_entrega,
        ]);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ACTUALIZAR PROVEEDOR',
            'detalles' => 'Se ha actualizado la información del proveedor: ' . $proveedor->nombre,
            'tabla_asociada' => 'proveedores',
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        // Buscar el proveedor por ID
        $proveedor = Proveedor::findOrFail($id);
        $nombreProveedor = $proveedor->nombre; // Guardar el nombre del proveedor antes de eliminar

        // Eliminar el proveedor
        $proveedor->delete();

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ELIMINAR PROVEEDOR',
            'detalles' => 'Se ha eliminado el proveedor: ' . $nombreProveedor,
            'tabla_asociada' => 'proveedores',
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
