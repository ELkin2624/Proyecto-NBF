<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use Inertia\Inertia;


class ProductoController extends Controller
{
    public function index()
    {
        // Obtener productos con marca y categoría
        $productos = Producto::with('marca', 'categoria')->get();
        $marcas = Marca::all();
        $categorias = Categoria::all();

        return Inertia::render('GestionInventario/ProdIndex', [
            'productos' => $productos,
            'marcas' => $marcas,
            'categorias' => $categorias
        ]);
    }

    public function create()
    {
        // Obtener marcas y categorías para el formulario
        $marcas = Marca::all();
        $categorias = Categoria::all();

        return Inertia::render('GestionInventario/CreateP', [
            'marcas' => $marcas,
            'categorias' => $categorias
        ]);
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'codigo' => 'required|unique:producto,codigo',
            'nombre' => 'required|max:100',
            'descripcion' => 'nullable|string',
            'precioxmayor' => 'required|numeric',
            'precioxmenor' => 'required|numeric',
            'id_marca' => 'required|exists:marca,id_marca',
            'id_categoria' => 'required|exists:categoria,id_categoria',
        ]);

        // Crear producto
        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
    }

    public function edit($codigo)
    {
        $producto = Producto::where('codigo', $codigo)->first();
        $marcas = Marca::all();
        $categorias = Categoria::all();

        return Inertia::render('Productos/Edit', [
            'producto' => $producto,
            'marcas' => $marcas,
            'categorias' => $categorias
        ]);
    }

    public function update(Request $request, $codigo)
    {
        // Validar datos
        $validatedData = $request->validate([
            'nombre' => 'required|max:100',
            'descripcion' => 'required',
            'precioxmayor' => 'required|numeric',
            'precioxmenor' => 'required|numeric',
            'id_marca' => 'required|exists:marca,id_marca',
            'id_categoria' => 'required|exists:categoria,id_categoria',
        ]);

        // Actualizar producto
        $producto = Producto::findOrFail($codigo);
        $producto->update($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy($codigo)
    {
        Producto::where('codigo', $codigo)->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }
}
