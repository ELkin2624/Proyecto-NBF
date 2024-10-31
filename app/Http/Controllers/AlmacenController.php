<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sucursal;
use App\Models\Inventario;


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
        Inventario::create($validated);

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

        // Redirigir al listado de inventarios
        return redirect()->route('almacenes.index')->with('success', 'Almacen actualizado exitosamente.');
    }

    public function destroy($id) {
        // Buscar el inventario y eliminarlo
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        // Redirigir al listado de inventarios
        return redirect()->route('almacenes.index')->with('success', 'Almacen eliminado exitosamente.');
    }
}
