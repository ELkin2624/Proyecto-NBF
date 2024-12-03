<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sucursal;
use App\Models\Inventario;
use App\Models\Bitacora;
use App\Http\Controllers\BitacoraController;

class AlmacenController extends Controller
{
    public function index() {
        $inventarios = Inventario::with(['sucursal'])->get();
        return Inertia::render('GestionInventario/IndexAlmacen', [
            'inventarios' => $inventarios
        ]);
    }

    public function create() {
        $sucursales = Sucursal::all();

        return Inertia::render('GestionInventario/CreateAlmacen', [
            'sucursales' => $sucursales,
        ]);
    }

    public function store(Request $request) {
        // Validación de los datos del inventario
        $validated = $request->validate([
            'ubicacion' => 'required|string|max:255',
            'id_sucursal' => 'required|integer|exists:sucursal,id_sucursal',
        ]);

        // Crear el nuevo inventario
        $inventario = Inventario::create($validated);
        
        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'INSERTAR ALMACÉN',
            'detalles' => 'Se ha creado un nuevo inventario en ubicación: ' . $inventario->ubicacion,
            'tabla_asociada' => 'inventarios',
        ]);

        // Redirigir al listado de inventarios
        return redirect()->route('almacenes.index')->with('success', 'Almacen creado exitosamente.');
    }

    public function edit($id) {
        // Traer el inventario específico
        $inventario = Inventario::findOrFail($id);
        // Traer todas las sucursales
        $sucursales = Sucursal::all();

        return Inertia::render('GestionInventario/EditAlmacen', [
            'inventario' => $inventario,
            'sucursales' => $sucursales,
        ]);
    }

    public function update(Request $request, $id) {
        // Validación de los datos del inventario
        $validated = $request->validate([
            'ubicacion' => 'required|string|max:255',
            'id_sucursal' => 'required|integer|exists:sucursal,id_sucursal',
        ]);

        // Buscar el inventario y actualizarlo
        $inventario = Inventario::findOrFail($id);
        $inventario->update($validated);

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ACTUALIZAR ALMACÉN',
            'detalles' => 'Se ha actualizado el inventario en ubicación: ' . $inventario->ubicacion,
            'tabla_asociada' => 'inventarios',
        ]);

        // Redirigir al listado de inventarios
        return redirect()->route('almacenes.index')->with('success', 'Almacen actualizado exitosamente.');
    }

    public function destroy($id) {
        // Buscar el inventario y eliminarlo
        $inventario = Inventario::findOrFail($id);
        $ubicacion = $inventario->ubicacion; // Guardar la ubicación antes de eliminar

        // Eliminar el inventario
        $inventario->delete();

        // Registrar la acción en la bitácora
        app(BitacoraController::class)->registrarAccion([
            'accion' => 'ELIMINAR ALMACÉN',
            'detalles' => 'Se ha eliminado el inventario en ubicación: ' . $ubicacion,
            'tabla_asociada' => 'inventarios',
        ]);

        // Redirigir al listado de inventarios
        return redirect()->route('almacenes.index')->with('success', 'Almacen eliminado exitosamente.');
    }
    
}
