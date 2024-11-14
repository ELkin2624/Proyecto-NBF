<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Inertia\Inertia;

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
        Proveedor::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'tiempo_entrega' => $request->tiempo_entrega,
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

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        // Eliminar el proveedor
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }

}

